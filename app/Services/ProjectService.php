<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProjectService
{
    public function __construct() {}

    public function createProject(array $data, User $creator): Project
    {
        return DB::transaction(function () use ($data, $creator) {
            $project = Project::create([
                'tenant_id' => $creator->currentTenant->id,
                'created_by' => $creator->id,
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'status_id' => $data['status_id'] ?? Status::getDefault('project'),
                'start_at' => $data['start_at'] ?? null,
                'due_at' => $data['due_at'] ?? null,
                'parent_id' => $data['parent_id'] ?? null,
                'meta' => $data['meta'] ?? [],
            ]);

            // Add creator as project manager
            $project->addMember($creator, 'manager');

            // Log activity
            // $this->activityLog->log('created', $project, $creator, [
            //     'description' => "Created project: {$project->name}",
            // ]);

            return $project->load(['creator', 'status', 'members']);
        });
    }

    public function updateProject(Project $project, array $data): Project
    {
        return DB::transaction(function () use ($project, $data) {
            $oldValues = $project->only(['name', 'description', 'status_id', 'due_at']);

            $project->update($data);

            // Log activity
            // $this->activityLog->log('updated', $project, auth()->user(), [
            //     'description' => "Updated project: {$project->name}",
            //     'old' => $oldValues,
            //     'new' => $project->only(array_keys($oldValues)),
            // ]);

            // Clear cache
            $this->clearProjectCache($project);

            return $project->fresh();
        });
    }

    public function archiveProject(Project $project): bool
    {
        $archivedStatus = Status::where('slug', 'archived')
            ->where('type', 'project')
            ->first();

        if (!$archivedStatus) {
            throw new \Exception('Archived status not found');
        }

        $project->update(['status_id' => $archivedStatus->id]);

        // $this->activityLog->log('archived', $project, auth()->user(), [
        //     'description' => "Archived project: {$project->name}",
        // ]);

        return true;
    }

    public function deleteProject(Project $project): bool
    {
        return DB::transaction(function () use ($project) {
            // $this->activityLog->log('deleted', $project, auth()->user(), [
            //     'description' => "Deleted project: {$project->name}",
            // ]);

            $project->delete();
            $this->clearProjectCache($project);

            return true;
        });
    }

    public function addMember(Project $project, User $user, string $role = 'member'): void
    {
        if ($project->hasMember($user)) {
            throw new \Exception('User is already a member of this project');
        }

        $project->addMember($user, $role);

        // $this->activityLog->log('member_added', $project, auth()->user(), [
        //     'description' => "Added {$user->name} as {$role}",
        //     'member_id' => $user->id,
        //     'role' => $role,
        // ]);

        // Notify user
        $user->notify(new \App\Notifications\ProjectInvitationNotification($project));
    }

    public function removeMember(Project $project, User $user): void
    {
        if (!$project->hasMember($user)) {
            throw new \Exception('User is not a member of this project');
        }

        $project->removeMember($user);

        // $this->activityLog->log('member_removed', $project, auth()->user(), [
        //     'description' => "Removed {$user->name} from project",
        //     'member_id' => $user->id,
        // ]);
    }

    public function getProjectStats(Project $project): array
    {
        return Cache::remember("project.{$project->id}.stats", 300, function () use ($project) {
            $totalTasks = $project->tasks()->count();
            $completedTasks = $project->tasks()
                ->whereHas('status', fn($q) => $q->where('is_closed', true))
                ->count();
            $overdueTasks = $project->tasks()->overdue()->count();

            return [
                'total_tasks' => $totalTasks,
                'completed_tasks' => $completedTasks,
                'in_progress_tasks' => $totalTasks - $completedTasks,
                'overdue_tasks' => $overdueTasks,
                'completion_percentage' => $totalTasks > 0
                    ? round(($completedTasks / $totalTasks) * 100, 2)
                    : 0,
                'total_members' => $project->members()->count(),
                'total_hours_estimated' => $project->tasks()->sum('estimated_hours'),
                'total_hours_actual' => $project->tasks()->sum('actual_hours'),
            ];
        });
    }

    private function clearProjectCache(Project $project): void
    {
        Cache::forget("project.{$project->id}.stats");
    }
}
