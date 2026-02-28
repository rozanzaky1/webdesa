<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $resetLink;
    public $userName;

    /**
     * Create a new notification instance.
     */
    public function __construct($resetLink, $userName)
    {
        $this->resetLink = $resetLink;
        $this->userName = $userName;
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
        return (new MailMessage)
            ->subject('Reset Password - Kampung Badran Sari')
            ->greeting('Halo, ' . $this->userName . '!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
            ->line('Klik tombol di bawah ini untuk mereset password Anda:')
            ->action('Reset Password', $this->resetLink)
            ->line('Link reset password ini akan expired dalam 24 jam.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->line('Terima kasih!')
            ->salutation('Salam,')
            ->salutation('Tim Kampung Badran Sari');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'reset_link' => $this->resetLink,
            'user_name' => $this->userName,
        ];
    }
}
