<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplyIntern extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $nama;
    protected $tahun;
    protected $prodi;
    public function __construct($nama, $tahun, $prodi)
    {
        $this->nama = $nama;
        $this->tahun = $tahun;
        $this->prodi = $prodi;

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
            'background' => 'bg-info',
            'icon' => 'mdi mdi-information-outline',
            'heading' => 'Mengajukan Magang',
            'message' => 'Mahasiswa dengan nama '. $this->nama .' dari Prodi ' . $this->prodi . ' Tahun Akademik ' . $this->tahun . ' Mendaftar Magang. Silahkan Cek Di Halaman Pengajuan Magang,',
        ];
    }
}
