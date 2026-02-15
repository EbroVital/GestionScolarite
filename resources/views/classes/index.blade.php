{{-- resources/views/classes/index.blade.php --}}
@extends('layouts.template')

@section('title', 'Liste des classes')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Liste des classes</h1>
            <a href="{{ route('classe.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nouvelle classe
            </a>
        </div>

        {{-- Messages --}}
        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Statistiques rapides --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Total classes</h6>
                                <h3 class="mb-0">{{ $classes->count() }}</h3>
                            </div>
                            <i class="fas fa-school fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Total élèves</h6>
                                <h3 class="mb-0">{{ $classes->sum('eleves_count') }}</h3>
                            </div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Moyenne par classe</h6>
                                <h3 class="mb-0">{{ $classes->count() > 0 ? round($classes->sum('eleves_count') / $classes->count()) : 0 }}</h3>
                            </div>
                            <i class="fas fa-chart-bar fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grille des classes --}}
        <div class="row g-4">
            @forelse($classes as $classe)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 hover-shadow">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    {{ $classe->nom }}
                                </h5>
                                <span class="badge bg-light text-primary">
                                    {{ $classe->eleves_count }} élève(s)
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted d-block">Niveau</small>
                                <strong>{{ $classe->niveau }}</strong>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Année scolaire</small>
                                <strong>{{ $classe->anneeScolaire->libelle }}</strong>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Frais de scolarité</small>
                                <strong class="text-success">{{ formater_montant($classe->fraisScolaire->montant ?? 0) }}</strong>
                            </div>

                            {{-- Barre de progression (capacité) --}}
                            @php
                                $capacite = 40; // Capacité maximale par classe (à ajuster)
                                $pourcentage = ($classe->eleves_count / $capacite) * 100;
                            @endphp
                            <div class="mb-2">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Capacité</span>
                                    <strong>{{ $classe->eleves_count }}/{{ $capacite }}</strong>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar {{ $pourcentage > 90 ? 'bg-danger' : ($pourcentage > 75 ? 'bg-warning' : 'bg-success') }}"
                                        style="width: {{ min($pourcentage, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('classe.show', $classe) }}"
                                class="btn btn-sm btn-info"
                                title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('classe.edit', $classe) }}"
                                class="btn btn-sm btn-warning"
                                title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete({{ $classe->id }})"
                                        class="btn btn-sm btn-danger"
                                        title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune classe enregistrée</h5>
                            <p class="text-muted mb-4">Commencez par créer votre première classe</p>
                            <a href="{{ route('classe.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Créer une classe
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal de confirmation de suppression --}}
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- @push('scripts')
        <script>
        function confirmDelete(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette classe ?\nCette action est irréversible si la classe n\'a pas d\'élèves.')) {
                const form = document.getElementById('delete-form');
                form.action = `/classe/${id}`;
                form.submit();
            }
        }
        </script>
    @endpush --}}

    @push('styles')
        <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        </style>
    @endpush
@endsection
