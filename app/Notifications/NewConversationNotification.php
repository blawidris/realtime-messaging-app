<?php

namespace App\Notifications;

use App\Models\Conversation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewConversationNotification extends Notification
{
    use Queueable;

    public function __construct(public Conversation $conversation, public $creator) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $url = config('app.frontend_url') . "/chat/{$this->conversation->id}";

        return (new MailMessage)
            ->subject('New Conversation Started')
            ->line("{$this->creator->name} started a new conversation with you.")
            ->action('Open Chat', $url);
    }

    public function toArray($notifiable)
    {
        return [
            'conversation_id' => $this->conversation->id,
            'creator' => $this->creator->only(['id', 'name']),
        ];
    }
}
