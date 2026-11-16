<?php

namespace App\Services;

use App\Models\Diagnostic;
use App\Models\Recommendation;

/**
 * Service ScoringService
 * 
 * Module 7 : Moteur de notation (Scoring Engine).
 * Implémente la méthodologie d'évaluation et de Gap Analysis (analogie CV scoring)
 * pour mesurer l'adéquation de l'existant avec les objectifs stratégiques ciblés.
 */
class ScoringService
{
    /**
     * Calcule les scores par pilier, le score global et le score d'adéquation cible.
     * 
     * @param array $answers Réponses collectées [question_code => selected_value]
     * @param array $targetKeys Clés des objectifs visés par l'organisation
     * @param string $companySize Taille de l'organisation (tpe, pme, eti, grande)
     * @return array Structure complète d'évaluation
     */
    public function calculateEvaluation(array $answers, array $targetKeys = [], string $companySize = 'pme'): array
    {
        $pillarsConfig = config('spesora.pillars', []);
        $targetsConfig = config('spesora.targets', []);

        // 1. Calcul des scores intrinsèques par pilier (0 à 100)
        $pillarScores = $this->computePillarRawScores($answers);

        // 2. Détermination des exigences cibles (benchmarks) et des pondérations
        [$benchmarks, $weights] = $this->determineTargetBenchmarksAndWeights($targetKeys, $targetsConfig);

        // 3. Calcul de la note globale de maturité (0-100)
        $globalScore = 0.0;
        foreach ($pillarScores as $pillar => $score) {
            $w = $weights[$pillar] ?? 0.25;
            $globalScore += ($score * $w);
        }
        $globalScore = round($globalScore, 1);

        // 4. Calcul du score d'adéquation à la cible (Target Readiness Score)
        // Mesure à quel point l'existant couvre les exigences requises pour la cible
        $readinessScore = 0.0;
        $pillarDetails = [];

        foreach ($pillarScores as $pillar => $score) {
            $req = $benchmarks[$pillar] ?? 70.0;
            $w = $weights[$pillar] ?? 0.25;

            // Ratio de couverture de l'exigence
            $coverage = ($score >= $req) ? 1.0 : max(0.0, $score / $req);
            $readinessScore += ($coverage * 100.0 * $w);

            $gap = round($req - $score, 1);
            $levelInfo = $this->getMaturityLevel($score);

            $pillarDetails[$pillar] = [
                'code' => $pillar,
                'name' => $pillarsConfig[$pillar]['name'] ?? ucfirst($pillar),
                'score' => $score,
                'requirement' => $req,
                'gap' => $gap,
                'is_compliant' => ($gap <= 0),
                'level' => $levelInfo['label'],
                'color_class' => $levelInfo['class'],
                'badge_class' => $levelInfo['badge'],
            ];
        }

        $readinessScore = round($readinessScore, 1);

        // 5. Synthèse exécutive SPESORA GROUP
        $summary = $this->generateExecutiveSummary($readinessScore, $targetKeys);

        // 6. Génération et hiérarchisation des recommandations
        $recommendations = $this->generateRecommendations($answers, $targetKeys, $companySize);

        return [
            'global_score' => $globalScore,
            'target_readiness_score' => $readinessScore,
            'pillar_details' => $pillarDetails,
            'benchmarks' => $benchmarks,
            'executive_summary' => $summary,
            'recommendations' => $recommendations,
        ];
    }

