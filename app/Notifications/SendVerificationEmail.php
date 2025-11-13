<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;


class SendVerificationEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected object $user)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Generate a temporary signed verification URL (valid for 24 hours)
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->greeting('Hello ' . $this->user->firstname . ',')
            ->line('Welcome to our platform! Please verify your email address by clicking the button below.')
            ->action('Verify Email', $verificationUrl)
            ->line('This link will expire in 24 hours.')
            ->line('If you did not create an account, please ignore this email.');
    }


    /**
     * Generate a temporary signed route URL for email verification.
     */
    protected function verificationUrl($notifiable): string
    {
        // Base domain for your backend (e.g. from .env)
        $frontendUrl = config('app.frontend_url');

        // Generate the signed route
        $temporaryUrl = URL::temporarySignedRoute(
            'auth.register.verify-email',
            now()->addHours(24),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        // Extract only the signed query string from the temporary URL
        $query = parse_url($temporaryUrl, PHP_URL_QUERY);

        // Build your custom domain verification link
        return "{$frontendUrl}/verify-email?{$query}";
    }

  
}
