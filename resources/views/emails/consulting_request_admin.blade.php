<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>[SPESORA Lead] Demande d'accompagnement</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f1f5f9; color: #1e293b; margin: 0; padding: 20px; line-height: 1.5; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #cbd5e1; }
        .header { background: linear-gradient(135deg, #0d47a1 0%, #00838f 100%); color: #ffffff; padding: 20px; }
        .header h2 { margin: 0; font-size: 18px; }
        .content { padding: 20px; }
        .info-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .info-table td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .info-table td.label { font-weight: 600; color: #64748b; width: 35%; }
        .message-box { background-color: #fffbeb; border: 1px solid #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 4px; font-size: 14px; margin: 15px 0; }
        .btn { display: inline-block; background-color: #0d47a1; color: #ffffff !important; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nouvelle Demande d'Accompagnement Client</h2>
        </div>
        <div class="content">
            <p>Un utilisateur souhaite être recontacté par l'équipe de consultants <strong>SPESORA GROUP</strong> :</p>

            <table class="info-table">
                <tr>
                    <td class="label">Organisation :</td>
                    <td><strong>{{ $organization->name }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Nom du demandeur :</td>
                    <td>{{ $contact['name'] ?? $organization->contact_name ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <td class="label">Email de contact :</td>
                    <td><a href="mailto:{{ $contact['email'] ?? $organization->contact_email }}">{{ $contact['email'] ?? $organization->contact_email }}</a></td>
                </tr>
                <tr>
                    <td class="label">Téléphone :</td>
                    <td><a href="tel:{{ $contact['phone'] ?? $organization->contact_phone }}">{{ $contact['phone'] ?? $organization->contact_phone ?? 'Non renseigné' }}</a></td>
                </tr>
                <tr>
                    <td class="label">Service ciblé :</td>
                    <td><strong style="color: #0d47a1;">{{ $contact['service_interest'] ?? 'Diagnostic & Accompagnement Global' }}</strong></td>
                </tr>
            </table>

            @if(!empty($contact['message']))
            <div class="message-box">
                <strong>Précisions / Message du client :</strong><br>
                {{ nl2br(e($contact['message'])) }}
            </div>
            @endif

            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; font-size: 13px; margin: 15px 0;">
                <strong>Scores associés au diagnostic :</strong><br>
                Maturité SI : <strong>{{ $diagnostic->global_score }}/100</strong> | Adéquation Cible : <strong>{{ $diagnostic->target_readiness_score }}/100</strong>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ $reportUrl }}" class="btn">Accéder au rapport complet &rarr;</a>
            </div>
        </div>
    </div>
</body>
</html>