    /**
     * Calcule la note moyenne (0-100) pour chaque pilier à partir des réponses.
     */
    protected function computePillarRawScores(array $answers): array
    {
        // Barème par question (aligné sur les 4 piliers)
        $scoresMap = [
            'software' => [
                'crm_tool' => ['aucun' => 10, 'tableur_excel' => 35, 'crm_basique' => 70, 'crm_avance' => 100],
                'erp_billing_tool' => ['aucun_facture_papier' => 10, 'tableur' => 35, 'logiciel_facturation_simple' => 70, 'erp_integre' => 100],
                'collab_suite' => ['email_perso_fournisseur' => 15, 'email_pro_standard' => 55, 'suite_cloud_m365_google' => 100],
                'marketing_tools' => ['aucun' => 15, 'reseaux_sociaux_manuel' => 45, 'outils_marketing_dedies_mailchimp_buffer' => 90],
                'tools_integration' => ['silos_aucun_lien' => 20, 'imports_exports_manuels' => 50, 'integration_api_zapier' => 95],
            ],
            'hardware' => [
                'hardware_age' => ['plus_de_5_ans' => 20, 'entre_3_et_5_ans' => 60, 'moins_de_3_ans' => 100],
                'network_quality' => ['adsl_4g_instable' => 25, 'fibre_grand_public_wifi_box' => 65, 'fibre_pro_wifi_mesh_switchs' => 100],
                'mobility_remote_work' => ['fixes_uniquement_pas_de_vpn' => 20, 'portables_heterogenes_vpn_basique' => 60, 'portables_securises_vpn_mdm' => 100],
                'servers_infrastructure' => ['serveur_local_obsolete' => 20, 'serveur_local_recent' => 65, 'cloud_ou_hybride_maitrise' => 95],
            ],
            'operational' => [
                'backup_policy' => ['aucune' => 5, 'cle_usb_disque_externe_irregulier' => 30, 'sauvegarde_cloud_automatique_sans_test' => 70, 'regle_321_automatisee_testee' => 100],
                'auth_security' => ['mot_de_passe_simple_partage' => 10, 'mot_de_passe_unique_par_agent' => 50, 'mfa_gestionnaire_mdp_deploie' => 100],
                'endpoint_protection' => ['antivirus_gratuit_ou_aucun' => 15, 'antivirus_standard_incomplet' => 55, 'edr_antivirus_centralise_maj_auto' => 100],
                'maintenance_support' => ['au_coup_par_coup_ami_bricoleur' => 15, 'referent_interne_non_dedie' => 50, 'infogerance_contrat_sla_ou_dsi' => 95],
                'gdpr_compliance' => ['aucune_notion' => 15, 'sensibilisation_partielle' => 55, 'conformite_documentee_dpo_registre' => 95],
            ],
            'productive' => [
                'automation_level' => ['100_pourcent_manuel' => 20, 'quelques_macros_ou_zapier_isole' => 60, 'workflows_automatises_standardises' => 100],
                'team_training' => ['jamais_formes_autodidactes' => 25, 'formation_sur_le_tas_ponctuelle' => 55, 'plan_formation_continu_outils_digitaux' => 95],
                'process_documentation' => ['tout_est_dans_la_tete' => 15, 'quelques_fiches_non_a_jour' => 50, 'wikis_procedures_claires_documentees' => 95],
                'cross_team_collaboration' => ['friction_chacun_son_fichier' => 20, 'echanges_emails_lourds' => 50, 'travail_collaboratif_temps_reel_chat' => 95],
            ],
        ];

        $results = [];

        foreach ($scoresMap as $pillar => $questions) {
            $sum = 0;
            $count = count($questions);
            foreach ($questions as $qCode => $options) {
                $chosen = $answers[$qCode] ?? null;
                $sum += $options[$chosen] ?? 50;
            }
            $results[$pillar] = round($sum / max($count, 1), 1);
        }

        return $results;
    }

    /**
     * Détermine les seuils d'exigence (benchmarks) et les poids en fonction des cibles.
     */
    protected function determineTargetBenchmarksAndWeights(array $targetKeys, array $targetsConfig): array
    {
        $pillars = ['software', 'hardware', 'operational', 'productive'];
        $benchmarks = array_fill_keys($pillars, 70.0);
        $weights = array_fill_keys($pillars, 0.25);

        $validKeys = array_intersect($targetKeys, array_keys($targetsConfig));
        if (empty($validKeys)) {
            return [$benchmarks, $weights];
        }

        $accumWeights = array_fill_keys($pillars, 0.0);
        $maxBenchmarks = array_fill_keys($pillars, 0.0);

        foreach ($validKeys as $key) {
            $t = $targetsConfig[$key];
            foreach ($pillars as $p) {
                $maxBenchmarks[$p] = max($maxBenchmarks[$p], (float)($t['benchmarks'][$p] ?? 70));
                $accumWeights[$p] += (float)($t['weights'][$p] ?? 0.25);
            }
        }

        $totalW = array_sum($accumWeights) ?: 1.0;
        foreach ($pillars as $p) {
            $weights[$p] = round($accumWeights[$p] / $totalW, 3);
            $benchmarks[$p] = $maxBenchmarks[$p];
        }

        return [$benchmarks, $weights];
    }

