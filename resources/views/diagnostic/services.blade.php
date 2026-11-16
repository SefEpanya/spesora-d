@extends('layouts.app')

@section('title', 'Offres & Prestations • SPESORA GROUP · Douala')

@section('content')
<div class="container py-2" style="max-width: 1080px;">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3 no-print">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Offres & Prestations</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="text-center mb-5">
        <span class="pill-badge pill-green text-dark fw-bold mb-2">SPESORA GROUP · DOUALA</span>
        <h1 class="display-5 fw-bold mt-2 text-dark">Ce que SPESORA apporte à votre organisation</h1>
        <p class="text-muted fs-5" style="max-width: 780px; margin: 0 auto;">
            Solutions numériques · Formation professionnelle · Support technique. Une approche centrée sur les enjeux métiers et le succès de l'utilisateur.
        </p>
    </div>

    <!-- 4 Services Detailed -->
    <div class="row g-4 mb-5">
        @foreach($services as $sKey => $service)
        <div class="col-12">
            <div class="card card-custom p-4 border-start border-5 shadow-sm" style="border-left-color: {{ $service['badge_color'] ?? '#5c2d42' }} !important;">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="badge rounded-circle p-2 px-3 fs-5 text-white" style="background-color: {{ $service['badge_color'] ?? '#5c2d42' }};">
                                {{ $service['number'] ?? '01' }}
                            </span>
                            <div>
                                <h3 class="fw-bold mb-0 text-dark">{{ $service['title'] }}</h3>
                                <div class="text-success fw-medium small">{{ $service['tagline'] }}</div>
                            </div>
                        </div>

                        <p class="text-muted my-3">
                            {{ $service['description'] }}
                        </p>

                        <div class="row g-2 mb-3">
                            @foreach($service['deliverables'] ?? [] as $deliv)
                            <div class="col-md-6">
                                <div class="bg-light p-2 rounded-3 small text-dark d-flex align-items-start gap-2 border">
                                    <i class="bi bi-check-circle-fill text-success mt-1"></i>
                                    <span>{{ $deliv }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0 border-start ps-lg-4">
                        <div class="p-3 rounded-4 text-center" style="background-color: var(--spesora-cream);">
                            <div class="text-muted small mb-2 text-uppercase fw-semibold" style="font-size: 0.7rem;">Évaluation préalable recommandée</div>
                            <div class="small text-secondary mb-3">
                                Testez le niveau de maturité de vos outils et équipes avec notre outil de diagnostic Flash.
                            </div>
                            <a href="{{ route('diagnostic.create', ['target' => $service['target_key'] ?? '']) }}" 
                               class="btn btn-spesora w-100 d-flex align-items-center justify-content-center gap-2">
                                <span>{{ $service['cta_label'] ?? 'Lancer le Diagnostic' }}</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Méthodologie en 5 étapes rappel -->
    <div class="card card-custom p-4 p-md-5 mb-5 bg-white">
        <h4 class="fw-bold text-dark text-center mb-4">Notre Méthode d'Accompagnement en 5 Étapes</h4>
        <div class="row g-3 text-center">
            @foreach($methodology as $m)
            <div class="col">
                <div class="p-3 rounded-3 border bg-light h-100">
                    <div class="fw-bold text-spesora-plum fs-5">{{ $m['step'] }}</div>
                    <div class="fw-bold text-dark small mt-1">{{ $m['title'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Contact Box -->
    <div class="p-5 rounded-4 text-white text-center shadow-lg position-relative overflow-hidden mb-4" 
         style="background: linear-gradient(135deg, var(--spesora-plum) 0%, var(--spesora-plum-dark) 100%);">
        <div style="max-width: 680px; margin: 0 auto;">
            <h3 class="fw-bold mb-2 text-white">Besoin d'une intervention ciblée ou d'un conseil ?</h3>
            <p class="text-white-50 small mb-4">
                Pour vous : des interventions ciblées, à la mission, sans structure lourde à mettre en place. Nos équipes basées à Douala interviennent localement et à l'international.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="mailto:{{ config('spesora.support_email') }}" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark">
                    <i class="bi bi-envelope-fill me-1"></i> Contacter un consultant SPESORA
                </a>
                <a href="{{ route('diagnostic.create') }}" class="btn btn-outline-light rounded-pill px-4 py-2">
                    <i class="bi bi-speedometer2 me-1"></i> Lancer l'Audit de performance Flash
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
