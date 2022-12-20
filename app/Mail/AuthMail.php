<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data, $jenis, $subject;
    public function __construct($jenis, $subject, $data)
    {
        $this->data = $data;
        $this->jenis = $jenis;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->jenis==0){ //ketika email send otp
            return $this->subject($this->subject)->view('email.otp_confirmation');
        }
    }
}