    protected function getMaturityLevel(float $score): array
    {
        if ($score < 40) {
            return ['label' => 'Critique', 'class' => 'text-danger', 'badge' => 'bg-danger'];
        } elseif ($score < 60) {
            return ['label' => 'À moderniser', 'class' => 'text-warning', 'badge' => 'bg-warning text-dark'];
        } elseif ($score < 75) {
            return ['label' => 'Intermédiaire', 'class' => 'text-info', 'badge' => 'bg-info text-dark'];
        } elseif ($score < 90) {
            return ['label' => 'Robuste', 'class' => 'text-primary', 'badge' => 'bg-primary'];
        } else {
            return ['label' => 'Optimal', 'class' => 'text-success', 'badge' => 'bg-success'];
        }
    }

    protected function generateExecutiveSummary(float $readinessScore, array $targets): string
    {
        if ($readinessScore >= 80) {
            return "Votre organisation dispose d'un socle organisationnel et technique robuste pour soutenir ses ambitions. Les préconisations de SPESORA GROUP ciblent des optimisations à forte valeur ajoutée pour consolider votre leadership.";
        } elseif ($readinessScore >= 55) {
            return "L'existant est opérationnel au quotidien mais présente des goulets d'étranglement majeurs qui freinent l'atteinte de vos objectifs stratégiques. La mise en œuvre des Quick Wins identifiés par SPESORA GROUP permettra de débloquer rapidement votre potentiel.";
        } else {
            return "Alerte : L'organisation accuse un retard critique d'équipement et de procédures par rapport aux standards nécessaires pour ses cibles business. Un accompagnement d'urgence est vivement conseillé pour sécuriser les données et stabiliser l'exploitation.";
        }
    }

