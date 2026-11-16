<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paramètres Généraux SPESORA GROUP
    |--------------------------------------------------------------------------
    */
    'app_title' => env('APP_NAME', 'SPESORA GROUP • Diagnostic Flash & Solutions Numériques'),
    'group_name' => 'SPESORA GROUP',
    'location' => 'Douala, Cameroun',
    'support_email' => env('SPESORA_ADMIN_NOTIFICATION_EMAIL', 'contact@spesora.group'),
    'phone' => '+237 6 00 00 00 00',
    'tagline' => 'Transformation numérique & renforcement des capacités',
    'subtitle' => 'Solutions numériques · Formation professionnelle · Support technique',

    /*
    |--------------------------------------------------------------------------
    | Vision & Mission de l'entreprise
    |--------------------------------------------------------------------------
    */
    'mission' => "Faciliter l'adoption technologique en améliorant durablement les compétences des utilisateurs et garantissant une exploitation fluide des logiciels.",
    'vision' => "Devenir l'acteur de référence au Cameroun et à l'international pour la transformation digitale efficace et l'autonomie logicielle.",

    /*
    |--------------------------------------------------------------------------
    | Les 4 Piliers Fondamentaux de SPESORA GROUP (Apport à l'organisation)
    |--------------------------------------------------------------------------
    */
    'services' => [
        'audit_performance' => [
            'id' => 'audit_performance',
            'number' => '01',
            'title' => 'Audit de performance',
            'tagline' => 'Un état des lieux de vos outils, de vos équipes et de votre gestion avant d’investir.',
            'icon' => 'bi-speedometer2',
            'badge_color' => '#5c2d42',
            'color' => 'plum',
            'target_key' => 'productivity_automation',
            'description' => 'Évaluation exhaustive de votre maturité numérique, cartographie des flux de travail, analyse de la productivité des équipes et identification des freins opérationnels.',
            'deliverables' => [
                'État des lieux des logiciels et équipements',
                'Évaluation des compétences et des usages réels',
                'Matrice d’aide à la décision avant investissement',
                'Plan d’actions prioritaires et Quick Wins',
            ],
            'cta_label' => 'Lancer l’Audit Flash',
        ],
        'integration_logiciels' => [
            'id' => 'integration_logiciels',
            'number' => '02',
            'title' => 'Intégration de logiciels',
            'tagline' => 'Des solutions choisies et déployées selon vos besoins réels.',
            'icon' => 'bi-grid-1x2',
            'badge_color' => '#2e7d32',
            'color' => 'success',
            'target_key' => 'client_management',
            'description' => 'Sélection, paramétrage sur-mesure et interconnexion des progiciels métiers (CRM, facturation, ERP, outils collaboratifs, suites cloud).',
            'deliverables' => [
                'Analyse & Conseil : Étude des besoins métiers et choix orienté',
                'Déploiement : Installation, configuration et paramétrage complet',
                'Intégration : Connexion harmonieuse à l’infrastructure existante',
                'Données & Mise en Service : Migration et prise en main opérationnelle',
            ],
            'cta_label' => 'Évaluer mon besoin logiciel',
        ],
        'formation' => [
            'id' => 'formation',
            'number' => '03',
            'title' => 'Formation professionnelle',
            'tagline' => 'Des utilisateurs autonomes, qui exploitent pleinement leurs outils.',
            'icon' => 'bi-mortarboard',
            'badge_color' => '#5c2d42',
            'color' => 'plum',
            'target_key' => 'process_digitization',
            'description' => 'Programmes axés sur la pratique terrain et la création de supports sur-mesure pour garantir un transfert de compétences immédiat et durable.',
            'deliverables' => [
                'Formations Logicielles : Maîtrise pratique des applications métiers',
                'Compétences Numériques : Outils de gestion modernes et collaboratifs',
                'Pédagogie & Changement : Ateliers pratiques et accompagnement humain',
                'Création de supports personnalisés et suivi post-formation',
            ],
            'cta_label' => 'Diagnostiquer les compétences',
        ],
        'support_technique' => [
            'id' => 'support_technique',
            'number' => '04',
            'title' => 'Support technique',
            'tagline' => 'Un accompagnement durable après la mise en service.',
            'icon' => 'bi-headset',
            'badge_color' => '#2e7d32',
            'color' => 'success',
            'target_key' => 'cybersecurity',
            'description' => 'Assistance permanente, maintenance préventive et curative, sécurisation des accès et gestion rigoureuse des incidents au quotidien.',
            'deliverables' => [
                'Résolution d’Incidents : Diagnostic rapide et correction efficace',
                'Assistance Utilisateurs : Aide permanente sur les accès et requêtes',
                'Modalités Flexibles : Interventions à distance ou sur site selon vos impératifs',
                'Suivi & Tracé : Documentation rigoureuse pour une amélioration continue',
            ],
            'cta_label' => 'Tester la résilience support',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notre Méthode en Cinq Étapes (01 à 05)
    |--------------------------------------------------------------------------
    */
    'methodology_steps' => [
        [
            'step' => '01',
            'title' => 'Comprendre',
            'description' => 'Analyse approfondie des besoins, de l’existant et des contraintes spécifiques de votre organisation.',
            'icon' => 'bi-search',
        ],
        [
            'step' => '02',
            'title' => 'Recommander',
            'description' => 'Recommandation impartiale de solutions adaptées, calibrées sur vos objectifs et votre budget.',
            'icon' => 'bi-lightbulb',
        ],
        [
            'step' => '03',
            'title' => 'Déployer',
            'description' => 'Configuration technique, migration sécurisée des données et intégration harmonieuse aux outils existants.',
            'icon' => 'bi-cpu',
        ],
        [
            'step' => '04',
            'title' => 'Transmettre',
            'description' => 'Formation dynamique et humaine des utilisateurs pour une prise en main rapide et une autonomie totale.',
            'icon' => 'bi-person-check',
        ],
        [
            'step' => '05',
            'title' => 'Accompagner',
            'description' => 'Support technique continu, suivi des performances et amélioration continue des pratiques métiers.',
            'icon' => 'bi-shield-check',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Nos Valeurs Ajoutées (Atouts)
    |--------------------------------------------------------------------------
    */
    'values' => [
        [
            'title' => 'Excellence',
            'description' => 'Prestations rigoureuses et parfaitement ajustées aux réels besoins.',
            'icon' => 'bi-award',
        ],
        [
            'title' => 'Proximité',
            'description' => 'Écoute active des contraintes et suivi personnalisé accessible.',
            'icon' => 'bi-geo-alt',
        ],
        [
            'title' => 'Innovation',
            'description' => 'Adoption continue de solutions technologiques performantes.',
            'icon' => 'bi-lightning-charge',
        ],
        [
            'title' => 'Transmission',
            'description' => 'Partage du savoir pour garantir l’autonomie totale du client.',
            'icon' => 'bi-people',
        ],
        [
            'title' => 'Fiabilité & Durabilité',
            'description' => 'Création de partenariats solides basés sur le suivi transparent et la confiance mutuelle.',
            'icon' => 'bi-hand-thumbs-up',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Marchés Cibles
    |--------------------------------------------------------------------------
    */
    'target_markets' => [
        [
            'title' => 'PME & Entreprises',
            'description' => 'Accélération de la croissance et fluidification de la gestion par le numérique.',
            'icon' => 'bi-building',
        ],
        [
            'title' => 'Institutions',
            'description' => 'Modernisation des services publics, fiabilisation des processus et structures.',
            'icon' => 'bi-bank',
        ],
        [
            'title' => 'Établissements',
            'description' => 'Centres de formation, universités et organismes d’enseignement.',
            'icon' => 'bi-mortarboard',
        ],
        [
            'title' => 'Indépendants & Professionnels',
            'description' => 'Professionnels recherchant la maîtrise logicielle et l’efficacité au quotidien.',
            'icon' => 'bi-person-badge',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Références d'expérience concrète
    |--------------------------------------------------------------------------
    */
    'references' => [
        'tagline' => 'Une expérience concrète auprès d’entreprises',
        'intro' => 'Missions ponctuelles réalisées comme prestataire externe pour NUMIAS SARL et TITAN DYNAMICS LLC BROKERS.',
        'promise' => 'Pour vous : des interventions ciblées, à la mission, sans structure lourde à mettre en place.',
        'clients' => ['NUMIAS SARL', 'TITAN DYNAMICS LLC BROKERS'],
        'projects' => [
            [
                'title' => 'Accompagnement de campagnes publicitaires en ligne',
                'clients' => 'TITAN DYNAMICS · NUMIAS',
                'icon' => 'bi-megaphone',
            ],
            [
                'title' => 'Développement d’interfaces graphiques d’applications web',
                'clients' => 'NUMIAS',
                'icon' => 'bi-window-fullscreen',
            ],
            [
                'title' => 'Conseil en stratégie numérique',
                'clients' => 'TITAN DYNAMICS',
                'icon' => 'bi-chat-left-dots',
            ],
            [
                'title' => 'Tests et assurance qualité logicielle',
                'clients' => 'NUMIAS',
                'icon' => 'bi-check2-circle',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Référentiel des 4 Piliers d'Évaluation Flash
    |--------------------------------------------------------------------------
    */
    'pillars' => [
        'software' => [
            'code' => 'software',
            'name' => 'Logiciel & Outils Métiers',
            'icon' => 'bi-laptop',
            'color' => 'plum',
            'description' => 'Maturité des applications, CRM, ERP, interconnexion et suites collaboratives.'
        ],
        'hardware' => [
            'code' => 'hardware',
            'name' => 'Matériel & Infrastructure Réseau',
            'icon' => 'bi-hdd-network',
            'color' => 'success',
            'description' => 'Modernité du parc informatique, débit réseau, serveurs et politique nomade/hybride.'
        ],
        'operational' => [
            'code' => 'operational',
            'name' => 'Opérationnel & Sécurité des Données',
            'icon' => 'bi-shield-check',
            'color' => 'plum',
            'description' => 'Sauvegardes 3-2-1, authentification forte (MFA), cyber-résilience, RGPD et support.'
        ],
        'productive' => [
            'code' => 'productive',
            'name' => 'Productivité & Compétences Humaines',
            'icon' => 'bi-lightning-charge',
            'color' => 'success',
            'description' => 'Automatisation des processus, culture numérique des équipes et documentation.'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Objectifs Stratégiques Ciblés (Fiche de Poste de l'Organisation)
    |--------------------------------------------------------------------------
    */
    'targets' => [
        'productivity_automation' => [
            'label' => 'Audit de performance : Optimiser la gestion & débloquer les goulets d’étranglement',
            'weights' => ['software' => 0.30, 'hardware' => 0.15, 'operational' => 0.15, 'productive' => 0.40],
            'benchmarks' => ['software' => 75, 'hardware' => 65, 'operational' => 70, 'productive' => 85]
        ],
        'client_management' => [
            'label' => 'Intégration de logiciels : CRM, facturation, ERP & interconnexion sans couture',
            'weights' => ['software' => 0.40, 'hardware' => 0.10, 'operational' => 0.20, 'productive' => 0.30],
            'benchmarks' => ['software' => 80, 'hardware' => 60, 'operational' => 65, 'productive' => 75]
        ],
        'process_digitization' => [
            'label' => 'Formation professionnelle : Renforcer l’autonomie & l’efficacité des utilisateurs',
            'weights' => ['software' => 0.35, 'hardware' => 0.15, 'operational' => 0.25, 'productive' => 0.25],
            'benchmarks' => ['software' => 80, 'hardware' => 65, 'operational' => 75, 'productive' => 75]
        ],
        'cybersecurity' => [
            'label' => 'Support technique & Cybersécurité : Continuité de service, sauvegardes & maintenance',
            'weights' => ['software' => 0.15, 'hardware' => 0.25, 'operational' => 0.45, 'productive' => 0.15],
            'benchmarks' => ['software' => 65, 'hardware' => 75, 'operational' => 90, 'productive' => 65]
        ],
        'digital_presence' => [
            'label' => 'Visibilité numérique & campagnes en ligne (Réseaux, interfaces web)',
            'weights' => ['software' => 0.45, 'hardware' => 0.15, 'operational' => 0.15, 'productive' => 0.25],
            'benchmarks' => ['software' => 85, 'hardware' => 60, 'operational' => 60, 'productive' => 70]
        ],
        'hardware_modernization' => [
            'label' => 'Moderniser le parc informatique, connectivité & travail nomade',
            'weights' => ['software' => 0.15, 'hardware' => 0.50, 'operational' => 0.25, 'productive' => 0.10],
            'benchmarks' => ['software' => 60, 'hardware' => 85, 'operational' => 75, 'productive' => 60]
        ]
    ]
];
