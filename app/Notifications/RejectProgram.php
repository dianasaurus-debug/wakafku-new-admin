<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejectProgram extends Notification
{
    use Queueable;

    protected $program;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct($program) {
        $this->program = $program;
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
            ->line('Nama Program : '.$this->program->title)
            ->line('Nama Lembaga : '.$this->program->organization->user->name)
            ->line('Disetujui pada : '.Carbon::parse($this->program->created_at)->format('d-m-Y'))
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
