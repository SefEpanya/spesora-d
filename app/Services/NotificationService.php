<?php

namespace App\Services;

use App\Models\Diagnostic;
use App\Mail\DiagnosticCompletedClientMail;
use App\Mail\DiagnosticCompletedAdminMail;
use App\Mail\ConsultingRequestAdminMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Service NotificationService
 * 
 * Module 9 : Notifications.
 * Gère les notifications d'audit pour le client et pour l'équipe SPESORA GROUP.
 */
class NotificationService
{
    /**
     * Déclenche l'envoi des emails de notification à la clôture d'un diagnostic.
     */
    public function sendDiagnosticCompletedNotifications(Diagnostic $diagnostic): void
    {
        $org = $diagnostic->organization;
        $adminEmail = config('spesora.support_email', 'contact@spesora.group');

        Log::info("SPESORA Diagnostic Flash validé pour l'organisation [{$org->name}]", [
            'diagnostic_uuid' => $diagnostic->uuid,
            'global_score' => $diagnostic->global_score,
            'target_readiness_score' => $diagnostic->target_readiness_score,
            'organization_email' => $org->contact_email,
            'notified_admin' => $adminEmail,
        ]);

        // 1. Envoi au client si une adresse email est renseignée
        if (!empty($org->contact_email)) {
            try {
                Mail::to($org->contact_email)->send(new DiagnosticCompletedClientMail($diagnostic));
                Log::info("Email récapitulatif envoyé avec succès au client : {$org->contact_email}");
            } catch (Throwable $e) {
                Log::error("Échec de l'envoi email au client ({$org->contact_email}) : " . $e->getMessage(), [
                    'exception' => $e
                ]);
            }
        }

        // 2. Notification interne pour l'équipe de consultants SPESORA GROUP
        if (!empty($adminEmail)) {
            try {
                Mail::to($adminEmail)->send(new DiagnosticCompletedAdminMail($diagnostic));
                Log::info("Alerte nouveau diagnostic envoyée à l'équipe SPESORA : {$adminEmail}");
            } catch (Throwable $e) {
                Log::error("Échec de l'envoi email d'alerte admin ({$adminEmail}) : " . $e->getMessage(), [
                    'exception' => $e
                ]);
            }
        }
    }

    /**
     * Renvoie le rapport d'un diagnostic à une adresse spécifique.
     */
    public function resendReportEmail(Diagnostic $diagnostic, string $recipientEmail): bool
    {
        try {
            Mail::to($recipientEmail)->send(new DiagnosticCompletedClientMail($diagnostic));
            Log::info("Rapport renvoyé manuellement à l'adresse : {$recipientEmail}");
            return true;
        } catch (Throwable $e) {
            Log::error("Échec du renvoi de rapport à ({$recipientEmail}) : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Envoie la notification d'une demande de rappel / consultation à SPESORA GROUP.
     */
    public function sendConsultingRequest(Diagnostic $diagnostic, array $contactData): bool
    {
        $adminEmail = config('spesora.support_email', 'contact@spesora.group');

        try {
            Mail::to($adminEmail)->send(new ConsultingRequestAdminMail($diagnostic, $contactData));
            Log::info("Demande d'accompagnement transmise à SPESORA GROUP pour {$diagnostic->organization->name}");
            return true;
        } catch (Throwable $e) {
            Log::error("Échec de l'envoi de la demande d'accompagnement : " . $e->getMessage());
            return false;
        }
    }
}
