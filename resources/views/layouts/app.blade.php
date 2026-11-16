<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPESORA GROUP • Transformation numérique & renforcement des capacités')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --spesora-plum: #582a3d;
            --spesora-plum-dark: #3f1929;
            --spesora-plum-light: #733951;
            --spesora-green: #2e7d32;
            --spesora-green-light: #e8f5e9;
            --spesora-cream: #faf7f2;
            --spesora-card-bg: #ffffff;
            --spesora-border: #ede7de;
            --spesora-text: #201b1e;
        }

        body {
            background-color: var(--spesora-cream);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--spesora-text);
            line-height: 1.6;
        }

        .navbar-spesora {
            background-color: #ffffff;
            border-bottom: 1px solid var(--spesora-border);
            box-shadow: 0 2px 8px rgba(88, 42, 61, 0.04);
        }

        .text-spesora-plum { color: var(--spesora-plum) !important; }
        .text-spesora-green { color: var(--spesora-green) !important; }

        .bg-spesora-plum { background-color: var(--spesora-plum) !important; color: #ffffff !important; }
        .bg-spesora-green { background-color: var(--spesora-green) !important; color: #ffffff !important; }
        .bg-spesora-cream { background-color: var(--spesora-cream) !important; }

        .btn-spesora {
            background-color: var(--spesora-plum);
            border-color: var(--spesora-plum);
            color: #ffffff !important;
            font-weight: 600;
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(88, 42, 61, 0.2);
            transition: all 0.2s ease;
        }
        .btn-spesora:hover {
            background-color: var(--spesora-plum-dark);
            border-color: var(--spesora-plum-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(88, 42, 61, 0.3);
        }

        .btn-spesora-green {
            background-color: var(--spesora-green);
            border-color: var(--spesora-green);
            color: #ffffff !important;
            font-weight: 600;
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
            transition: all 0.2s ease;
        }
        .btn-spesora-green:hover {
            background-color: #236327;
            border-color: #236327;
            transform: translateY(-2px);
        }

        .btn-spesora-outline {
            border: 2px solid var(--spesora-plum);
            color: var(--spesora-plum) !important;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.2s ease;
        }
        .btn-spesora-outline:hover {
            background-color: var(--spesora-plum);
            color: #ffffff !important;
        }

        .card-custom {
            border: 1px solid var(--spesora-border);
            border-radius: 1.25rem;
            background-color: var(--spesora-card-bg);
            box-shadow: 0 4px 14px rgba(88, 42, 61, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(88, 42, 61, 0.08);
        }

        .pill-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.9rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .pill-plum {
            background-color: #f5edf1;
            color: var(--spesora-plum);
            border: 1px solid #ebd8e2;
        }

        .pill-green {
            background-color: var(--spesora-green-light);
            color: var(--spesora-green);
            border: 1px solid #c8e6c9;
        }

        @media print {
            .no-print { display: none !important; }
            body { background-color: #ffffff !important; }
            .card-custom { box-shadow: none !important; border: 1px solid #cbd5e1 !important; }
        }
    </style>
    @yield('styles')
</head>
<body class="d-flex flex-column h-100">

    <!-- Top Sub-Bar (Anchor & Location) -->
    <div class="bg-dark text-white py-1 px-3 small no-print" style="background-color: var(--spesora-plum-dark) !important; font-size: 0.8rem;">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-geo-alt-fill text-warning me-1"></i> SPESORA GROUP · <strong>Douala, Cameroun</strong></span>
                <span class="d-none d-md-inline text-white-50">|</span>
                <span class="d-none d-md-inline text-white-50">Solutions numériques · Formation professionnelle · Support technique</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="d-none d-sm-inline"><i class="bi bi-envelope me-1 text-warning"></i> contact@spesora.group</span>
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none opacity-75 hover-opacity-100">
                    <i class="bi bi-shield-lock me-1"></i> Espace Consultant
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="navbar navbar-expand-lg navbar-spesora sticky-top no-print">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <div class="rounded-3 p-2 d-inline-flex align-items-center justify-content-center text-white" 
                     style="background: linear-gradient(135deg, var(--spesora-plum) 0%, var(--spesora-plum-dark) 100%);">
                    <i class="bi bi-layers-fill fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5 tracking-tight text-spesora-plum" style="letter-spacing: -0.02em;">
                        SPESORA <span class="fw-light text-muted">GROUP</span>
                    </div>
                    <div class="text-muted" style="font-size: 0.68rem; letter-spacing: 0.08em; text-transform: uppercase;">
                        Transformation Numérique
                    </div>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold text-spesora-plum' : '' }}" href="{{ route('home') }}">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#services">
                            Nos 4 Piliers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#methode">
                            Méthode en 5 étapes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#references">
                            Références
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services') ? 'active fw-bold text-spesora-plum' : '' }}" href="{{ route('services') }}">
                            Offres & Prestations
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('diagnostic.create') }}" class="btn btn-spesora btn-sm">
                        <i class="bi bi-speedometer2 me-1"></i> Lancer le Diagnostic Flash
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-shrink-0 my-3">
        <div class="container mb-3 no-print">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm d-flex align-items-center" role="alert" style="background-color: #e8f5e9; border-color: #c8e6c9; color: #1b5e20;">
                    <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-x-circle me-1"></i> Veuillez corriger les erreurs ci-dessous :</div>
                    <ul class="mb-0 small ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- Footer Officiel SPESORA GROUP -->
    <footer class="footer mt-auto text-white pt-5 pb-4 no-print" style="background-color: var(--spesora-plum-dark) !important; border-top: 3px solid var(--spesora-green);">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="rounded-3 p-2 bg-white text-spesora-plum d-inline-flex">
                            <i class="bi bi-layers-fill fs-5"></i>
                        </div>
                        <div>
                            <span class="fw-bold fs-5 text-white">SPESORA GROUP</span>
                            <div class="small text-warning">Douala · Cameroun</div>
                        </div>
                    </div>
                    <p class="text-white-50 small mb-3">
                        Société de services numériques dédiée à la maîtrise et l'exploitation durable des logiciels professionnels. Nous accompagnons entreprises, institutions et professionnels à travers une approche centrée sur les enjeux métiers et le succès de l'utilisateur.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="pill-badge pill-plum text-white border-0" style="background-color: rgba(255,255,255,0.12);">Accompagnement Métier</span>
                        <span class="pill-badge pill-green text-white border-0" style="background-color: var(--spesora-green);">Expertise Logicielle</span>
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <h6 class="text-uppercase fw-bold text-warning mb-3" style="font-size: 0.8rem; letter-spacing: 0.05em;">Ce que nous apportons</h6>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-2"><a href="{{ route('home') }}#services" class="text-white-50 text-decoration-none hover-white">Audit de performance</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#services" class="text-white-50 text-decoration-none hover-white">Intégration logiciels</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#services" class="text-white-50 text-decoration-none hover-white">Formation professionnelle</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#services" class="text-white-50 text-decoration-none hover-white">Support technique</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-6">
                    <h6 class="text-uppercase fw-bold text-warning mb-3" style="font-size: 0.8rem; letter-spacing: 0.05em;">Références Clients</h6>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-2"><strong>NUMIAS SARL</strong> (Interfaces web & tests)</li>
                        <li class="mb-2"><strong>TITAN DYNAMICS LLC BROKERS</strong> (Campagnes & Conseil)</li>
                        <li class="mb-2 text-white-50 pt-1" style="font-size: 0.75rem;">
                            <em>Interventions ciblées à la mission, sans structure lourde.</em>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h6 class="text-uppercase fw-bold text-warning mb-3" style="font-size: 0.8rem; letter-spacing: 0.05em;">Diagnostic Flash</h6>
                    <p class="text-white-50 small mb-3">
                        Évaluez vos outils, vos équipes et votre gestion avant d'investir. Données persistées en base sécurisée MySQL (spedeck).
                    </p>
                    <a href="{{ route('diagnostic.create') }}" class="btn btn-spesora-green btn-sm w-100 rounded-pill">
                        <i class="bi bi-play-circle me-1"></i> Faire le diagnostic (3 min)
                    </a>
                </div>
            </div>

            <div class="border-top border-white border-opacity-10 pt-3 text-center text-white-50 small">
                <span>&copy; {{ date('Y') }} <strong>SPESORA GROUP · Douala</strong>. Tous droits réservés. Base de données SPEDECK MySQL connectée.</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
