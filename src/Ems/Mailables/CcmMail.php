<?php

namespace Sellvation\CCMV2\Ems\Mailables;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CcmMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct() {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ccm',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'ems::emails.ccm',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
