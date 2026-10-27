<?php

namespace App\Mail;

use App\Models\Domain;
use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmissionAlert extends Mailable
{
    use Queueable, SerializesModels;

    public Inquiry $inquiry;
    public ?Domain $domain;

    /**
     * Create a new message instance.
     */
    public function __construct(Inquiry $inquiry, ?Domain $domain = null)
    {
        $this->inquiry = $inquiry;
        $this->domain = $domain ?? Domain::find($inquiry->domain_id);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $domainName = $this->domain?->name ?? 'Torre Tórò';
        $typeLabel = ucwords(str_replace('_', ' ', $this->inquiry->type ?? 'General Contact'));

        return new Envelope(
            from: new Address(
                config('mail.from.address', 'hello@torretoro.com'),
                config('mail.from.name', 'Torre Tórò')
            ),
            replyTo: [
                new Address($this->inquiry->email, $this->inquiry->name)
            ],
            subject: "New Website {$typeLabel}: {$this->inquiry->name} [{$domainName}]",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-alert',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
