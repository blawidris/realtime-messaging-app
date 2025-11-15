<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendTaskOverdueNotifications extends Command
{
    protected $signature = 'tasks:send-overdue-notifications';
    protected $description = 'Send notifications for overdue tasks';

    public function handle(NotificationService $notificationService): int
    {
        $notificationService->notifyOverdueTasks();
        $this->info("Sent overdue notifications.");
        return self::SUCCESS;
    }
}
