<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejectOrganization extends Notification
{
    use Queueable;

    protected $organization;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct($organization) {
        $this->organization = $organization;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Lembaga Anda ditolak - WakafKu")
            ->line('Lembaga yang diajukan ditolak oleh Admin WakafKu dengan data sebagai berikut')
            ->line('Nama Lembaga : '.$this->organization->user->name)
            ->line('Tahun berdiri : '.$this->organization->tahun_berdiri)
            ->line('Disetujui pada : '.Carbon::parse($this->organization->created_at)->format('d-m-Y'))
            ->line('Anda dapat memperbaiki data dengan login terlebih dahulu ke sistem WakafKu')
            ->action('Login', url('/login'))
            ->line('Terima kasih');
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
