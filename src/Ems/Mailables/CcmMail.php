<?php

namespace Sellvation\CCMV2\Ems\Mailables;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\Ems\Models\EmailQueue;

class CcmMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private readonly EmailQueue $email) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->email->from,
            to: $this->email->to,
            subject: $this->email->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            html: $this->email->html_content,
            text: $this->email->text_content
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
