<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeniedIntern extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $mitra;
    public function __construct($mitra)
    {
        $this->mitra = $mitra;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'background' => 'bg-danger',
            'icon' => 'mdi mdi-account-remove',
            'heading' => 'Ditolak Magang',
            'message' => 'Mohon maaf kamu belum diterima di ' . $this->mitra . '. Silahkan cari tempat magang yang lain.',
        ];
    }
}
