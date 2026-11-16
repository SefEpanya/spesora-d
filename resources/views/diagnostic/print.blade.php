<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport d'Évaluation • {{ $organization->name }} • SPESORA GROUP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @page {
            size: A4;
            margin: 12mm 15mm 15mm 15mm;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: #ffffff;
            color: #1e293b;
            font-size: 13px;
            line-height: 1.45;
        }

        .print-header {
            border-bottom: 2px solid #0d47a1;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .score-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 15px;
        }

        .rec-item {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 12px;
            margin-bottom: 8px;
            page-break-inside: avoid;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="p-4">

    <!-- Print Control Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4 no-print bg-light p-3 rounded-3 border">
        <div>
            <a href="{{ route('diagnostic.report', ['diagnostic' => $diagnostic->uuid]) }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Retour au rapport interactif
            </a>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">
                <i class="bi bi-printer me-1"></i> Lancer l'impression / Enregistrer en PDF
            </button>
        </div>
    </div>

    <!-- Document Header -->
    <div class="print-header d-flex justify-content-between align-items-end">
        <div>
            <div class="fw-bold text-primary fs-5 text-uppercase" style="letter-spacing: 0.05em;">SPESORA GROUP</div>
            <h2 class="fw-bold mb-0 text-dark">Rapport SPESORA Diagnostic Flash</h2>
            <div class="text-muted small">Diagnostic organisationnel & Évaluation des capacités du Système d'Information</div>
        </div>
        <div class="text-end small">
            <div><strong>Réf :</strong> #{{ substr($diagnostic->uuid, 0, 8) }}</div>
            <div><strong>Date :</strong> {{ $diagnostic->created_at->format('d/m/Y') }}</div>
        </div>
    </div>

    <!-- Organisation Details & Scores -->
    <div class="row g-3 mb-3">
        <div class="col-7">
            <div class="card p-3 h-100 border bg-light">
                <h5 class="fw-bold mb-1">{{ $organization->name }}</h5>
                <div class="small text-muted mb-2">
                    Secteur : <strong>{{ ucfirst($organization->sector) }}</strong> • Taille : <strong>{{ strtoupper($organization->size) }}</strong>
                </div>
                @if($organization->contact_email)
                <div class="small text-muted">
                    Contact : {{ $organization->contact_name ?? 'Référent SI' }} ({{ $organization->contact_email }})
                </div>
                @endif
                <div class="mt-2 pt-2 border-top small">
                    <span class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Cibles stratégiques visées :</span>
                    <ul class="mb-0 ps-3 mt-1">
                        @foreach($target_labels as $tl)
                        <li>{{ $tl }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="row g-2 h-100">
                <div class="col-6">
                    <div class="score-box text-center h-100 d-flex flex-column justify-content-center">
                        <div class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Maturité SI</div>
                        <div class="display-6 fw-bold text-dark my-1">{{ $diagnostic->global_score }}<small class="fs-6 text-muted">/100</small></div>
                        <div class="small text-muted">Niveau global</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="score-box text-center h-100 d-flex flex-column justify-content-center border-primary bg-primary-subtle">
                        <div class="text-primary text-uppercase fw-bold" style="font-size: 0.7rem;">Adéquation Cible</div>
                        <div class="display-6 fw-bold text-primary my-1">{{ $diagnostic->target_readiness_score }}<small class="fs-6 text-muted">/100</small></div>
                        <div class="small text-primary fw-semibold">Target Readiness</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Synthèse Exécutive -->
    <div class="p-3 mb-3 rounded-3 border @if($diagnostic->target_readiness_score >= 80) bg-success-subtle border-success @elseif($diagnostic->target_readiness_score >= 55) bg-warning-subtle border-warning @else bg-danger-subtle border-danger @endif">
        <div class="fw-bold text-uppercase small mb-1">Synthèse Exécutive des Consultants SPESORA GROUP :</div>
        <p class="mb-0">{{ $diagnostic->executive_summary }}</p>
    </div>

    <!-- Radar Chart & Pillars Table -->
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-5 text-center">
            <canvas id="printRadarChart" style="max-height: 240px; max-width: 100%;"></canvas>
            <div class="small text-muted mt-1" style="font-size: 0.7rem;">
                <span class="text-primary fw-bold">■ Existant</span> vs <span class="text-danger fw-bold">-- Cible Recommandée</span>
            </div>
        </div>
        <div class="col-7">
            <table class="table table-sm table-bordered align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>Pilier d'Évaluation</th>
                        <th class="text-center">Score</th>
                        <th class="text-center">Requis</th>
                        <th class="text-center">Écart (Gap)</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @foreach($pillar_scores as $pCode => $p)
                    <tr>
                        <td class="fw-semibold">{{ $p['name'] }}</td>
                        <td class="text-center fw-bold">{{ $p['score'] }}/100</td>
                        <td class="text-center text-muted">{{ $p['requirement'] }}/100</td>
                        <td class="text-center">
                            @php $gap = $p['score'] - $p['requirement']; @endphp
                            @if($gap >= 0)
                                <span class="badge bg-success">+{{ round($gap, 1) }} (Atteint)</span>
                            @else
                                <span class="badge bg-danger">{{ round($gap, 1) }} (Déficit)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Plan d'Action & Recommandations Prioritaires -->
    <div class="mb-3">
        <h6 class="fw-bold text-uppercase text-dark border-bottom pb-1 mb-2">Recommandations & Actions Prioritaires (SPESORA GROUP)</h6>
        
        @if($quick_wins->count() > 0)
        <div class="mb-2">
            <div class="fw-bold text-success small mb-1"><i class="bi bi-lightning-charge-fill me-1"></i> Quick Wins (Gains Rapides) :</div>
            @foreach($quick_wins as $rec)
            <div class="rec-item bg-light border-start border-4 border-success">
                <div class="d-flex justify-content-between align-items-start">
                    <strong class="text-dark">{{ $rec->title }}</strong>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Priorité {{ $rec->priority }}</span>
                </div>
                <div class="small text-muted mt-1">{{ $rec->action_plan }}</div>
            </div>
            @endforeach
        </div>
        @endif

        @if($strategic_projects->count() > 0)
        <div class="mb-2">
            <div class="fw-bold text-primary small mb-1"><i class="bi bi-gear-wide me-1"></i> Chantiers Structurants (Moyen Terme) :</div>
            @foreach($strategic_projects->take(4) as $rec)
            <div class="rec-item bg-light border-start border-4 border-primary">
                <div class="d-flex justify-content-between align-items-start">
                    <strong class="text-dark">{{ $rec->title }}</strong>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Priorité {{ $rec->priority }}</span>
                </div>
                <div class="small text-muted mt-1">{{ $rec->action_plan }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Footer Note -->
    <div class="mt-4 pt-2 border-top text-center text-muted small" style="font-size: 0.75rem;">
        SPESORA GROUP • Audit, Conseil & Intégration de Systèmes d'Information • Contact : {{ config('spesora.support_email') }} • Document confidentiel
    </div>

    <script>
        const ctx = document.getElementById('printRadarChart').getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: {!! json_encode($radar['labels']) !!},
                datasets: [
                    {
                        label: 'Existant',
                        data: {!! json_encode($radar['current']) !!},
                        backgroundColor: 'rgba(13, 71, 161, 0.2)',
                        borderColor: '#0d47a1',
                        borderWidth: 2
                    },
                    {
                        label: 'Requis',
                        data: {!! json_encode($radar['required']) !!},
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        borderColor: '#dc3545',
                        borderDash: [4, 4],
                        borderWidth: 2
                    }
                ]
            },
            options: {
                animation: false,
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        min: 0,
                        max: 100,
                        ticks: { display: false, stepSize: 25 },
                        pointLabels: { font: { size: 10, weight: 'bold' } }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>
