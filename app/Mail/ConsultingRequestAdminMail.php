<?php

namespace App\Mail;

use App\Models\Diagnostic;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultingRequestAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Diagnostic $diagnostic,
        public array $contactData
    ) {
    }

    public function envelope(): Envelope
    {
        $orgName = $this->diagnostic->organization->name ?? 'Organisation';
        return new Envelope(
            subject: "[SPESORA Lead] Demande d'accompagnement / conseil : {$orgName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.consulting_request_admin',
            with: [
                'diagnostic' => $this->diagnostic,
                'organization' => $this->diagnostic->organization,
                'contact' => $this->contactData,
                'reportUrl' => route('diagnostic.report', ['diagnostic' => $this->diagnostic->uuid]),
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
