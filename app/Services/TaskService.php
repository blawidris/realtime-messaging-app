<?php

namespace App\Services;

use App\Models\Priority;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TaskService
{
    public function __construct(
        private ActivityLogService $activityLog,
        private NotificationService $notificationService
    ) {}


    public function paginated(Request $request)
    {

        $query = Task::with(['status', 'priority', 'creator', 'assignees', 'project']);

        // Filters
        if ($request->query("project")) {
            $query->forProject(Project::getId($request->project));
        }

        if ($request->query('status')) {
            $query->where('status_id', Status::getId($request->status));
        }

        if ($request->query('priority')) {
            $query->where('priority_id', Priority::getId($request->priority));
        }

        if ($request->assigned_to_me) {
            $query->assignedTo(request()->id());
        }

        if ($request->overdue) {
            $query->overdue();
        }

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $tasks = $query->ordered()->paginate($request->per_page ?? 50);

        return $tasks;
    }

    public function createTask(array $data, User $creator): Task
    {
        return DB::transaction(function () use ($data, $creator) {
            // Get max position for this project/status
            $maxPosition = Task::where('project_id', $data['project_id'])
                ->where('status_id', $data['status_id'])
                ->max('position') ?? 0;

            $task = Task::create([
                'project_id' => $data['project_id'],
                'parent_task_id' => $data['parent_task_id'] ?? null,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'status_id' => $data['status_id'],
                'priority_id' => $data['priority_id'] ?? null,
                'created_by' => $creator->id,
                'position' => $maxPosition + 1,
                'estimated_hours' => $data['estimated_hours'] ?? 0,
                'due_at' => $data['due_at'] ?? null,
                'metadata' => $data['metadata'] ?? [],
            ]);

            // Auto-assign if provided
            if (!empty($data['assignees'])) {
                foreach ($data['assignees'] as $userId) {
                    $task->assignTo(User::find($userId), $creator);
                }
            }

            // Log activity
            $this->activityLog->log('created', $task, $creator, [
                'description' => "Created task: {$task->title}",
            ]);

            // Clear project cache
            $this->clearProjectCache($task->project_id);

            return $task->load(['creator', 'status', 'priority', 'assignees']);
        });
    }

    public function updateTask(Task $task, array $data): Task
    {
        return DB::transaction(function () use ($task, $data) {
            $oldValues = $task->only(['title', 'description', 'status_id', 'priority_id', 'due_at']);

            $task->update($data);

            // Check if status changed
            if (isset($data['status_id']) && $data['status_id'] != $oldValues['status_id']) {
                $this->notificationService->notifyTaskStatusChange($task);
            }

            // Log activity
            $this->activityLog->log('updated', $task, request()->user(), [
                'description' => "Updated task: {$task->title}",
                'old' => $oldValues,
                'new' => $task->only(array_keys($oldValues)),
            ]);

            $this->clearProjectCache($task->project_id);

            return $task->fresh();
        });
    }

    public function assignTask(Task $task, User $assignee): Task
    {
        if ($task->isAssignedTo($assignee)) {
            throw new \Exception('User is already assigned to this task');
        }

        $task->assignTo($assignee, request()->user());

        $this->activityLog->log('assigned', $task, request()->user(), [
            'description' => "Assigned task to {$assignee->name}",
            'assignee_id' => $assignee->id,
        ]);

        // Notify assignee
        $this->notificationService->notifyTaskAssignment($task, $assignee);

        return $task->fresh('assignees');
    }

    public function unassignTask(Task $task, User $assignee): Task
    {
        if (!$task->isAssignedTo($assignee)) {
            throw new \Exception('User is not assigned to this task');
        }

        $task->unassignFrom($assignee);

        $this->activityLog->log('unassigned', $task, request()->user(), [
            'description' => "Unassigned {$assignee->name} from task",
            'assignee_id' => $assignee->id,
        ]);

        return $task->fresh('assignees');
    }

    public function changeStatus(Task $task, int $newStatusId): Task
    {
        $oldStatus = $task->status;
        $newStatus = Status::findOrFail($newStatusId);

        $task->update(['status_id' => $newStatusId]);

        $this->activityLog->log('status_changed', $task, request()->user(), [
            'description' => "Changed status from {$oldStatus->name} to {$newStatus->name}",
            'old_status' => $oldStatus->name,
            'new_status' => $newStatus->name,
        ]);

        // If moved to closed status, mark completion
        if ($newStatus->is_closed && !$oldStatus->is_closed) {
            $this->notificationService->notifyTaskCompleted($task);
        }

        $this->notificationService->notifyTaskStatusChange($task);
        $this->clearProjectCache($task->project_id);

        return $task->fresh('status');
    }

    public function changePriority(Task $task, int $newPriorityId): Task
    {
        $task->update(['priority_id' => $newPriorityId]);

        $this->activityLog->log('priority_changed', $task, request()->user(), [
            'description' => "Changed priority to {$task->priority->name}",
        ]);

        return $task->fresh('priority');
    }

    public function reorderTasks(Project $project, int $statusId, array $taskIds): void
    {
        DB::transaction(function () use ($project, $statusId, $taskIds) {
            foreach ($taskIds as $position => $taskId) {
                Task::where('id', $taskId)
                    ->where('project_id', $project->id)
                    ->update([
                        'position' => $position,
                        'status_id' => $statusId,
                    ]);
            }
        });

        $this->clearProjectCache($project->id);
    }

    public function deleteTask(Task $task): bool
    {
        return DB::transaction(function () use ($task) {
            $this->activityLog->log('deleted', $task, request()->user(), [
                'description' => "Deleted task: {$task->title}",
            ]);

            $projectId = $task->project_id;
            $task->delete();
            $this->clearProjectCache($projectId);

            return true;
        });
    }

    private function clearProjectCache(?int $projectId): void
    {
        if ($projectId) {
            Cache::forget("project.{$projectId}.stats");
        }
    }
}
