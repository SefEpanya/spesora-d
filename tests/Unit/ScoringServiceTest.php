<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ScoringService;

/**
 * Test unitaire ScoringServiceTest
 * 
 * Valide le moteur de notation et le Gap Analysis.
 */
class ScoringServiceTest extends TestCase
{
    protected ScoringService $scoringService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->scoringService = new ScoringService();
    }

    public function test_scores_are_within_valid_bounds(): void
    {
        $answers = [
            'crm_tool' => 'tableur_excel',
            'erp_billing_tool' => 'tableur',
            'collab_suite' => 'suite_cloud_m365_google',
            'marketing_tools' => 'reseaux_sociaux_manuel',
            'tools_integration' => 'imports_exports_manuels',
            'hardware_age' => 'entre_3_et_5_ans',
            'network_quality' => 'fibre_grand_public_wifi_box',
            'mobility_remote_work' => 'portables_heterogenes_vpn_basique',
            'servers_infrastructure' => 'cloud_ou_hybride_maitrise',
            'backup_policy' => 'sauvegarde_cloud_automatique_sans_test',
            'auth_security' => 'mot_de_passe_simple_partage',
            'endpoint_protection' => 'antivirus_standard_incomplet',
            'maintenance_support' => 'referent_interne_non_dedie',
            'gdpr_compliance' => 'sensibilisation_partielle',
            'automation_level' => 'quelques_macros_ou_zapier_isole',
            'team_training' => 'formation_sur_le_tas_ponctuelle',
            'process_documentation' => 'quelques_fiches_non_a_jour',
            'cross_team_collaboration' => 'echanges_emails_lourds',
        ];

        $evaluation = $this->scoringService->calculateEvaluation($answers, ['client_management', 'cybersecurity']);

        $this->assertGreaterThanOrEqual(0, $evaluation['global_score']);
        $this->assertLessThanOrEqual(100, $evaluation['global_score']);
        $this->assertGreaterThanOrEqual(0, $evaluation['target_readiness_score']);
        $this->assertLessThanOrEqual(100, $evaluation['target_readiness_score']);

        $this->assertCount(4, $evaluation['pillar_details']);
        $this->assertNotEmpty($evaluation['recommendations']);
    }

    public function test_critical_alerts_triggered_for_cybersecurity(): void
    {
        $answers = [
            'backup_policy' => 'aucune',
            'auth_security' => 'mot_de_passe_simple_partage',
        ];

        $evaluation = $this->scoringService->calculateEvaluation($answers, ['cybersecurity']);

        $recs = $evaluation['recommendations'];
        $codes = array_column($recs, 'code');

        $this->assertContains('BACKUP_321', $codes);
        $this->assertContains('MFA_DEPLOYMENT', $codes);

        $mfaRec = current(array_filter($recs, fn($r) => $r['code'] === 'MFA_DEPLOYMENT'));
        $this->assertEquals('Critique', $mfaRec['priority']);
    }
}
