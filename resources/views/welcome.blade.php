<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestion Scolaire - Accueil</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <style>
            .hero-section {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 100px 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
            }
            .feature-card {
                transition: transform 0.3s;
                height: 100%;
            }
            .feature-card:hover {
                transform: translateY(-5px);
            }
            .btn-custom {
                padding: 12px 30px;
                font-size: 18px;
                border-radius: 50px;
            }
        </style>
    </head>

    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark" style="background: rgba(0,0,0,0.2); position: absolute; width: 100%; z-index: 1000;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-mortarboard-fill"></i> Gestion Scolaire
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    {{-- route('dashboard') --}}
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    {{-- route('login') --}}
                                    <i class="bi bi-box-arrow-in-right"></i> Se connecter
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    {{-- route('register') --}}
                                    <i class="bi bi-person-plus"></i> S'inscrire
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold mb-4">Système de Gestion des Frais Scolaires</h1>
                        <p class="lead mb-4">Une solution complète pour gérer les paiements, les élèves et suivre les frais de scolarité en temps réel.</p>
                        <div class="d-flex gap-3">
                            @auth
                                <a href="" class="btn btn-light btn-custom">
                                    {{-- route('dashboard') --}}
                                    <i class="bi bi-speedometer2"></i> Accéder au Dashboard
                                </a>
                            @else
                                <a href="" class="btn btn-light btn-custom">
                                    {{-- route('login') --}}
                                    <i class="bi bi-box-arrow-in-right"></i> Se connecter
                                </a>
                                <a href="" class="btn btn-outline-light btn-custom"> {{-- route('register') --}}
                                    <i class="bi bi-person-plus"></i> S'inscrire
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <i class="bi bi-mortarboard-fill" style="font-size: 200px; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold">Fonctionnalités Principales</h2>
                    <p class="text-muted">Tout ce dont vous avez besoin pour gérer votre établissement</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card feature-card border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="bi bi-cash-coin text-success" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="card-title">Gestion des Paiements</h5>
                                <p class="card-text text-muted">Enregistrez et suivez tous les paiements avec génération automatique de reçus.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card feature-card border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="bi bi-people text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="card-title">Gestion des Élèves</h5>
                                <p class="card-text text-muted">Base de données complète avec informations détaillées et historique.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card feature-card border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="bi bi-graph-up text-info" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="card-title">Statistiques en Temps Réel</h5>
                                <p class="card-text text-muted">Tableaux de bord avec statistiques et rapports détaillés.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card feature-card border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="bi bi-printer text-warning" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="card-title">Impression de Reçus</h5>
                                <p class="card-text text-muted">Génération automatique de reçus PDF professionnels.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card feature-card border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="bi bi-shield-check text-danger" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="card-title">Gestion des Rôles</h5>
                                <p class="card-text text-muted">Contrôle d'accès pour administrateurs, caissiers et parents.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card feature-card border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="bi bi-bell text-secondary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="card-title">Suivi des Impayés</h5>
                                <p class="card-text text-muted">Identification rapide des élèves en retard de paiement.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white py-4">
            <div class="container text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Système de Gestion Scolaire. Tous droits réservés.</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>


</html>

