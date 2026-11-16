<?php

namespace Tests\Feature;

use App\Mail\DiagnosticCompletedClientMail;
use App\Mail\DiagnosticCompletedAdminMail;
use App\Mail\ConsultingRequestAdminMail;
use App\Models\Diagnostic;
use App\Models\Organization;
use Database\Seeders\SpesoraDiagnosticSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SpesoraNavigationAndDiagnosticTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SpesoraDiagnosticSeeder::class);
    }

    public function test_home_page_displays_all_spesora_services_with_ctas(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SPESORA GROUP · DOUALA');
        $response->assertSee('Transformation numérique &amp; renforcement des capacités', false);
        $response->assertSee('Ce que SPESORA apporte à votre organisation');

        // Vérification de la présence des 4 piliers fondamentaux issus de la présentation
        $response->assertSee('Audit de performance');
        $response->assertSee('Intégration de logiciels');
        $response->assertSee('Formation');
        $response->assertSee('Support technique');

        // Vérification de la méthode en 5 étapes
        $response->assertSee('Notre méthode en cinq étapes');
        $response->assertSee('Comprendre');
        $response->assertSee('Recommander');
        $response->assertSee('Déployer');
        $response->assertSee('Transmettre');
        $response->assertSee('Accompagner');

        // Vérification des références
        $response->assertSee('NUMIAS SARL');
        $response->assertSee('TITAN DYNAMICS LLC BROKERS');

        // Vérification des Call-to-Action
        $response->assertSee('Lancer l\'Audit de performance Flash', false);
        $response->assertSee('Évaluer mon intégration');
    }

    public function test_services_page_displays_details_and_ctas(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('Offres &amp; Prestations', false);
        $response->assertSee('Ce que SPESORA apporte à votre organisation');
        $response->assertSee('Lancer le Diagnostic');
    }

    public function test_diagnostic_creation_page_loads_with_targets(): void
    {
        $response = $this->get('/diagnostic?target=cybersecurity');

        $response->assertStatus(200);
        $response->assertSee('Questionnaire Diagnostic Flash');
        $response->assertSee('Scénarios types SPESORA');
        $response->assertSee('Identification de l\'Organisation', false);
    }

    public function test_diagnostic_submission_computes_score_and_sends_emails(): void
    {
        Mail::fake();

        $payload = [
            'company_name' => 'Douala Trade Corp',
            'sector' => 'industrie',
            'size' => 'pme',
            'contact_name' => 'Marc Eboué',
            'contact_email' => 'marc.eboue@doualatrade.cm',
            'contact_phone' => '+237699000000',
            'budget_range' => 'confortable',
            'target_objectifs' => ['productivity_automation', 'client_management'],
            'crm_tool' => 'crm_dedie_interconnecte',
            'erp_billing_tool' => 'logiciel_facturation_standard',
            'collab_suite' => 'suite_cloud_m365_google',
            'marketing_tools' => 'outils_dedies',
            'tools_integration' => 'quelques_connecteurs',
            'hardware_age' => 'moins_de_3_ans',
            'network_quality' => 'fibre_dediee_wifi_securise',
            'mobility_remote_work' => 'flotte_standard_vpn_securise',
            'servers_infrastructure' => 'cloud_ou_hybride_maitrise',
            'backup_policy' => 'sauvegarde_321_testee',
            'auth_security' => 'mfa_generalise',
            'endpoint_protection' => 'edr_deploye',
            'maintenance_support' => 'prestataire_infogerance_sla',
            'gdpr_compliance' => 'conformite_documentee',
            'automation_level' => 'flux_automatises_avances',
            'team_training' => 'plan_formation_annuel',
            'process_documentation' => 'documentation_complete_a_jour',
            'cross_team_collaboration' => 'outils_modernes_adoptes',
        ];

        $response = $this->post('/diagnostic', $payload);

        $diagnostic = Diagnostic::first();
        $this->assertNotNull($diagnostic);
        $this->assertEquals('Douala Trade Corp', $diagnostic->organization->name);
        $this->assertGreaterThan(50, $diagnostic->global_score);

        $response->assertRedirect(route('diagnostic.report', ['diagnostic' => $diagnostic->uuid]));

        // Vérification de l'envoi de mail au client et à l'admin
        Mail::assertSent(DiagnosticCompletedClientMail::class, function ($mail) {
            return $mail->hasTo('marc.eboue@doualatrade.cm');
        });

        Mail::assertSent(DiagnosticCompletedAdminMail::class, function ($mail) {
            return $mail->hasTo('contact@spesora.group');
        });
    }

    public function test_report_page_and_print_view(): void
    {
        $org = Organization::create([
            'name' => 'Demo Org Douala',
            'sector' => 'services',
            'size' => 'pme',
            'contact_email' => 'contact@demo-douala.cm',
        ]);

        $diagnostic = Diagnostic::create([
            'organization_id' => $org->id,
            'status' => 'completed',
            'global_score' => 75.0,
            'target_readiness_score' => 70.0,
            'pillar_scores' => [
                'software' => ['name' => 'Logiciel', 'score' => 70, 'requirement' => 80, 'gap' => -10, 'level' => 'Bon', 'is_compliant' => false],
                'hardware' => ['name' => 'Matériel', 'score' => 80, 'requirement' => 70, 'gap' => 10, 'level' => 'Optimal', 'is_compliant' => true],
                'operational' => ['name' => 'Opérationnel', 'score' => 75, 'requirement' => 75, 'gap' => 0, 'level' => 'Bon', 'is_compliant' => true],
                'productive' => ['name' => 'Productivité', 'score' => 75, 'requirement' => 75, 'gap' => 0, 'level' => 'Bon', 'is_compliant' => true],
            ],
            'executive_summary' => 'Synthèse d\'évaluation favorable.',
        ]);

        // Rapport interactif
        $response = $this->get(route('diagnostic.report', ['diagnostic' => $diagnostic->uuid]));
        $response->assertStatus(200);
        $response->assertSee('Demo Org Douala');
        $response->assertSee('Radar d\'Adéquation', false);
        $response->assertSee('Envoyer par email');
        $response->assertSee('Être rappelé par un consultant');

        // Vue impression A4 / PDF
        $printResponse = $this->get(route('diagnostic.print', ['diagnostic' => $diagnostic->uuid]));
        $printResponse->assertStatus(200);
        $printResponse->assertSee('Rapport SPESORA Diagnostic Flash');
        $printResponse->assertSee('Demo Org Douala');
    }

    public function test_send_email_action(): void
    {
        Mail::fake();

        $org = Organization::create(['name' => 'Test Corp', 'contact_email' => 'old@test.fr']);
        $diagnostic = Diagnostic::create([
            'organization_id' => $org->id,
            'status' => 'completed',
            'global_score' => 60.0,
            'target_readiness_score' => 65.0,
        ]);

        $response = $this->post(route('diagnostic.send-email', ['diagnostic' => $diagnostic->uuid]), [
            'email' => 'new-recipient@test.fr',
        ]);

        $response->assertSessionHas('success');
        Mail::assertSent(DiagnosticCompletedClientMail::class, function ($mail) {
            return $mail->hasTo('new-recipient@test.fr');
        });
    }

    public function test_request_consulting_action(): void
    {
        Mail::fake();

        $org = Organization::create(['name' => 'Test Corp', 'contact_email' => 'lead@test.fr']);
        $diagnostic = Diagnostic::create([
            'organization_id' => $org->id,
            'status' => 'completed',
            'global_score' => 60.0,
            'target_readiness_score' => 65.0,
        ]);

        $response = $this->post(route('diagnostic.request-consulting', ['diagnostic' => $diagnostic->uuid]), [
            'contact_name' => 'Marc Durand',
            'contact_email' => 'marc@test.fr',
            'contact_phone' => '0600000000',
            'service_interest' => 'Audit de performance',
            'message' => 'Nous voulons un devis pour un audit complet.',
        ]);

        $response->assertSessionHas('success');
        Mail::assertSent(ConsultingRequestAdminMail::class, function ($mail) {
            return $mail->hasTo('contact@spesora.group');
        });
    }

    public function test_admin_dashboard_and_mail_preview(): void
    {
        $org = Organization::create(['name' => 'Admin Test Corp', 'contact_email' => 'admin-test@corp.fr']);
        $diagnostic = Diagnostic::create([
            'organization_id' => $org->id,
            'status' => 'completed',
            'global_score' => 80.0,
            'target_readiness_score' => 85.0,
        ]);

        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Tableau de Bord Consultant SPESORA');
        $response->assertSee('Admin Test Corp');

        // Test mail preview
        $previewResponse = $this->get(route('admin.mail-preview', ['type' => 'client']));
        $previewResponse->assertStatus(200);
    }
}
