<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invitation;
    public $signedUrl;
    public $tries = 3;
    public $timeout = 60;

    /**
     * Create a new message instance.
     *
     * @param  Invitation  $invitation
     * @param  string  $signedUrl
     * @return void
     */
    public function __construct(Invitation $invitation, $signedUrl)
    {
        $this->invitation = $invitation;
        $this->signedUrl = $signedUrl;
    }

      /**
     * Get the envelope details.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You Are Invited to Join!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'invitation.invitation-mail', // Path to your Blade template
            with: [
                'invitation' => $this->invitation,
                'signed_url' => $this->signedUrl
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
