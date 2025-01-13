<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    /**
     * Crează un nou mesaj de email.
     *
     * @param  array  $contactData
     * @return void
     */
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Definiște conținutul mesajului.
     *
     * @return \Illuminate\Contracts\Mail\Mailable
     */
    public function build()
    {
        return $this->from($this->contactData['email'])  // Adresa de expeditor - adresa completată de utilizator
                ->to('claudiu.mindrescu@student.usv.ro')  // Adresa destinatarului - adresa ta de Gmail
                ->subject($this->contactData['subject'])  // Subiectul
                ->view('emails.emailus')  // Vederea care va fi folosită pentru email
                ->with('contactData', $this->contactData);  // Datele trimise de utilizator în formular
    }
}
