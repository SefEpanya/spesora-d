@extends('layouts.app')

@section('title', 'Rapport de Diagnostic • ' . $organization->name)

@section('content')
<div class="container py-3" style="max-width: 1040px;">

    <!-- Action Bar -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 no-print">
        <a href="{{ route('diagnostic.create') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Nouveau diagnostic
        </a>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#emailModal">
                <i class="bi bi-envelope-check me-1"></i> Envoyer par email
            </button>
            <a href="{{ route('diagnostic.print', ['diagnostic' => $diagnostic->uuid]) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 shadow-sm" target="_blank">
                <i class="bi bi-file-earmark-pdf me-1"></i> Format A4 / PDF
            </a>
            <button onclick="window.print()" class="btn btn-dark btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-printer me-1"></i> Imprimer
            </button>
            <button type="button" class="btn btn-warning btn-sm rounded-pill px-3 shadow-sm fw-bold text-dark" data-bs-toggle="modal" data-bs-target="#consultingModal">
                <i class="bi bi-headset me-1"></i> Être rappelé par un consultant
            </button>
        </div>
    </div>

    <!-- Header Diagnostic Card -->
    <div class="card card-custom p-4 mb-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 border-bottom pb-3 mb-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">
                        {{ strtoupper($organization->sector) }}
                    </span>
                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">
                        {{ strtoupper($organization->size) }}
                    </span>
                    <span class="text-muted small">
                        Réf. #{{ substr($diagnostic->uuid, 0, 8) }} • {{ $diagnostic->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
                <h2 class="fw-bold mb-1">{{ $organization->name }}</h2>
                <p class="text-muted small mb-0">Rapport d'évaluation organisationnelle & Performance du Système d'Information</p>
            </div>

            <!-- Double Score Display -->
            <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-4 border">
                <div class="text-center pe-3 border-end">
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem;">Maturité SI</span>
                    <div class="fs-2 fw-black text-dark">{{ $diagnostic->global_score }}<small class="fs-6 text-muted">/100</small></div>
                </div>
                <div class="text-center ps-1">
                    <span class="text-primary text-uppercase fw-semibold" style="font-size: 0.7rem;">Adéquation Cible</span>
                    <div class="fs-2 fw-black text-primary">{{ $diagnostic->target_readiness_score }}<small class="fs-6 text-muted">/100</small></div>
                </div>
            </div>
        </div>

        <!-- Cibles visées -->
        <div class="mb-3">
            <div class="text-muted text-uppercase fw-bold mb-2" style="font-size: 0.7rem;">Objectifs Stratégiques Ciblés (Fiche de Poste) :</div>
            <div class="d-flex flex-wrap gap-2">
                @foreach($target_labels as $targetLabel)
                <span class="badge bg-light text-dark border p-2 px-3 rounded-pill fw-medium">
                    <i class="bi bi-crosshair text-primary me-1"></i> {{ $targetLabel }}
                </span>
                @endforeach
            </div>
        </div>

        <!-- Executive Summary Alert -->
        <div class="alert @if($diagnostic->target_readiness_score >= 80) alert-success @elseif($diagnostic->target_readiness_score >= 55) alert-warning @else alert-danger @endif rounded-3 mb-0" role="alert">
            <div class="d-flex align-items-start gap-2">
                <i class="bi @if($diagnostic->target_readiness_score >= 80) bi-check-circle-fill @elseif($diagnostic->target_readiness_score >= 55) bi-exclamation-triangle-fill @else bi-shield-slash-fill @endif fs-4"></i>
                <div>
                    <h6 class="fw-bold mb-1">Synthèse SPESORA GROUP</h6>
                    <p class="small mb-0">{{ $diagnostic->executive_summary }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Radar Chart & 4 Pillars Grid -->
    <div class="row g-4 mb-4">
        <!-- Radar Chart -->
        <div class="col-lg-5">
            <div class="card card-custom p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h5 class="fw-bold mb-0">Radar d'Adéquation</h5>
                        <span class="badge bg-light text-dark border">Gap Analysis</span>
                    </div>
                    <p class="text-muted small">Compare le niveau réel de votre organisation avec les exigences requises pour vos cibles.</p>
                </div>

                <div class="my-auto py-2">
                    <canvas id="spesoraRadarChart" style="max-height: 280px;"></canvas>
                </div>

                <div class="d-flex justify-content-around text-center border-top pt-3 small">
                    <div><span class="d-inline-block rounded-circle bg-primary me-1" style="width: 10px; height: 10px;"></span> Existant Réel</div>
                    <div><span class="d-inline-block rounded-circle bg-danger me-1" style="width: 10px; height: 10px;"></span> Requis pour la Cible</div>
                </div>
            </div>
        </div>

        <!-- 4 Pillars Cards -->
        <div class="col-lg-7">
            <div class="row g-3">
                @foreach($pillar_scores as $pCode => $p)
                <div class="col-md-6">
                    <div class="card card-custom p-3 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge {{ $p['badge_class'] ?? 'bg-secondary' }}">{{ $p['level'] ?? 'Modéré' }}</span>
                                <small class="text-muted fw-bold">PILIER</small>
                            </div>
                            <h6 class="fw-bold mb-2">{{ $p['name'] }}</h6>
                        </div>

                        <div>
                            <div class="d-flex align-items-baseline justify-content-between mb-1">
                                <span class="fs-4 fw-bold text-dark">{{ $p['score'] }}<small class="fs-7 text-muted">/100</small></span>
                                <span class="small text-muted">Requis : <strong>{{ $p['requirement'] }}/100</strong></span>
                            </div>
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar @if(!empty($p['is_compliant'])) bg-success @elseif(($p['score'] ?? 0) >= 50) bg-primary @else bg-danger @endif" 
                                     role="progressbar" style="width: {{ $p['score'] ?? 0 }}%;"></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between" style="font-size: 0.75rem;">
                                @if(($p['gap'] ?? 0) >= 0)
                                    <span class="text-success"><i class="bi bi-check2-circle me-1"></i> Objectif atteint (+{{ round($p['gap'] ?? 0, 1) }} pts)</span>
                                @else
                                    <span class="text-danger fw-semibold"><i class="bi bi-arrow-down-right me-1"></i> Écart de {{ round($p['gap'] ?? 0, 1) }} pts</span>
                                @endif
                                <span class="text-muted">Poids : {{ round(($p['weight'] ?? 0.25) * 100) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recommendations Section -->
    <div class="card card-custom p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 border-bottom pb-3">
            <div>
                <h4 class="fw-bold mb-0">Plan d'Action Recommandé</h4>
                <p class="text-muted small mb-0">Fiches actions priorisées pour combler les écarts d'adéquation constatés</p>
            </div>

            <!-- Filtres Quick Wins vs Structurant -->
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary active filter-btn" onclick="filterRecs('all', this)">
                    Toutes ({{ $all_recommendations->count() }})
                </button>
                <button type="button" class="btn btn-outline-success filter-btn" onclick="filterRecs('quick', this)">
                    ⚡ Quick Wins ({{ $quick_wins->count() }})
                </button>
                <button type="button" class="btn btn-outline-primary filter-btn" onclick="filterRecs('struct', this)">
                    🏛️ Chantiers Structurants ({{ $strategic_projects->count() }})
                </button>
            </div>
        </div>

        <!-- Liste des recommandations -->
        <div class="vstack gap-3" id="recsContainer">
            @forelse($all_recommendations as $rec)
            <div class="card p-3 border rounded-3 rec-card @if($rec->priority === 'Critique') border-danger-subtle bg-danger-subtle bg-opacity-10 @elseif($rec->priority === 'Élevée') border-warning-subtle bg-warning-subtle bg-opacity-10 @else bg-light-subtle @endif"
                 data-quick="{{ $rec->is_quick_win ? 'true' : 'false' }}">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary-subtle text-secondary border">Pilier {{ $rec->pillar_code }}</span>
                        @if($rec->priority === 'Critique')
                            <span class="badge bg-danger text-white"><i class="bi bi-exclamation-octagon-fill me-1"></i> Priorité Critique</span>
                        @elseif($rec->priority === 'Élevée')
                            <span class="badge bg-warning text-dark">Priorité Élevée</span>
                        @else
                            <span class="badge bg-info text-dark">Priorité Moyenne</span>
                        @endif

                        @if($rec->is_quick_win)
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                ⚡ {{ $rec->effort_level }}
                            </span>
                        @else
                            <span class="badge bg-light text-muted border">
                                ⏳ {{ $rec->effort_level }}
                            </span>
                        @endif
                    </div>
                </div>

                <h5 class="fw-bold text-dark mb-2">{{ $rec->title }}</h5>

                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <div class="p-2 rounded bg-white border small">
                            <span class="text-danger fw-bold d-block" style="font-size: 0.75rem;">🔍 CONSTAT / VULNÉRABILITÉ</span>
                            <span class="text-muted">{{ $rec->diagnostic_text }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 rounded bg-white border small">
                            <span class="text-success fw-bold d-block" style="font-size: 0.75rem;">💡 ACTION RECOMMANDÉE</span>
                            <span class="text-dark fw-medium">{{ $rec->action_plan }}</span>
                        </div>
                    </div>
                </div>

                @if($rec->impact_target_template)
                <div class="p-2 rounded bg-primary-subtle text-primary border border-primary-subtle small mb-2">
                    <i class="bi bi-bullseye me-1 fw-bold"></i>
                    <strong>Impact sur votre objectif :</strong> {{ $rec->impact_target_template }}
                </div>
                @endif

                @if(!empty($rec->suggested_tools))
                <div class="d-flex align-items-center gap-2 flex-wrap pt-2 border-top small">
                    <span class="text-muted">Solutions suggérées :</span>
                    @foreach($rec->suggested_tools as $tool)
                    <span class="badge bg-light text-dark border">{{ $tool }}</span>
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <div class="alert alert-info mb-0">Aucune recommandation critique identifiée. Votre niveau est optimal.</div>
            @endforelse
        </div>
    </div>

    <!-- Contact CTA -->
    <div class="card card-custom p-4 bg-dark text-white text-center no-print" style="background: linear-gradient(135deg, #0a192f 0%, #0d47a1 100%);">
        <h4 class="fw-bold mb-2">Passez à l'action avec l'accompagnement SPESORA GROUP</h4>
        <p class="text-light opacity-90 small mb-3 mx-auto" style="max-width: 600px;">
            Nos experts vous accompagnent dans la mise en œuvre concrète de ces recommandations, le choix des solutions et la conduite du changement auprès de vos collaborateurs.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <button type="button" class="btn btn-warning rounded-pill px-4 fw-bold text-dark shadow" data-bs-toggle="modal" data-bs-target="#consultingModal">
                <i class="bi bi-headset me-1"></i> Échanger avec un consultant SPESORA
            </button>
            <a href="mailto:{{ config('spesora.support_email') }}?subject=Suite Diagnostic Flash - {{ urlencode($organization->name) }}" class="btn btn-outline-light rounded-pill px-4">
                <i class="bi bi-envelope me-1"></i> Nous écrire un message
            </a>
        </div>
    </div>

</div>

<!-- Modal: Envoyer le rapport par email -->
<div class="modal fade no-print" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('diagnostic.send-email', ['diagnostic' => $diagnostic->uuid]) }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold" id="emailModalLabel">
                        <i class="bi bi-envelope-check text-primary me-2"></i> Envoyer ce rapport par email
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small">
                        Recevez le lien d'accès direct, la synthèse exécutive et le récapitulatif des scores de <strong>{{ $organization->name }}</strong>.
                    </p>
                    <div class="mb-3">
                        <label for="recipient_email" class="form-label fw-bold small">Adresse email destinataire :</label>
                        <input type="email" class="form-control rounded-3" id="recipient_email" name="email" 
                               value="{{ $organization->contact_email ?? '' }}" placeholder="exemple@entreprise.fr" required>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill btn-sm" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4 fw-bold">
                        <i class="bi bi-send me-1"></i> Envoyer maintenant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Demande d'accompagnement consultant -->
<div class="modal fade no-print" id="consultingModal" tabindex="-1" aria-labelledby="consultingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('diagnostic.request-consulting', ['diagnostic' => $diagnostic->uuid]) }}" method="POST">
                @csrf
                <div class="modal-header border-bottom bg-light">
                    <h5 class="modal-title fw-bold" id="consultingModalLabel">
                        <i class="bi bi-headset text-primary me-2"></i> Être rappelé par SPESORA GROUP
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        Un consultant senior SPESORA GROUP analysera vos résultats et vous contactera sous 24h pour échanger sur vos priorités.
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nom complet :</label>
                        <input type="text" class="form-control rounded-3" name="contact_name" 
                               value="{{ $organization->contact_name ?? '' }}" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Email :</label>
                            <input type="email" class="form-control rounded-3" name="contact_email" 
                                   value="{{ $organization->contact_email ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Téléphone :</label>
                            <input type="tel" class="form-control rounded-3" name="contact_phone" 
                                   value="{{ $organization->contact_phone ?? '' }}" placeholder="06 12 34 56 78">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Service ou axe d'accompagnement prioritaire :</label>
                        <select class="form-select rounded-3" name="service_interest">
                            <option value="Audit & Cybersécurité">Audit SI & Cybersécurité (Sauvegardes, RGPD)</option>
                            <option value="Conseil Stratégique & SDSI">Conseil Stratégique & Schéma Directeur SI</option>
                            <option value="ERP, CRM & Automatisation">ERP, CRM & Automatisation des processus</option>
                            <option value="Modernisation Matérielle & Réseau">Modernisation Matérielle & Réseau</option>
                            <option value="Formation & Conduite du Changement">Formation des équipes & Conduite du changement</option>
                            <option value="Accompagnement Global" selected>Accompagnement global sur les recommandations</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small">Précisions ou commentaire libre (facultatif) :</label>
                        <textarea class="form-control rounded-3" name="message" rows="3" placeholder="Indiquez vos contraintes de calendrier ou questions particulières..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill btn-sm" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning rounded-pill btn-sm px-4 fw-bold text-dark">
                        <i class="bi bi-check-circle me-1"></i> Transmettre ma demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function filterRecs(type, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const cards = document.querySelectorAll('.rec-card');
        cards.forEach(card => {
            const isQuick = card.getAttribute('data-quick') === 'true';
            if (type === 'all') card.style.display = 'block';
            else if (type === 'quick') card.style.display = isQuick ? 'block' : 'none';
            else if (type === 'struct') card.style.display = !isQuick ? 'block' : 'none';
        });
    }

    // Chart.js Radar Render
    const ctx = document.getElementById('spesoraRadarChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: {!! json_encode($radar['labels']) !!},
            datasets: [
                {
                    label: 'Votre Existant',
                    data: {!! json_encode($radar['current']) !!},
                    backgroundColor: 'rgba(13, 71, 161, 0.25)',
                    borderColor: 'rgb(13, 71, 161)',
                    pointBackgroundColor: 'rgb(13, 71, 161)',
                    borderWidth: 2
                },
                {
                    label: 'Requis pour vos Cibles',
                    data: {!! json_encode($radar['required']) !!},
                    backgroundColor: 'rgba(220, 53, 69, 0.15)',
                    borderColor: 'rgb(220, 53, 69)',
                    pointBackgroundColor: 'rgb(220, 53, 69)',
                    borderDash: [5, 5],
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    min: 0,
                    max: 100,
                    ticks: { display: false, stepSize: 20 },
                    pointLabels: { font: { size: 11, weight: 'bold' }, color: '#2d3748' }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection
