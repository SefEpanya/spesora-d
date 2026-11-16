<?php

namespace App\Mail;

use App\Models\Diagnostic;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DiagnosticCompletedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Diagnostic $diagnostic)
    {
    }

    public function envelope(): Envelope
    {
        $orgName = $this->diagnostic->organization->name ?? 'Nouvelle organisation';
        return new Envelope(
            subject: "[SPESORA Alerte] Nouveau Diagnostic Flash réalisé : {$orgName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.diagnostic_completed_admin',
            with: [
                'diagnostic' => $this->diagnostic,
                'organization' => $this->diagnostic->organization,
                'adminUrl' => route('diagnostic.report', ['diagnostic' => $this->diagnostic->uuid]),
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
