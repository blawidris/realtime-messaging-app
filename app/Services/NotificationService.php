<?php

namespace App\Services;

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\TaskStatusChangedNotification;
use App\Notifications\TaskDueSoonNotification;
use App\Notifications\TaskOverdueNotification;
use App\Notifications\TaskCompletedNotification;

class NotificationService
{
    public function notifyTaskAssignment(Task $task, User $assignee): void
    {
        $assignedBy = request()->user();

        $assignee->notify(
            new TaskAssignedNotification($task, $assignedBy->name)
        );

       
    }

    public function notifyTaskStatusChange(Task $task): void
    {
        $changedBy = request()->user();

        // Get old status from activity log or pass it as parameter
        $oldStatus = $task->getOriginal('status_id');
        $oldStatusName = \App\Models\Status::find($oldStatus)?->name ?? 'Unknown';

        // Notify all assignees
        foreach ($task->assignees as $assignee) {
            if ($assignee->id !== $changedBy->id) {
                $assignee->notify(
                    new TaskStatusChangedNotification(
                        $task,
                        $oldStatusName,
                        $task->status->name,
                        $changedBy->name
                    )
                );
            }
        }
    }

    public function notifyTaskCompleted(Task $task): void
    {
        $completedBy = request()->user();

        // Notify task creator if different from completer
        if ($task->creator && $task->creator->id !== $completedBy->id) {
            $task->creator->notify(
                new TaskCompletedNotification($task, $completedBy->name)
            );
        }

        // Notify project managers
        $managers = $task->project->members()
            ->wherePivot('role', 'manager')
            ->get();

        foreach ($managers as $manager) {
            if ($manager->id !== $completedBy->id) {
                $manager->notify(
                    new TaskCompletedNotification($task, $completedBy->name)
                );
            }
        }
    }

    public function notifyDueDateApproaching(Task $task): void
    {
        foreach ($task->assignees as $assignee) {
            $assignee->notify(new TaskDueSoonNotification($task));
        }
    }

    public function notifyOverdueTasks(): void
    {
        $overdueTasks = Task::overdue()
            ->with('assignees')
            ->get();

        foreach ($overdueTasks as $task) {
            foreach ($task->assignees as $assignee) {
                $assignee->notify(new TaskOverdueNotification($task));
            }
        }
    }
}
