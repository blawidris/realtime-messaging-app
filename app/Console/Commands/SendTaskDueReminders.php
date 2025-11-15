<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendTaskDueReminders extends Command
{
    protected $signature = 'tasks:send-due-reminders';
    protected $description = 'Send notifications for tasks due in the next 24 hours';

    public function handle(NotificationService $notificationService): int
    {
        $tasks = Task::whereBetween('due_at', [now(), now()->addDay()])
            ->whereHas('status', fn($q) => $q->where('is_closed', false))
            ->with('assignees')
            ->get();

        $count = 0;
        foreach ($tasks as $task) {
            $notificationService->notifyDueDateApproaching($task);
            $count++;
        }

        $this->info("Sent due date reminders for {$count} tasks.");
        return self::SUCCESS;
    }
}
