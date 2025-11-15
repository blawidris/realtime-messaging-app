<?php

namespace App\Observers;

use App\Models\Task;
use App\Services\ActivityLogService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Storage;

class TaskObserver
{
    public function __construct(
        private ActivityLogService $activityLog,
        private NotificationService $notificationService
    ) {}

    public function created(Task $task): void
    {
        // Activity log is handled in TaskService
        // But you can add additional logic here
    }

    public function updated(Task $task): void
    {
        // Check if status changed
        if ($task->isDirty('status_id')) {
            $oldStatusId = $task->getOriginal('status_id');
            $oldStatus = \App\Models\Status::find($oldStatusId);
            $newStatus = $task->status;

            // If moved to completed
            if ($newStatus->is_closed && !$oldStatus->is_closed) {
                // Additional completion logic
            }
        }
    }

    public function deleting(Task $task): void
    {
        // Cascade delete related data
        $task->comments()->delete();
        $task->attachments()->each(function ($attachment) {
            Storage::disk($attachment->disk)->delete($attachment->path);
            $attachment->delete();
        });
        $task->timeEntries()->delete();
    }
}
