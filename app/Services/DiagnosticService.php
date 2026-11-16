<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\Diagnostic;
use App\Models\DiagnosticAnswer;
use App\Models\Recommendation;
use Illuminate\Support\Facades\DB;

/**
 * Service DiagnosticService
 * 
 * Module 2 : Gestion des diagnostics.
 * Orchestre la création, l'évaluation et la persistance des diagnostics.
 */
class DiagnosticService
{
    public function __construct(
        protected ScoringService $scoringService,
        protected NotificationService $notificationService
    ) {}

    /**
     * Traite et enregistre un diagnostic complet à partir du formulaire de saisie.
     */
    public function submitDiagnostic(array $organizationData, array $answers, array $targetObjectifs): Diagnostic
    {
        return DB::transaction(function () use ($organizationData, $answers, $targetObjectifs) {
            // 1. Création ou mise à jour de l'organisation
            $organization = Organization::updateOrCreate(
                ['contact_email' => $organizationData['contact_email'] ?? null, 'name' => $organizationData['name']],
                [
                    'sector' => $organizationData['sector'] ?? 'services',
                    'size' => $organizationData['size'] ?? 'pme',
                    'contact_name' => $organizationData['contact_name'] ?? null,
                    'contact_phone' => $organizationData['contact_phone'] ?? null,
                    'budget_range' => $organizationData['budget_range'] ?? 'modere',
                ]
            );

            // 2. Calcul des scores et recommandations via le ScoringService
            $evaluation = $this->scoringService->calculateEvaluation(
                answers: $answers,
                targetKeys: $targetObjectifs,
                companySize: $organization->size
            );

            // 3. Création du diagnostic
            $diagnostic = Diagnostic::create([
                'organization_id' => $organization->id,
                'status' => 'completed',
                'target_objectifs' => $targetObjectifs,
                'global_score' => $evaluation['global_score'],
                'target_readiness_score' => $evaluation['target_readiness_score'],
                'pillar_scores' => $evaluation['pillar_details'],
                'executive_summary' => $evaluation['executive_summary'],
            ]);

            // 4. Enregistrement des réponses individuelles
            foreach ($answers as $qCode => $val) {
                DiagnosticAnswer::create([
                    'diagnostic_id' => $diagnostic->id,
                    'question_code' => $qCode,
                    'pillar_code' => $this->resolvePillarForQuestion($qCode),
                    'selected_value' => (string) $val,
                    'score_obtained' => 0.0, // calculé par question si besoin
                ]);
            }

            // 5. Association des recommandations en base
            foreach ($evaluation['recommendations'] as $recData) {
                $recommendation = Recommendation::firstOrCreate(
                    ['code' => $recData['code']],
                    [
                        'pillar_code' => $recData['pillar_code'],
                        'title' => $recData['title'],
                        'diagnostic_text' => $recData['diagnostic'],
                        'action_plan' => $recData['action'],
                        'suggested_tools' => $recData['tools'] ?? [],
                        'priority' => $recData['priority'],
                        'effort_level' => $recData['effort'],
                        'is_quick_win' => $recData['is_quick_win'],
                        'impact_target_template' => $recData['impact_target'],
                    ]
                );

                $diagnostic->recommendations()->attach($recommendation->id, [
                    'priority_override' => $recData['priority'],
                    'is_quick_win' => $recData['is_quick_win'],
                ]);
            }

            // 6. Déclenchement des notifications
            $this->notificationService->sendDiagnosticCompletedNotifications($diagnostic);

            return $diagnostic;
        });
    }

    protected function resolvePillarForQuestion(string $qCode): string
    {
        $prefixes = [
            'crm_tool' => 'software',
            'erp_billing_tool' => 'software',
            'collab_suite' => 'software',
            'marketing_tools' => 'software',
            'tools_integration' => 'software',
            'hardware_age' => 'hardware',
            'network_quality' => 'hardware',
            'mobility_remote_work' => 'hardware',
            'servers_infrastructure' => 'hardware',
            'backup_policy' => 'operational',
            'auth_security' => 'operational',
            'endpoint_protection' => 'operational',
            'maintenance_support' => 'operational',
            'gdpr_compliance' => 'operational',
            'automation_level' => 'productive',
            'team_training' => 'productive',
            'process_documentation' => 'productive',
            'cross_team_collaboration' => 'productive',
        ];

        return $prefixes[$qCode] ?? 'software';
    }
}
