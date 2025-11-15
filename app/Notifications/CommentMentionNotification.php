<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentMentionNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Comment $comment,
        public string $mentionedByName
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $commentable = $this->comment->commentable;
        $type = class_basename($commentable);
        $name = $commentable->title ?? $commentable->name;

        return (new MailMessage)
            ->subject("{$this->mentionedByName} mentioned you in a comment")
            ->line("{$this->mentionedByName} mentioned you in a comment on {$type}: {$name}")
            ->line('**Comment:** ' . substr($this->comment->content, 0, 200))
            ->action('View Comment', url("/{$type}s/{$commentable->id}#comment-{$this->comment->id}"))
            ->line('Click above to view the full comment.');
    }

    public function toArray($notifiable): array
    {
        $commentable = $this->comment->commentable;

        return [
            'comment_id' => $this->comment->id,
            'commentable_type' => get_class($commentable),
            'commentable_id' => $commentable->id,
            'commentable_title' => $commentable->title ?? $commentable->name,
            'mentioned_by' => $this->mentionedByName,
            'message' => "{$this->mentionedByName} mentioned you in a comment",
        ];
    }
}
