<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountApprovedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
        return (new MailMessage)
            ->subject('Akun Anda Telah Diverifikasi - Desa Badran Sari')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Selamat! Akun Anda telah diverifikasi oleh administrator.')
            ->line('Anda sekarang dapat mengakses semua layanan yang tersedia di Sistem Informasi Desa Badran Sari.')
            ->action('Login Sekarang', url('/login'))
            ->line('Silakan login dengan email dan password yang Anda daftarkan.')
            ->line('Terima kasih telah bergabung dengan kami!')
            ->salutation('Salam,')
            ->salutation('Tim Desa Badran Sari');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Akun Anda telah diverifikasi dan sekarang dapat digunakan.',
            'approved_at' => now()->toDateTimeString(),
        ];
    }
}
