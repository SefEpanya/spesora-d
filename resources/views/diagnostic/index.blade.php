@extends('layouts.app')

@section('title', 'SPESORA GROUP • Transformation numérique & renforcement des capacités')

@section('content')
<div class="container py-2">

    <!-- Hero Section (Slide 1 & Slide 10) -->
    <div class="p-4 p-md-5 mb-5 rounded-4 shadow-lg position-relative overflow-hidden text-white" 
         style="background: linear-gradient(135deg, var(--spesora-plum-dark) 0%, var(--spesora-plum) 60%, #431728 100%); border-bottom: 4px solid var(--spesora-green);">
        <div class="row align-items-center">
            <div class="col-lg-8 position-relative z-1 py-2">
                <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                    <span class="pill-badge pill-green text-dark fw-bold">
                        <i class="bi bi-geo-alt-fill me-1 text-success"></i> SPESORA GROUP · DOUALA
                    </span>
                    <span class="pill-badge pill-plum border-white border-opacity-25">
                        Accompagnement Métier
                    </span>
                    <span class="pill-badge pill-plum cborder-white border-opacity-25">
                        Expertise Logicielle
                    </span>
                </div>

                <h1 class="display-4 fw-bold text-white mb-3 tracking-tight" style="line-height: 1.15;">
                    Transformation numérique & renforcement des capacités
                </h1>
                
                <p class="lead text-white-50 mb-4" style="font-size: 1.25rem;">
                    <strong>Solutions numériques · Formation professionnelle · Support technique</strong>
                </p>

                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-10 mb-4" style="max-width: 680px;">
                    <p class="small text-light mb-0 italic">
                        <i class="bi bi-quote fs-5 text-warning me-1"></i>
                        Construisons ensemble votre transformation numérique : des solutions adaptées, des compétences renforcées et un accompagnement durable.
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <a href="{{ route('diagnostic.create') }}" class="btn btn-spesora-green btn-lg px-4 py-3 rounded-pill fw-bold text-white shadow-lg">
                        <i class="bi bi-speedometer2 me-2"></i> Lancer l'Audit de performance Flash
                    </a>
                    <a href="#services" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-semibold">
                        <i class="bi bi-grid-fill me-2"></i> Découvrir nos 4 Piliers
                    </a>
                </div>

                <div class="d-flex flex-wrap gap-4 mt-4 pt-3 border-top border-white border-opacity-15 text-white-50 small">
                    <div><i class="bi bi-check2-circle text-warning me-1"></i> Diagnostic instantané en 3 min</div>
                    <div><i class="bi bi-check2-circle text-warning me-1"></i> Base de données MySQL spedeck active</div>
                    <div><i class="bi bi-check2-circle text-warning me-1"></i> Rapport exécutif & Gap Analysis</div>
                </div>
            </div>

            <div class="col-lg-4 d-none d-lg-block text-center position-relative z-1">
                <div class="p-4 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-20 shadow text-start">
                    <div class="text-uppercase small fw-bold text-warning mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                        Notre Engagement
                    </div>
                    <h5 class="fw-bold text-white mb-2">Faciliter l'adoption technologique</h5>
                    <p class="text-white-50 small mb-3">
                        Améliorer durablement les compétences des utilisateurs et garantir une exploitation fluide des logiciels professionnels au Cameroun et à l'international.
                    </p>
                    <div class="p-3 rounded-3 bg-dark bg-opacity-25 border border-white border-opacity-10 text-center">
                        <div class="fs-3 fw-bold text-warning">{{ max($totalDiagnostics ?? 0, 1) }}</div>
                        <div class="text-light small">Diagnostics Flash enregistrés</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: À PROPOS DE NOUS (Slide 2) -->
    <div class="card card-custom p-4 p-md-5 mb-5 border-0 shadow-sm" style="background-color: #ffffff;">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="text-uppercase fw-bold text-spesora-plum small" style="letter-spacing: 0.08em;">
                    À PROPOS DE NOUS
                </span>
                <h2 class="display-6 fw-bold text-dark mt-1 mb-3">Présentation de l'entreprise</h2>
                <div class="border-start border-4 border-success ps-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0">
                        Société de services numériques dédiée à la maîtrise et l'exploitation durable des logiciels professionnels.
                    </h5>
                </div>
                <p class="text-muted mb-4">
                    Nous accompagnons entreprises, institutions et professionnels à travers une approche centrée sur les enjeux métiers et le succès de l'utilisateur. Nous transformons les contraintes informatiques en réels leviers de performance.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 border border-success border-opacity-50 h-100" style="background-color: var(--spesora-green-light);">
                            <div class="fw-bold text-success mb-1 d-flex align-items-center gap-2">
                                <i class="bi bi-eye-fill"></i> Vision Métier
                            </div>
                            <div class="small text-muted">Compréhension profonde des enjeux opérationnels et des processus de chaque organisation.</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 border h-100" style="background-color: #fcf6f9; border-color: #e9d5df !important;">
                            <div class="fw-bold text-spesora-plum mb-1 d-flex align-items-center gap-2">
                                <i class="bi bi-shield-check"></i> Adoption Durable
                            </div>
                            <div class="small text-muted">Autonomie optimale des utilisateurs finaux pour pérenniser chaque investissement logiciel.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 text-center">
                <div class="p-4 rounded-4 bg-light border text-start">
                    <div class="fw-bold text-dark mb-3 d-flex align-items-center justify-content-between">
                        <span>Écosystème Logiciel Maîtrisé</span>
                        <span class="badge bg-success">360°</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-white text-dark border p-2 px-3 shadow-sm"><i class="bi bi-people-fill text-primary me-1"></i> CRM & Relation Client</span>
                        <span class="badge bg-white text-dark border p-2 px-3 shadow-sm"><i class="bi bi-file-earmark-spreadsheet-fill text-success me-1"></i> Facturation & ERP</span>
                        <span class="badge bg-white text-dark border p-2 px-3 shadow-sm"><i class="bi bi-cart-fill text-info me-1"></i> E-commerce & Vente</span>
                        <span class="badge bg-white text-dark border p-2 px-3 shadow-sm"><i class="bi bi-megaphone-fill text-danger me-1"></i> Campagnes AdWords</span>
                        <span class="badge bg-white text-dark border p-2 px-3 shadow-sm"><i class="bi bi-cloud-check-fill text-primary me-1"></i> Suites Cloud & Données</span>
                        <span class="badge bg-white text-dark border p-2 px-3 shadow-sm"><i class="bi bi-headset text-warning me-1"></i> Support Technique Dédié</span>
                    </div>
                    <div class="small text-muted border-top pt-2">
                        Des interventions ciblées à la mission, sans structure lourde à mettre en place.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Ce que SPESORA apporte à votre organisation (Les 4 Piliers Fondamentaux) (Page 1 PDF 1) -->
    <div class="mb-5 pt-3" id="services">
        <div class="text-center mb-5" style="max-width: 820px; margin: 0 auto;">
            <span class="pill-badge pill-plum mb-2">SPESORA GROUP · DOUALA</span>
            <h2 class="display-5 fw-bold text-dark">Ce que SPESORA apporte à votre organisation</h2>
            <p class="text-muted fs-5">
                Quatre piliers stratégiques pour accompagner votre modernisation et garantir l'autonomie de vos équipes.
            </p>
        </div>

        <div class="row g-4">
            <!-- Pilier 1 : Audit de performance -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 card-custom hover-lift p-4 d-flex flex-column justify-content-between text-white" 
                     style="background: linear-gradient(180deg, var(--spesora-plum) 0%, var(--spesora-plum-dark) 100%); border-top: 5px solid var(--spesora-green);">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge bg-white bg-opacity-50 rounded-pill px-3 py-1">Pilier 01</span>
                            <div class="fs-3 text-warning"><i class="bi bi-speedometer2"></i></div>
                        </div>
                        <h4 class="fw-bold mb-3 text-white">Audit de performance</h4>
                        <p class="text-white-50 small mb-4" style="line-height: 1.6;">
                            Un état des lieux de vos outils, de vos équipes et de votre gestion avant d'investir.
                        </p>
                        <div class="bg-black bg-opacity-20 p-3 rounded-3 mb-4 small text-white-50">
                            <div class="text-white fw-bold mb-1" style="font-size: 0.75rem;">Points clés évalués :</div>
                            <ul class="list-unstyled mb-0 ps-0">
                                <li class="mb-1"><i class="bi bi-check2 text-warning me-1"></i> Cartographie de l'existant</li>
                                <li class="mb-1"><i class="bi bi-check2 text-warning me-1"></i> Mesure des compétences réelles</li>
                                <li class="mb-1"><i class="bi bi-check2 text-warning me-1"></i> Quick Wins & priorités</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('diagnostic.create', ['target' => 'productivity_automation']) }}" 
                           class="btn btn-warning w-100 rounded-pill fw-bold text-dark py-2 shadow-sm">
                            <i class="bi bi-play-circle me-1"></i> Lancer l'Audit Flash &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pilier 2 : Intégration de logiciels -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 card-custom hover-lift p-4 d-flex flex-column justify-content-between border-top border-4 border-success">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">Pilier 02</span>
                            <div class="fs-3 text-success"><i class="bi bi-grid-1x2"></i></div>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark">Intégration de logiciels</h4>
                        <p class="text-muted small mb-4" style="line-height: 1.6;">
                            Des solutions choisies et déployées selon vos besoins réels.
                        </p>
                        <div class="bg-light p-3 rounded-3 mb-4 small text-secondary">
                            <div class="text-dark fw-bold mb-1" style="font-size: 0.75rem;">Notre cycle d'intégration :</div>
                            <ul class="list-unstyled mb-0 ps-0">
                                <li class="mb-1"><i class="bi bi-arrow-right-short text-success"></i> Analyse & Choix orienté</li>
                                <li class="mb-1"><i class="bi bi-arrow-right-short text-success"></i> Configuration Personnalisée</li>
                                <li class="mb-1"><i class="bi bi-arrow-right-short text-success"></i> Migration des données</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('diagnostic.create', ['target' => 'client_management']) }}" 
                           class="btn btn-outline-success w-100 rounded-pill fw-bold py-2">
                            Évaluer mon intégration &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pilier 3 : Formation -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 card-custom hover-lift p-4 d-flex flex-column justify-content-between border-top border-4" style="border-top-color: var(--spesora-plum) !important;">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="pill-badge pill-plum">Pilier 03</span>
                            <div class="fs-3 text-spesora-plum"><i class="bi bi-mortarboard"></i></div>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark">Formation</h4>
                        <p class="text-muted small mb-4" style="line-height: 1.6;">
                            Des utilisateurs autonomes, qui exploitent pleinement leurs outils.
                        </p>
                        <div class="bg-light p-3 rounded-3 mb-4 small text-secondary">
                            <div class="text-dark fw-bold mb-1" style="font-size: 0.75rem;">Programmes terrain :</div>
                            <ul class="list-unstyled mb-0 ps-0">
                                <li class="mb-1"><i class="bi bi-arrow-right-short text-spesora-plum"></i> Formations logicielles métiers</li>
                                <li class="mb-1"><i class="bi bi-arrow-right-short text-spesora-plum"></i> Outils collaboratifs modernes</li>
                                <li class="mb-1"><i class="bi bi-arrow-right-short text-spesora-plum"></i> Supports sur-mesure & suivi</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('diagnostic.create', ['target' => 'process_digitization']) }}" 
                           class="btn btn-spesora-outline w-100 py-2">
                            Devenez autonomes &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pilier 4 : Support technique -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 card-custom hover-lift p-4 d-flex flex-column justify-content-between border-top border-4 border-success">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">Pilier 04</span>
                            <div class="fs-3 text-success"><i class="bi bi-headset"></i></div>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark">Support technique</h4>
                        <p class="text-muted small mb-4" style="line-height: 1.6;">
                            Un accompagnement durable après la mise en service.
                        </p>
                        <div class="bg-light p-3 rounded-3 mb-4 small text-secondary">
                            <div class="text-dark fw-bold mb-1" style="font-size: 0.75rem;">Garantie de continuité :</div>
                            <ul class="list-unstyled mb-0 ps-0">
                                <li class="mb-1"><i class="bi bi-arrow-right-short text-success"></i> Diagnostic & résolution incidents</li>
                                <li class="mb-1"><i class="bi bi-arrow-right-short text-success"></i> Assistance utilisateurs réactive</li>
                                <li class="mb-1"><i class="bi bi-arrow-right-short text-success"></i> Interventions sur site ou distance</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('diagnostic.create', ['target' => 'cybersecurity']) }}" 
                           class="btn btn-outline-success w-100 rounded-pill fw-bold py-2">
                            Tester le niveau support &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Notre Méthode en Cinq Étapes (Slide 6 & Page 1 PDF 1) -->
    <div class="card card-custom p-4 p-md-5 mb-5 bg-white shadow-sm" id="methode">
        <div class="text-center mb-5" style="max-width: 760px; margin: 0 auto;">
            <span class="text-uppercase fw-bold text-success small" style="letter-spacing: 0.08em;">PROCESSUS D'ACCOMPAGNEMENT</span>
            <h2 class="display-6 fw-bold text-dark mt-1">Notre méthode en cinq étapes</h2>
            <p class="text-muted">Un cadre structuré, agile et transparent pour mener votre transition numérique avec succès.</p>
        </div>

        <div class="row g-3 text-center">
            @foreach($methodology as $m)
            <div class="col-lg col-md-4 col-sm-6">
                <div class="card p-3 h-100 border rounded-4 hover-lift d-flex flex-column justify-content-between" style="background-color: var(--spesora-cream);">
                    <div>
                        <div class="display-6 fw-bold text-spesora-plum mb-2" style="font-family: monospace;">{{ $m['step'] }}</div>
                        <h5 class="fw-bold text-dark mb-2">{{ $m['title'] }}</h5>
                        <p class="text-muted small mb-0">{{ $m['description'] }}</p>
                    </div>
                    <div class="mt-3 pt-2 border-top border-secondary border-opacity-10 text-success small fw-semibold">
                        Étape {{ $m['step'] }} / 05
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4 pt-2">
            <a href="{{ route('diagnostic.create') }}" class="btn btn-spesora rounded-pill px-4 py-2">
                <i class="bi bi-arrow-right-circle me-1"></i> Commencer par l'Étape 01 : Évaluer mon organisation
            </a>
        </div>
    </div>

    <!-- Section: Références : Une expérience concrète auprès d'entreprises (Page 2 PDF 1) -->
    <div class="p-4 p-md-5 mb-5 rounded-4 shadow-sm text-white" id="references" 
         style="background: linear-gradient(135deg, #4a1e30 0%, #351322 100%); border-left: 6px solid var(--spesora-green);">
        <div class="row align-items-center mb-4">
            <div class="col-lg-8">
                <span class="text-warning text-uppercase fw-bold small" style="letter-spacing: 0.08em;">RÉFÉRENCES</span>
                <h2 class="display-6 fw-bold text-white mt-1 mb-2">Une expérience concrète auprès d’entreprises</h2>
                <p class="lead text-white-50 mb-0">
                    Missions ponctuelles réalisées comme prestataire externe pour <strong>NUMIAS SARL</strong> et <strong>TITAN DYNAMICS LLC BROKERS</strong>.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <span class="pill-badge pill-green text-dark fw-bold">Prestations Vérifiées</span>
            </div>
        </div>

        <div class="row g-3 mb-4">
            @foreach($references['projects'] ?? [] as $proj)
            <div class="col-md-6">
                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-15 h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="fs-3 text-warning"><i class="bi {{ $proj['icon'] ?? 'bi-briefcase' }}"></i></div>
                        <div>
                            <h5 class="fw-bold text-white mb-1">{{ $proj['title'] }}</h5>
                            <span class="badge bg-warning text-dark">{{ $proj['clients'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="p-3 rounded-3 bg-black bg-opacity-30 border border-white border-opacity-15 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div class="text-light small">
                <i class="bi bi-star-fill text-warning me-2"></i>
                <strong>Pour vous :</strong> des interventions ciblées, à la mission, sans structure lourde à mettre en place.
            </div>
            <a href="mailto:{{ config('spesora.support_email') }}?subject=Demande d'intervention ciblée" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark text-nowrap">
                Demander une mission &rarr;
            </a>
        </div>
    </div>

    <!-- Section: Nos Valeurs Ajoutées (Slide 7) & Marchés Cibles (Slide 8) -->
    <div class="row g-4 mb-5">
        <!-- Valeurs Ajoutées -->
        <div class="col-lg-6">
            <div class="card card-custom p-4 h-100 bg-white">
                <span class="text-uppercase fw-bold text-spesora-plum small mb-2 d-block" style="letter-spacing: 0.08em;">ATOUTS</span>
                <h3 class="fw-bold mb-3 text-dark">Nos Valeurs Ajoutées</h3>
                <div class="vstack gap-3">
                    @foreach($values as $val)
                    <div class="d-flex align-items-start gap-3 p-2 rounded-3 border bg-light">
                        <div class="rounded-circle p-2 bg-spesora-green text-white fs-5 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi {{ $val['icon'] ?? 'bi-check' }}"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">{{ $val['title'] }}</strong>
                            <span class="text-muted small">{{ $val['description'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Marchés Cibles (Slide 8) -->
        <div class="col-lg-6">
            <div class="card card-custom p-4 h-100 bg-white">
                <span class="text-uppercase fw-bold text-success small mb-2 d-block" style="letter-spacing: 0.08em;">MARCHÉS CIBLES</span>
                <h3 class="fw-bold mb-3 text-dark">À Qui S'adressent Nos Services ?</h3>
                <div class="row g-3">
                    @foreach($markets as $mkt)
                    <div class="col-sm-6">
                        <div class="p-3 rounded-4 border h-100 hover-lift" style="background-color: var(--spesora-cream);">
                            <div class="fs-2 text-spesora-plum mb-2"><i class="bi {{ $mkt['icon'] ?? 'bi-briefcase' }}"></i></div>
                            <h6 class="fw-bold text-dark mb-1">{{ $mkt['title'] }}</h6>
                            <p class="text-muted small mb-0">{{ $mkt['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 p-3 rounded-3 bg-light border text-center">
                    <div class="small text-muted mb-2">Vous êtes dirigeant de PME, responsable d'institution ou professionnel indépendant ?</div>
                    <a href="{{ route('diagnostic.create') }}" class="btn btn-spesora btn-sm">
                        Lancer l'évaluation adaptée à votre profil &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Engagements & Ambitions (Slide 9) -->
    <div class="card card-custom p-4 p-md-5 mb-5 bg-white border-0 shadow-sm">
        <div class="text-center mb-4">
            <span class="text-uppercase fw-bold text-muted small" style="letter-spacing: 0.08em;">ENGAGEMENTS</span>
            <h2 class="display-6 fw-bold text-dark mt-1">Notre Engagement & Ambition</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-4 rounded-4 border-start border-4 border-plum h-100" style="background-color: #fbf5f8; border-color: var(--spesora-plum) !important;">
                    <span class="pill-badge pill-plum mb-2">Notre Mission</span>
                    <h4 class="fw-bold text-spesora-plum mb-2">Faciliter l'adoption technologique</h4>
                    <p class="text-muted mb-0">
                        Améliorer durablement les compétences des utilisateurs et garantir une exploitation fluide des logiciels.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 rounded-4 border-start border-4 border-success h-100" style="background-color: var(--spesora-green-light); border-color: var(--spesora-green) !important;">
                    <span class="pill-badge pill-green mb-2">Notre Vision</span>
                    <h4 class="fw-bold text-success mb-2">Acteur de référence régional</h4>
                    <p class="text-muted mb-0">
                        Devenir le partenaire incontournable au Cameroun et à l'international pour la transformation digitale efficace.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bannière CTA Finale : Lancement Diagnostic Flash -->
    <div class="p-4 p-md-5 rounded-4 text-white text-center shadow-lg position-relative overflow-hidden mb-4" 
         style="background: linear-gradient(135deg, var(--spesora-plum) 0%, var(--spesora-plum-dark) 100%); border-top: 4px solid var(--spesora-green);">
        <div class="position-relative z-1" style="max-width: 720px; margin: 0 auto;">
            <div class="pill-badge pill-green text-dark fw-bold mb-3">Diagnostic 100% Gratuit & Sans Engagement</div>
            <h2 class="display-6 fw-bold mb-3 text-white">Construisons ensemble votre transformation numérique</h2>
            <p class="lead opacity-90 mb-4" style="font-size: 1.1rem;">
                Réalisez en 3 minutes votre <strong>Audit de performance Flash</strong>. Vos réponses sont sauvegardées instantanément dans notre base MySQL sécurisée pour générer votre radar d'adéquation et plan d'action.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('diagnostic.create') }}" class="btn btn-warning btn-lg px-4 py-3 rounded-pill fw-bold text-dark shadow">
                    <i class="bi bi-play-circle-fill me-2"></i> Lancer mon Diagnostic Flash
                </a>
                <a href="mailto:{{ config('spesora.support_email') }}" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                    <i class="bi bi-envelope me-2"></i> Contacter SPESORA GROUP (Douala)
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