    /**
     * Génère la liste prescriptive des recommandations d'amélioration.
     */
    protected function generateRecommendations(array $answers, array $targets, string $companySize): array
    {
        $recs = [];

        // 1. CRM
        if (in_array($answers['crm_tool'] ?? '', ['aucun', 'tableur_excel'])) {
            $isTarget = in_array('client_management', $targets);
            $recs[] = [
                'code' => 'CRM_DEPLOYMENT',
                'pillar' => 'Logiciel',
                'pillar_code' => 'software',
                'title' => 'Déployer un CRM cloud et abandonner la gestion client sur tableur',
                'diagnostic' => "Gestion commerciale fragmentée sur des fichiers dispersés, entraînant des pertes d'opportunités et un manque de visibilité.",
                'action' => "Centraliser le fichier client et le suivi des prospects sur une solution CRM collaborative connectée à la messagerie.",
                'tools' => ['HubSpot CRM', 'Pipedrive', 'Axonaut', 'Folk'],
                'priority' => $isTarget ? 'Critique' : 'Élevée',
                'priority_level' => $isTarget ? 1 : 2,
                'effort' => ($companySize === 'tpe') ? 'Quick Win (1-2 sem)' : 'Moyen terme (1-3 mois)',
                'is_quick_win' => ($companySize === 'tpe'),
                'impact_target' => "Essentiel pour votre relation client : sécurise l'historique commercial et accélère la conversion des opportunités."
            ];
        }

        // 2. Facturation / ERP
        if (in_array($answers['erp_billing_tool'] ?? '', ['aucun_facture_papier', 'tableur'])) {
            $isTarget = in_array('process_digitization', $targets);
            $recs[] = [
                'code' => 'BILLING_SOFTWARE',
                'pillar' => 'Logiciel',
                'pillar_code' => 'software',
                'title' => 'Adopter un logiciel de facturation & devis conforme réforme électronique',
                'diagnostic' => "Facturation manuelle non sécurisée et non conforme aux obligations légales de facturation dématérialisée.",
                'action' => "Déployer un logiciel de gestion commerciale conforme avec rapprochement bancaire automatique.",
                'tools' => ['Pennylane', 'Axonaut', 'Tiime', 'Odoo'],
                'priority' => $isTarget ? 'Critique' : 'Élevée',
                'priority_level' => $isTarget ? 1 : 2,
                'effort' => 'Quick Win (1-2 sem)',
                'is_quick_win' => true,
                'impact_target' => "Garantit la conformité réglementaire et réduit les délais d'encaissement client."
            ];
        }

        // 3. Sauvegardes
        if (in_array($answers['backup_policy'] ?? '', ['aucune', 'cle_usb_disque_externe_irregulier', 'sauvegarde_cloud_automatique_sans_test'])) {
            $isCyber = in_array('cybersecurity', $targets);
            $recs[] = [
                'code' => 'BACKUP_321',
                'pillar' => 'Opérationnel',
                'pillar_code' => 'operational',
                'title' => 'Mettre en place la règle de sauvegarde 3-2-1 immuable et tester les restaurations',
                'diagnostic' => "Sauvegardes vulnérables aux ransomwares ou non testées en conditions réelles de sinistre.",
                'action' => "Automatiser 3 copies de vos données, sur 2 supports différents, dont 1 hors-site immuable avec tests trimestriels.",
                'tools' => ['Veeam Backup', 'Acronis Cyber Protect', 'Wasabi Hot Cloud Storage', 'Synology C2'],
                'priority' => 'Critique',
                'priority_level' => 1,
                'effort' => 'Quick Win (1-2 sem)',
                'is_quick_win' => true,
                'impact_target' => "Garantit la résilience de l'organisation en cas d'attaque par ransomware ou de sinistre matériel."
            ];
        }

        // 4. Authentification / MFA
        if (in_array($answers['auth_security'] ?? '', ['mot_de_passe_simple_partage', 'mot_de_passe_unique_par_agent'])) {
            $recs[] = [
                'code' => 'MFA_DEPLOYMENT',
                'pillar' => 'Opérationnel',
                'pillar_code' => 'operational',
                'title' => 'Généraliser le Double Facteur (MFA) et un Gestionnaire de Mots de Passe',
                'diagnostic' => "Comptes d'entreprise vulnérables au piratage en raison de mots de passe uniques sans double facteur.",
                'action' => "Rendre obligatoire le MFA sur la messagerie et les applications métiers clés, et déployer un coffre-fort de mots de passe.",
                'tools' => ['Bitwarden Enterprise', '1Password Teams', 'Microsoft Authenticator', 'Google Authenticator'],
                'priority' => 'Critique',
                'priority_level' => 1,
                'effort' => 'Quick Win (1-2 sem)',
                'is_quick_win' => true,
                'impact_target' => "Bloque plus de 99% des tentatives d'usurpation de compte et d'accès frauduleux."
            ];
        }

        // 5. Automatisation
        if (in_array($answers['automation_level'] ?? '', ['100_pourcent_manuel', 'quelques_macros_ou_zapier_isole'])) {
            $isProd = in_array('productivity_automation', $targets);
            $recs[] = [
                'code' => 'AUTOMATION_WORKFLOWS',
                'pillar' => 'Productif',
                'pillar_code' => 'productive',
                'title' => 'Automatiser les flux récurrents et supprimer les tâches manuelles',
                'diagnostic' => "Ressaisies manuelles quotidiennes génératrices de fatigue opérationnelle et de risques d'erreur.",
                'action' => "Identifier les 3 processus les plus répétitifs et mettre en place des connecteurs d'automatisation.",
                'tools' => ['Make (Integromat)', 'Zapier', 'n8n', 'Power Automate'],
                'priority' => $isProd ? 'Critique' : 'Élevée',
                'priority_level' => $isProd ? 1 : 2,
                'effort' => 'Quick Win (1-2 sem)',
                'is_quick_win' => true,
                'impact_target' => "Fait gagner des dizaines d'heures par mois et fiabilise la circulation de l'information."
            ];
        }

        // 6. Matériel vieillissant
        if (($answers['hardware_age'] ?? '') === 'plus_de_5_ans') {
            $recs[] = [
                'code' => 'HARDWARE_REFRESH',
                'pillar' => 'Matériel',
                'pillar_code' => 'hardware',
                'title' => 'Renouveler le parc informatique vieillissant (> 5 ans)',
                'diagnostic' => "Postes de travail obsolètes entraînant des lenteurs, des pannes récurrentes et une vulnérabilité aux failles système.",
                'action' => "Établir un plan de renouvellement programmé des ordinateurs vers des postes récents avec disques SSD rapides.",
                'tools' => ['Formule de leasing matériel pro', 'PC portables SSD NVMe min 16Go RAM', 'Stations d\'accueil USB-C'],
                'priority' => in_array('hardware_modernization', $targets) ? 'Critique' : 'Élevée',
                'priority_level' => in_array('hardware_modernization', $targets) ? 1 : 2,
                'effort' => 'Projet Structurant (3-6 mois)',
                'is_quick_win' => false,
                'impact_target' => "Restaure la productivité au poste de travail et améliore le confort quotidien des collaborateurs."
            ];
        }

        // Tri : priorité 1 en premier, puis Quick Wins
        usort($recs, function ($a, $b) {
            if ($a['priority_level'] !== $b['priority_level']) {
                return $a['priority_level'] <=> $b['priority_level'];
            }
            return ($b['is_quick_win'] ? 1 : 0) <=> ($a['is_quick_win'] ? 1 : 0);
        });

        return $recs;
    }
}
