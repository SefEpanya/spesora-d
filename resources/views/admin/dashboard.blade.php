@extends('layouts.app')

@section('title', 'Administration & Suivi des Diagnostics • SPESORA GROUP')

@section('content')
<div class="container py-3">

    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Tableau de Bord Consultant SPESORA</h3>
            <p class="text-muted small mb-0">Module 10 : Suivi statistique des diagnostics Flash, pipeline de leads et livrables</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-eye me-1"></i> Prévisualiser les Templates Emails
                </button>
                <ul class="dropdown-menu shadow-sm">
                    <li><a class="dropdown-item small" href="{{ route('admin.mail-preview', ['type' => 'client']) }}" target="_blank"><i class="bi bi-person me-2 text-primary"></i> Email Rapport Client</a></li>
                    <li><a class="dropdown-item small" href="{{ route('admin.mail-preview', ['type' => 'admin']) }}" target="_blank"><i class="bi bi-bell me-2 text-danger"></i> Email Alerte Consultant SPESORA</a></li>
                    <li><a class="dropdown-item small" href="{{ route('admin.mail-preview', ['type' => 'consulting']) }}" target="_blank"><i class="bi bi-headset me-2 text-success"></i> Email Demande d'Accompagnement</a></li>
                </ul>
            </div>
            <a href="{{ route('diagnostic.create') }}" class="btn btn-primary rounded-pill btn-sm fw-bold">
                <i class="bi bi-plus-circle me-1"></i> Nouveau diagnostic
            </a>
        </div>
    </div>

    <!-- KPIs Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-custom p-3 border-start border-4 border-primary">
                <div class="text-muted small fw-semibold">TOTAL DIAGNOSTICS</div>
                <div class="fs-2 fw-bold text-dark mt-1">{{ $totalDiagnostics }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom p-3 border-start border-4 border-info">
                <div class="text-muted small fw-semibold">ORGANISATIONS AUDITÉES</div>
                <div class="fs-2 fw-bold text-dark mt-1">{{ $totalOrganizations }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom p-3 border-start border-4 border-success">
                <div class="text-muted small fw-semibold">MATURITÉ MOYENNE</div>
                <div class="fs-2 fw-bold text-success mt-1">{{ $averageMaturity }}<small class="fs-6 text-muted">/100</small></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom p-3 border-start border-4 border-warning">
                <div class="text-muted small fw-semibold">ADÉQUATION CIBLE MOYENNE</div>
                <div class="fs-2 fw-bold text-warning mt-1">{{ $averageReadiness }}<small class="fs-6 text-muted">/100</small></div>
            </div>
        </div>
    </div>

    <!-- Filtres & Recherche -->
    <div class="card card-custom p-3 mb-4 bg-light-subtle">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Rechercher par organisation, email ou secteur..." value="{{ $search ?? '' }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="completed" @if(($status ?? '') === 'completed') selected @endif>Complété</option>
                    <option value="reviewed" @if(($status ?? '') === 'reviewed') selected @endif>Revu par consultant</option>
                    <option value="archived" @if(($status ?? '') === 'archived') selected @endif>Archivé</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary w-100 rounded-pill">Filtrer</button>
                @if(!empty($search) || !empty($status))
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill" title="Réinitialiser"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>
        </form>
    </div>

    <!-- Diagnostics List Table -->
    <div class="card card-custom p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0">Historique des Diagnostics Réalisés</h5>
            <span class="text-muted small">{{ $recentDiagnostics->total() }} résultat(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>Date</th>
                        <th>Organisation</th>
                        <th>Secteur / Taille</th>
                        <th>Maturité SI</th>
                        <th>Adéquation Cible</th>
                        <th>Statut</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($recentDiagnostics as $diag)
                    <tr>
                        <td>
                            <div>{{ $diag->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $diag->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <strong class="text-dark">{{ $diag->organization->name }}</strong>
                            @if($diag->organization->contact_email)
                            <div class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-envelope me-1"></i>{{ $diag->organization->contact_email }}
                            </div>
                            @endif
                            @if($diag->organization->contact_phone)
                            <div class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-telephone me-1"></i>{{ $diag->organization->contact_phone }}
                            </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $diag->organization->sector }}</span>
                            <span class="badge bg-light text-muted border">{{ strtoupper($diag->organization->size) }}</span>
                        </td>
                        <td>
                            <span class="fw-bold fs-6">{{ $diag->global_score }}</span><small class="text-muted">/100</small>
                        </td>
                        <td>
                            <span class="badge @if($diag->target_readiness_score >= 80) bg-success @elseif($diag->target_readiness_score >= 55) bg-warning text-dark @else bg-danger @endif">
                                {{ $diag->target_readiness_score }}/100
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                {{ ucfirst($diag->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('diagnostic.report', ['diagnostic' => $diag->uuid]) }}" class="btn btn-outline-primary" title="Voir le rapport">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('diagnostic.print', ['diagnostic' => $diag->uuid]) }}" class="btn btn-outline-dark" target="_blank" title="Format Impression / PDF">
                                    <i class="bi bi-printer"></i>
                                </a>
                                <form action="{{ route('admin.diagnostic.destroy', ['diagnostic' => $diag->uuid]) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de ce diagnostic ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Aucun diagnostic enregistré correspondant aux critères.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentDiagnostics->hasPages())
        <div class="mt-3 pt-3 border-top">
            {{ $recentDiagnostics->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
