<?php

namespace App\Mail;

use App\Models\Diagnostic;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DiagnosticCompletedClientMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Diagnostic $diagnostic)
    {
    }

    public function envelope(): Envelope
    {
        $orgName = $this->diagnostic->organization->name ?? 'Organisation';
        return new Envelope(
            subject: "Votre rapport SPESORA Diagnostic Flash — {$orgName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.diagnostic_completed_client',
            with: [
                'diagnostic' => $this->diagnostic,
                'organization' => $this->diagnostic->organization,
                'reportUrl' => route('diagnostic.report', ['diagnostic' => $this->diagnostic->uuid]),
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
