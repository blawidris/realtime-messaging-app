<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDueSoonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Task $task) {}

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $hoursUntilDue = now()->diffInHours($this->task->due_at);

        return (new MailMessage)
            ->subject('Task Due Soon: ' . $this->task->title)
            ->line("Your task **{$this->task->title}** is due in {$hoursUntilDue} hours.")
            ->line('**Project:** ' . $this->task->project->name)
            ->line('**Due Date:** ' . $this->task->due_at->format('M d, Y g:i A'))
            ->action('View Task', url("/tasks/{$this->task->id}"))
            ->line('Please ensure you complete it on time.');
    }

    public function toArray($notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'due_at' => $this->task->due_at->toISOString(),
            'message' => "Task '{$this->task->title}' is due soon",
        ];
    }
}
