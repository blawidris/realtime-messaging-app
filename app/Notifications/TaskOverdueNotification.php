<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskOverdueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Task $task) {}

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Task Overdue: ' . $this->task->title)
            ->line("Your task **{$this->task->title}** is overdue.")
            ->line('**Project:** ' . $this->task->project->name)
            ->line('**Was Due:** ' . $this->task->due_at->format('M d, Y'))
            ->action('View Task', url("/tasks/{$this->task->id}"))
            ->line('Please update the status or extend the deadline.');
    }

    public function toArray($notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'due_at' => $this->task->due_at->toISOString(),
            'message' => "Task '{$this->task->title}' is overdue",
        ];
    }
}
