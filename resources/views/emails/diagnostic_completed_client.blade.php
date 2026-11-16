<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Votre rapport SPESORA Diagnostic Flash</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f9; color: #2d3748; margin: 0; padding: 20px; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #0a192f 0%, #0d47a1 100%); color: #ffffff; padding: 30px 25px; text-align: center; }
        .header h1 { margin: 0 0 10px 0; font-size: 24px; font-weight: 700; }
        .header p { margin: 0; opacity: 0.9; font-size: 14px; }
        .content { padding: 30px 25px; }
        .score-box { display: flex; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin: 20px 0; text-align: center; }
        .score-col { flex: 1; padding: 10px; }
        .score-col:first-child { border-right: 1px solid #e2e8f0; }
        .score-val { font-size: 28px; font-weight: 800; color: #0d47a1; margin: 5px 0; }
        .score-label { font-size: 12px; text-transform: uppercase; color: #64748b; font-weight: 600; }
        .summary-card { background-color: #eff6ff; border-left: 4px solid #0d47a1; padding: 15px; border-radius: 0 6px 6px 0; margin: 20px 0; font-size: 14px; }
        .btn-cta { display: inline-block; background-color: #0d47a1; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 30px; font-weight: bold; font-size: 15px; text-align: center; margin: 15px 0; }
        .services-list { background-color: #f8fafc; border-radius: 8px; padding: 15px 20px; margin-top: 25px; font-size: 13px; color: #475569; }
        .services-list ul { margin: 8px 0; padding-left: 20px; }
        .footer { background-color: #f1f5f9; padding: 20px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SPESORA GROUP</h1>
            <p>Diagnostic Organisationnel & Performance du Système d'Information</p>
        </div>

        <div class="content">
            <p>Bonjour{{ $organization->contact_name ? ' ' . $organization->contact_name : '' }},</p>
            <p>Nous vous remercions d'avoir réalisé le <strong>SPESORA Diagnostic Flash</strong> pour votre entreprise <strong>{{ $organization->name }}</strong>.</p>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 20px 0; border: 1px solid #e2e8f0; border-radius: 8px; background-color: #f8fafc;">
                <tr>
                    <td align="center" width="50%" style="padding: 15px; border-right: 1px solid #e2e8f0;">
                        <div class="score-label">Maturité SI Actuelle</div>
                        <div class="score-val">{{ $diagnostic->global_score }}<span style="font-size: 16px; color: #64748b;">/100</span></div>
                    </td>
                    <td align="center" width="50%" style="padding: 15px;">
                        <div class="score-label">Adéquation Cible</div>
                        <div class="score-val" style="color: #0284c7;">{{ $diagnostic->target_readiness_score }}<span style="font-size: 16px; color: #64748b;">/100</span></div>
                    </td>
                </tr>
            </table>

            <div class="summary-card">
                <strong>Synthèse SPESORA GROUP :</strong><br>
                {{ $diagnostic->executive_summary }}
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $reportUrl }}" class="btn-cta" target="_blank">Consulter mon Rapport Complet &rarr;</a>
                <div style="font-size: 12px; color: #64748b; margin-top: 8px;">Accès direct sécurisé avec Radar Chart et plan d'action d'amélioration</div>
            </div>

            <div class="services-list">
                <strong>Besoin d'aller plus loin ?</strong>
                <p style="margin: 5px 0;">SPESORA GROUP vous accompagne dans la concrétisation de vos priorités :</p>
                <ul>
                    <li>Audit approfondi de sécurité et schéma directeur SI</li>
                    <li>Choix, intégration et automatisation des outils métiers (ERP, CRM)</li>
                    <li>Modernisation du parc matériel et travail hybride sécurisé</li>
                    <li>Formation des équipes et conduite du changement</li>
                </ul>
                <p style="margin: 5px 0 0 0;">Contactez directement nos consultants à <a href="mailto:contact@spesora.group">contact@spesora.group</a>.</p>
            </div>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} SPESORA GROUP • Tous droits réservés.<br>
            Cet email vous a été adressé suite à votre demande de diagnostic sur SPESORA Diagnostic Flash.
        </div>
    </div>
</body>
</html>
