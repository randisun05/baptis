<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailRegistration extends Mailable
{
    use Queueable, SerializesModels;
    public $registration;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registration, string $password)
    {
        $this->registration = $registration;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('No-Reply-Registrasi Pendaftaran Baptis / Ketakumen')
                    ->view('Emails.Registration');
    }

}
