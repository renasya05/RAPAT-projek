<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailUji extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $tujuan)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Uji - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.uji',
        );
    }
}
