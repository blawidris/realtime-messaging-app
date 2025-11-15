<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Task $task,
        public ?string $assignedByName = null
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Task Assigned: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->assignedByName . ' assigned you a new task.')
            ->line('**Task:** ' . $this->task->title)
            ->line('**Project:** ' . $this->task->project->name)
            ->when($this->task->due_at, function ($mail) {
                return $mail->line('**Due Date:** ' . $this->task->due_at->format('M d, Y'));
            })
            ->action('View Task', url("/tasks/{$this->task->id}"))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_id' => $this->task->project_id,
            'project_name' => $this->task->project->name,
            'assigned_by' => $this->assignedByName,
            'due_at' => $this->task->due_at?->toISOString(),
            'message' => "{$this->assignedByName} assigned you to: {$this->task->title}",
        ];
    }
}
