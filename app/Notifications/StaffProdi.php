<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StaffProdi extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $nama;
    protected $tahun;
    protected $mitra;
    public function __construct($nama, $tahun, $mitra)
    {
        $this->nama = $nama;
        $this->tahun = $tahun;
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
            'background' => 'bg-success',
            'icon' => 'mdi mdi-account-check',
            'heading' => 'Informasi Magang',
            'message' => 'Mahasiswa Angkatan Akademik Tahun ' . $this->tahun . ' dengan nama ' . $this->nama .' telah diterima magang oleh ' . $this->mitra . '. Silahkan pilih dosen pembimbing untuk mahasiswa ini.',
        ];
    }
}
