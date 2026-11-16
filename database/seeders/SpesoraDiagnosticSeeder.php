<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Framework;
use App\Models\Questionnaire;
use App\Models\Section;
use App\Models\Question;
use App\Models\AnswerOption;

/**
 * Seeder SpesoraDiagnosticSeeder
 * 
 * Initialise le référentiel d'évaluation officiel SPESORA GROUP (4 piliers).
 */
class SpesoraDiagnosticSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Piliers d'évaluation
        $pillars = [
            ['code' => 'software', 'name' => 'Logiciel & Outils Métiers', 'description' => 'Maturité des logiciels de gestion, CRM, ERP et interconnexion API.', 'icon' => 'bi-laptop', 'default_weight' => 0.25],
            ['code' => 'hardware', 'name' => 'Matériel & Infrastructure Réseau', 'description' => 'Parc informatique, serveurs, connectivité réseau et travail hybride.', 'icon' => 'bi-hdd-network', 'default_weight' => 0.25],
            ['code' => 'operational', 'name' => 'Opérationnel & Sécurité des Données', 'description' => 'Sauvegardes 3-2-1, authentification MFA, EDR, infogérance et RGPD.', 'icon' => 'bi-shield-check', 'default_weight' => 0.25],
            ['code' => 'productive', 'name' => 'Productivité & Compétences Humaines', 'description' => 'Automatisation des flux, formation aux outils et documentation.', 'icon' => 'bi-lightning-charge', 'default_weight' => 0.25],
        ];

        foreach ($pillars as $p) {
            Framework::updateOrCreate(['code' => $p['code']], $p);
        }

        // 2. Questionnaire principal
        $questionnaire = Questionnaire::updateOrCreate(
            ['code' => 'SPESORA_FLASH_V1'],
            [
                'title' => 'SPESORA Diagnostic Flash v1.0',
                'description' => 'Questionnaire officiel d\'évaluation organisationnelle et de performance du Système d\'Information.',
                'version' => '1.0',
                'is_active' => true,
            ]
        );

        // 3. Sections thématiques
        $sectionsData = [
            ['title' => 'Logiciel & Applications Métiers', 'subtitle' => 'Maturité des outils de relation client, facturation et outils collaboratifs', 'pillar_code' => 'software', 'order' => 1],
            ['title' => 'Matériel, Réseau & Mobilité', 'subtitle' => 'Performance des postes, réseau fibre/Wi-Fi et conditions de travail nomade', 'pillar_code' => 'hardware', 'order' => 2],
            ['title' => 'Opérationnel, Cyber & Continuité', 'subtitle' => 'Résilience des sauvegardes, MFA, antivirus EDR et conformité RGPD', 'pillar_code' => 'operational', 'order' => 3],
            ['title' => 'Productivité & Collaboration', 'subtitle' => 'Automatisation des tâches manuelles, formation continue et documentation', 'pillar_code' => 'productive', 'order' => 4],
        ];

        foreach ($sectionsData as $s) {
            $section = Section::updateOrCreate(
                ['questionnaire_id' => $questionnaire->id, 'title' => $s['title']],
                $s
            );
        }
    }
}
