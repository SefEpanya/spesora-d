@extends('layouts.app')

@section('title', 'Questionnaire • SPESORA Diagnostic Flash')

@section('content')
<div class="container py-3" style="max-width: 960px;">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3 no-print">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Questionnaire Diagnostic Flash</li>
        </ol>
    </nav>

    <!-- Presets Bar (1-Click Test Scenarios) -->
    <div class="card card-custom p-3 mb-4 border-primary-subtle bg-primary-subtle bg-opacity-25 no-print">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
            <div class="fw-bold text-primary d-flex align-items-center gap-2">
                <i class="bi bi-magic fs-5"></i>
                <span>Scénarios types SPESORA (Pré-remplissage 1-clic) :</span>
            </div>
            <span class="text-muted small">Sélectionnez un profil pour tester le calcul de score</span>
        </div>
        <div class="row g-2">
            <div class="col-md-4">
                <button type="button" class="btn btn-white w-100 text-start border rounded-3 p-2 shadow-sm h-100 hover-shadow" onclick="loadPreset('ecommerce_tpe')">
                    <div class="fw-bold text-dark small">TPE Commerce & E-commerce</div>
                    <div class="text-muted" style="font-size: 0.75rem;">Cible : Gestion client & Community management</div>
                </button>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-white w-100 text-start border rounded-3 p-2 shadow-sm h-100 hover-shadow" onclick="loadPreset('services_pme')">
                    <div class="fw-bold text-dark small">PME Services & Conseil</div>
                    <div class="text-muted" style="font-size: 0.75rem;">Cible : Cybersécurité & Dématérialisation</div>
                </button>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-white w-100 text-start border rounded-3 p-2 shadow-sm h-100 hover-shadow" onclick="loadPreset('industrie_eti')">
                    <div class="fw-bold text-dark small">ETI Industrie & Production</div>
                    <div class="text-muted" style="font-size: 0.75rem;">Cible : Automatisation & Modernisation matériel</div>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Diagnostic Form -->
    <form action="{{ route('diagnostic.store') }}" method="POST" id="diagnosticForm" class="needs-validation">
        @csrf

        <!-- Section 1 : Organisation -->
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-3">
                <span class="badge bg-primary fs-6 rounded-pill px-3 py-2">1</span>
                <div>
                    <h5 class="fw-bold mb-0">Identification de l'Organisation</h5>
                    <small class="text-muted">Renseignez le contexte général de l'entreprise</small>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="company_name" class="form-label fw-semibold small">Nom de l'organisation *</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" required value="Acme Solutions">
                </div>
                <div class="col-md-3">
                    <label for="sector" class="form-label fw-semibold small">Secteur d'activité *</label>
                    <select class="form-select" id="sector" name="sector" required>
                        <option value="services" selected>Services & Conseil</option>
                        <option value="commerce">Commerce & E-commerce</option>
                        <option value="industrie">Industrie & BTP</option>
                        <option value="sante">Santé & Médico-social</option>
                        <option value="hotellerie">Hôtellerie & Restauration</option>
                        <option value="tech">Tech & Digital</option>
                        <option value="autre">Autre secteur</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="size" class="form-label fw-semibold small">Taille de l'organisation *</label>
                    <select class="form-select" id="size" name="size" required>
                        <option value="tpe">TPE (1 à 9 salariés)</option>
                        <option value="pme" selected>PME (10 à 49 salariés)</option>
                        <option value="eti">ETI (50 à 249 salariés)</option>
                        <option value="grande">Grande entreprise (250+)</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="contact_name" class="form-label fw-semibold small">Interlocuteur référent</label>
                    <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Nom et Prénom">
                </div>
                <div class="col-md-4">
                    <label for="contact_email" class="form-label fw-semibold small">Email de contact</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="contact@organisation.com">
                </div>
                <div class="col-md-4">
                    <label for="budget_range" class="form-label fw-semibold small">Capacité budgétaire d'amélioration</label>
                    <select class="form-select" id="budget_range" name="budget_range">
                        <option value="limite">Budget contraint / Économique</option>
                        <option value="modere" selected>Budget modéré / Équilibré</option>
                        <option value="confortable">Budget actif / Investissement prioritaire</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 2 : Objectifs Stratégiques (Analogie Fiche de Poste) -->
        <div class="card card-custom p-4 mb-4 border-primary">
            <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-3">
                <span class="badge bg-primary fs-6 rounded-pill px-3 py-2">2</span>
                <div>
                    <h5 class="fw-bold mb-0">Objectifs Stratégiques Ciblés (La "Fiche de Poste" du SI)</h5>
                    <small class="text-muted">Sélectionnez les priorités que l'existant doit soutenir pour le calcul d'adéquation</small>
                </div>
            </div>

            <div class="row g-3">
                @foreach($targets as $key => $target)
                <div class="col-md-6">
                    <div class="form-check p-3 border rounded-3 h-100 bg-light-subtle">
                        <input class="form-check-input target-cb" type="checkbox" name="target_objectifs[]" value="{{ $key }}" id="target_{{ $key }}"
                            @if(!empty($preselectedTarget) ? ($key === $preselectedTarget) : in_array($key, ['client_management', 'cybersecurity'])) checked @endif>
                        <label class="form-check-label fw-bold text-dark ms-1 d-block" for="target_{{ $key }}">
                            {{ $target['label'] }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Section 3 : Pilier Logiciel -->
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-3">
                <span class="badge bg-primary fs-6 rounded-pill px-3 py-2">3</span>
                <div>
                    <h5 class="fw-bold mb-0">Pilier 1 : Logiciel & Applications</h5>
                    <small class="text-muted">Outils de gestion commerciale, facturation et collaboration</small>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="crm_tool" class="form-label fw-semibold small">Gestion commerciale & CRM</label>
                    <select class="form-select" id="crm_tool" name="crm_tool">
                        <option value="aucun">Aucun outil formalisé</option>
                        <option value="tableur_excel" selected>Tableur Excel / Feuilles volantes</option>
                        <option value="crm_basique">CRM simple (HubSpot free, Pipedrive, Notion...)</option>
                        <option value="crm_avance">CRM structuré et interconnecté (Salesforce, HubSpot Pro...)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="erp_billing_tool" class="form-label fw-semibold small">Facturation, Devis & ERP</label>
                    <select class="form-select" id="erp_billing_tool" name="erp_billing_tool">
                        <option value="aucun_facture_papier">Factures papier / Word artisanal</option>
                        <option value="tableur">Tableur Excel manuel</option>
                        <option value="logiciel_facturation_simple" selected>Logiciel SaaS simple (Pennylane, Axonaut, Tiime)</option>
                        <option value="erp_integre">ERP complet intégré (Odoo, Sage, SAP, Cegid)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="collab_suite" class="form-label fw-semibold small">Messagerie & Suite collaborative</label>
                    <select class="form-select" id="collab_suite" name="collab_suite">
                        <option value="email_perso_fournisseur">Emails personnels ou hébergeur basique webmail</option>
                        <option value="email_pro_standard">Email pro avec nom de domaine sans suite cloud</option>
                        <option value="suite_cloud_m365_google" selected>Suite Cloud unifiée (Microsoft 365 ou Google Workspace)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="marketing_tools" class="form-label fw-semibold small">Outils Marketing & Community Management</label>
                    <select class="form-select" id="marketing_tools" name="marketing_tools">
                        <option value="aucun">Aucune présence ni outil</option>
                        <option value="reseaux_sociaux_manuel" selected>Publications manuelles directes sur réseaux sociaux</option>
                        <option value="outils_marketing_dedies_mailchimp_buffer">Outils dédiés (Buffer, Metricool, Canva Pro, Brevo)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="tools_integration" class="form-label fw-semibold small">Intégration & interconnexion des logiciels</label>
                    <select class="form-select" id="tools_integration" name="tools_integration">
                        <option value="silos_aucun_lien">Logiciels isolés en silos : ressaisie manuelle totale</option>
                        <option value="imports_exports_manuels" selected>Exports / Imports manuels par fichiers CSV/Excel</option>
                        <option value="integration_api_zapier">Connecteurs automatisés (Make, Zapier, APIs directes)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 4 : Pilier Matériel -->
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-3">
                <span class="badge bg-info text-dark fs-6 rounded-pill px-3 py-2">4</span>
                <div>
                    <h5 class="fw-bold mb-0">Pilier 2 : Matériel & Réseau</h5>
                    <small class="text-muted">Ordinateurs, connectivité internet et travail nomade</small>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="hardware_age" class="form-label fw-semibold small">Âge moyen du parc informatique</label>
                    <select class="form-select" id="hardware_age" name="hardware_age">
                        <option value="plus_de_5_ans">Plus de 5 ans (lenteurs, pannes régulières)</option>
                        <option value="entre_3_et_5_ans" selected>Entre 3 et 5 ans (fonctionnel mais hétérogène)</option>
                        <option value="moins_de_3_ans">Moins de 3 ans (récent, rapide, SSD généralisé)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="network_quality" class="form-label fw-semibold small">Qualité du Réseau & Wi-Fi</label>
                    <select class="form-select" id="network_quality" name="network_quality">
                        <option value="adsl_4g_instable">ADSL ou 4G instable / Déconnexions</option>
                        <option value="fibre_grand_public_wifi_box" selected>Fibre grand public avec Wi-Fi standard box</option>
                        <option value="fibre_pro_wifi_mesh_switchs">Fibre Pro (GTR) + Wi-Fi maillé professionnel</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="mobility_remote_work" class="form-label fw-semibold small">Équipements Nomades & Télétravail</label>
                    <select class="form-select" id="mobility_remote_work" name="mobility_remote_work">
                        <option value="fixes_uniquement_pas_de_vpn">PC fixes uniquement / Pas d'accès distant sécurisé</option>
                        <option value="portables_heterogenes_vpn_basique" selected>PC portables hétérogènes / VPN basique ou BYOD</option>
                        <option value="portables_securises_vpn_mdm">Portables sécurisés (chiffrement BitLocker + MDM)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="servers_infrastructure" class="form-label fw-semibold small">Hébergement & Serveurs</label>
                    <select class="form-select" id="servers_infrastructure" name="servers_infrastructure">
                        <option value="serveur_local_obsolete">Serveur local ancien non supervisé</option>
                        <option value="serveur_local_recent">Serveur local récent sous contrat</option>
                        <option value="cloud_ou_hybride_maitrise" selected>100% Cloud ou Hybride moderne maîtrisé</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 5 : Pilier Opérationnel & Sécurité -->
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-3">
                <span class="badge bg-danger fs-6 rounded-pill px-3 py-2">5</span>
                <div>
                    <h5 class="fw-bold mb-0">Pilier 3 : Opérationnel & Sécurité</h5>
                    <small class="text-muted">Sauvegardes 3-2-1, résilience cyber, RGPD et maintenance</small>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="backup_policy" class="form-label fw-semibold small">Politique de sauvegarde des données</label>
                    <select class="form-select" id="backup_policy" name="backup_policy">
                        <option value="aucune">Aucune sauvegarde systématique</option>
                        <option value="cle_usb_disque_externe_irregulier">Disque externe / Clé USB manuel</option>
                        <option value="sauvegarde_cloud_automatique_sans_test" selected>Sauvegarde Cloud auto sans test de restauration</option>
                        <option value="regle_321_automatisee_testee">Règle 3-2-1 immuable et restaurations testées</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="auth_security" class="form-label fw-semibold small">Authentification & Mots de passe</label>
                    <select class="form-select" id="auth_security" name="auth_security">
                        <option value="mot_de_passe_simple_partage">Mots de passe simples partagés, pas de 2FA</option>
                        <option value="mot_de_passe_unique_par_agent" selected>Mots de passe individuels mais sans 2FA généralisé</option>
                        <option value="mfa_gestionnaire_mdp_deploie">MFA (Double facteur) obligatoire + Coffre-fort MdP</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="endpoint_protection" class="form-label fw-semibold small">Protection des Postes & Antivirus</label>
                    <select class="form-select" id="endpoint_protection" name="endpoint_protection">
                        <option value="antivirus_gratuit_ou_aucun">Antivirus gratuit grand public ou absent</option>
                        <option value="antivirus_standard_incomplet" selected>Antivirus standard sans console centralisée</option>
                        <option value="edr_antivirus_centralise_maj_auto">Protection EDR managée avec mises à jour auto</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="maintenance_support" class="form-label fw-semibold small">Maintenance & Support informatique</label>
                    <select class="form-select" id="maintenance_support" name="maintenance_support">
                        <option value="au_coup_par_coup_ami_bricoleur">Au coup par coup / Bricolage improvisé</option>
                        <option value="referent_interne_non_dedie" selected>Référent interne non informaticien qui dépanne</option>
                        <option value="infogerance_contrat_sla_ou_dsi">Contrat d'infogérance avec SLA garanti ou DSI</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="gdpr_compliance" class="form-label fw-semibold small">Sensibilisation & Conformité RGPD</label>
                    <select class="form-select" id="gdpr_compliance" name="gdpr_compliance">
                        <option value="aucune_notion">Aucune démarche ni sensibilisation</option>
                        <option value="sensibilisation_partielle" selected>Démarche partielle / Notion basique</option>
                        <option value="conformite_documentee_dpo_registre">Registre tenu, DPO désigné et conformité suivie</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 6 : Pilier Productivité -->
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-3">
                <span class="badge bg-success fs-6 rounded-pill px-3 py-2">6</span>
                <div>
                    <h5 class="fw-bold mb-0">Pilier 4 : Productivité & Humain</h5>
                    <small class="text-muted">Automatisation des tâches, culture numérique et documentation</small>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="automation_level" class="form-label fw-semibold small">Automatisation des tâches répétitives</label>
                    <select class="form-select" id="automation_level" name="automation_level">
                        <option value="100_pourcent_manuel">100% manuel : ressaisie permanente</option>
                        <option value="quelques_macros_ou_zapier_isole" selected>Quelques automatisations isolées (macros ou Zapier basique)</option>
                        <option value="workflows_automatises_standardises">Workflows standardisés connectant les outils</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="team_training" class="form-label fw-semibold small">Formation numérique des équipes</label>
                    <select class="form-select" id="team_training" name="team_training">
                        <option value="jamais_formes_autodidactes">Aucune formation : autodidactes hétérogènes</option>
                        <option value="formation_sur_le_tas_ponctuelle" selected>Formation sur le tas informelle lors des arrivées</option>
                        <option value="plan_formation_continu_outils_digitaux">Plan de formation continu et sensibilisation cyber</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="process_documentation" class="form-label fw-semibold small">Documentation des procédures (SOP / Wik)</label>
                    <select class="form-select" id="process_documentation" name="process_documentation">
                        <option value="tout_est_dans_la_tete">Tout est oral : risque élevé lors des départs</option>
                        <option value="quelques_fiches_non_a_jour" selected>Quelques documents Word/PDF épars souvent obsolètes</option>
                        <option value="wikis_procedures_claires_documentees">Base de connaissances collaborative à jour (Notion, SharePoint)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="cross_team_collaboration" class="form-label fw-semibold small">Fluidité de la collaboration inter-équipes</label>
                    <select class="form-select" id="cross_team_collaboration" name="cross_team_collaboration">
                        <option value="friction_chacun_son_fichier">Frictions : fichiers verrouillés, versions concurrentes</option>
                        <option value="echanges_emails_lourds" selected>Flux lourds par emails avec pièces jointes multiples</option>
                        <option value="travail_collaboratif_temps_reel_chat">Édition simultanée en temps réel & messagerie d'équipe</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 py-3">
            <span class="text-muted small">
                <i class="bi bi-shield-lock-fill text-success me-1"></i> Données sécurisées & traitées conformément au protocole SPESORA GROUP.
            </span>
            <button type="submit" class="btn btn-spesora-primary btn-lg rounded-pill px-5 shadow">
                <i class="bi bi-calculator me-2"></i> Calculer le Diagnostic & les Recommandations
            </button>
        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
    const presets = {
        ecommerce_tpe: {
            company_name: 'NovaStyle Boutique',
            sector: 'commerce',
            size: 'tpe',
            budget_range: 'modere',
            targets: ['client_management', 'digital_presence'],
            answers: {
                crm_tool: 'tableur_excel',
                erp_billing_tool: 'logiciel_facturation_simple',
                collab_suite: 'suite_cloud_m365_google',
                marketing_tools: 'reseaux_sociaux_manuel',
                tools_integration: 'imports_exports_manuels',
                hardware_age: 'entre_3_et_5_ans',
                network_quality: 'fibre_grand_public_wifi_box',
                mobility_remote_work: 'portables_heterogenes_vpn_basique',
                servers_infrastructure: 'cloud_ou_hybride_maitrise',
                backup_policy: 'sauvegarde_cloud_automatique_sans_test',
                auth_security: 'mot_de_passe_simple_partage',
                endpoint_protection: 'antivirus_standard_incomplet',
                maintenance_support: 'referent_interne_non_dedie',
                gdpr_compliance: 'sensibilisation_partielle',
                automation_level: 'quelques_macros_ou_zapier_isole',
                team_training: 'formation_sur_le_tas_ponctuelle',
                process_documentation: 'quelques_fiches_non_a_jour',
                cross_team_collaboration: 'echanges_emails_lourds'
            }
        },
        services_pme: {
            company_name: 'Stratégie & Conseil Partenaires',
            sector: 'services',
            size: 'pme',
            budget_range: 'confortable',
            targets: ['cybersecurity', 'process_digitization'],
            answers: {
                crm_tool: 'crm_basique',
                erp_billing_tool: 'tableur',
                collab_suite: 'suite_cloud_m365_google',
                marketing_tools: 'outils_marketing_dedies_mailchimp_buffer',
                tools_integration: 'imports_exports_manuels',
                hardware_age: 'entre_3_et_5_ans',
                network_quality: 'fibre_grand_public_wifi_box',
                mobility_remote_work: 'portables_heterogenes_vpn_basique',
                servers_infrastructure: 'cloud_ou_hybride_maitrise',
                backup_policy: 'cle_usb_disque_externe_irregulier',
                auth_security: 'mot_de_passe_simple_partage',
                endpoint_protection: 'antivirus_standard_incomplet',
                maintenance_support: 'au_coup_par_coup_ami_bricoleur',
                gdpr_compliance: 'sensibilisation_partielle',
                automation_level: 'quelques_macros_ou_zapier_isole',
                team_training: 'jamais_formes_autodidactes',
                process_documentation: 'tout_est_dans_la_tete',
                cross_team_collaboration: 'echanges_emails_lourds'
            }
        },
        industrie_eti: {
            company_name: 'MécanoTech Industries',
            sector: 'industrie',
            size: 'eti',
            budget_range: 'modere',
            targets: ['productivity_automation', 'hardware_modernization'],
            answers: {
                crm_tool: 'aucun',
                erp_billing_tool: 'erp_integre',
                collab_suite: 'email_pro_standard',
                marketing_tools: 'aucun',
                tools_integration: 'silos_aucun_lien',
                hardware_age: 'plus_de_5_ans',
                network_quality: 'adsl_4g_instable',
                mobility_remote_work: 'fixes_uniquement_pas_de_vpn',
                servers_infrastructure: 'serveur_local_obsolete',
                backup_policy: 'sauvegarde_cloud_automatique_sans_test',
                auth_security: 'mot_de_passe_unique_par_agent',
                endpoint_protection: 'antivirus_gratuit_ou_aucun',
                maintenance_support: 'referent_interne_non_dedie',
                gdpr_compliance: 'aucune_notion',
                automation_level: '100_pourcent_manuel',
                team_training: 'jamais_formes_autodidactes',
                process_documentation: 'quelques_fiches_non_a_jour',
                cross_team_collaboration: 'friction_chacun_son_fichier'
            }
        }
    };

    function loadPreset(key) {
        const p = presets[key];
        if (!p) return;

        document.getElementById('company_name').value = p.company_name;
        document.getElementById('sector').value = p.sector;
        document.getElementById('size').value = p.size;
        document.getElementById('budget_range').value = p.budget_range;

        // Targets
        document.querySelectorAll('.target-cb').forEach(cb => {
            cb.checked = p.targets.includes(cb.value);
        });

        // Answers
        for (const [id, val] of Object.entries(p.answers)) {
            const el = document.getElementById(id);
            if (el) el.value = val;
        }

        // Highlight company name
        const input = document.getElementById('company_name');
        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        input.classList.add('is-valid');
        setTimeout(() => input.classList.remove('is-valid'), 1500);
    }
</script>
@endsection
