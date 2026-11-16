<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>[SPESORA Alerte] Nouveau Diagnostic Flash</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f1f5f9; color: #1e293b; margin: 0; padding: 20px; line-height: 1.5; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #cbd5e1; }
        .header { background-color: #0f172a; color: #ffffff; padding: 20px; }
        .header h2 { margin: 0; font-size: 18px; }
        .content { padding: 20px; }
        .info-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .info-table td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .info-table td.label { font-weight: 600; color: #64748b; width: 35%; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
        .badge-score { background-color: #dbeafe; color: #1e40af; }
        .badge-readiness { background-color: #fef3c7; color: #92400e; }
        .btn { display: inline-block; background-color: #0d47a1; color: #ffffff !important; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nouveau Diagnostic Flash Enregistré</h2>
        </div>
        <div class="content">
            <p>Un nouveau diagnostic organisationnel vient d'être soumis sur la plateforme :</p>
            
            <table class="info-table">
                <tr>
                    <td class="label">Organisation :</td>
                    <td><strong>{{ $organization->name }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Secteur / Taille :</td>
                    <td>{{ ucfirst($organization->sector) }} • {{ strtoupper($organization->size) }}</td>
                </tr>
                <tr>
                    <td class="label">Contact référent :</td>
                    <td>{{ $organization->contact_name ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <td class="label">Email de contact :</td>
                    <td><a href="mailto:{{ $organization->contact_email }}">{{ $organization->contact_email ?? 'Non renseigné' }}</a></td>
                </tr>
                <tr>
                    <td class="label">Téléphone :</td>
                    <td>{{ $organization->contact_phone ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <td class="label">Maturité globale :</td>
                    <td><span class="badge badge-score">{{ $diagnostic->global_score }}/100</span></td>
                </tr>
                <tr>
                    <td class="label">Adéquation cible :</td>
                    <td><span class="badge badge-readiness">{{ $diagnostic->target_readiness_score }}/100</span></td>
                </tr>
                <tr>
                    <td class="label">Budget envisagé :</td>
                    <td>{{ ucfirst($organization->budget_range ?? 'Non précisé') }}</td>
                </tr>
            </table>

            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; font-size: 13px; margin: 15px 0;">
                <strong>Synthèse générée :</strong><br>
                {{ $diagnostic->executive_summary }}
            </div>

            <div style="text-align: center;">
                <a href="{{ $adminUrl }}" class="btn">Consulter la fiche complète du rapport &rarr;</a>
            </div>
        </div>
    </div>
</body>
</html>
