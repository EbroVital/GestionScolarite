
@extends('layouts.template')

@section('title', 'Frais scolaires')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Frais scolaires</h1>
            <a href="{{ route('frais-scolaire.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nouveau frais scolaire
            </a>
        </div>

        {{-- Messages --}}
        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Description --}}
        <div class="alert alert-info d-flex align-items-start mb-4">
            <i class="fas fa-info-circle me-2 mt-1"></i>
            <div>
                <strong>À propos :</strong> Les frais scolaires définissent le montant de la scolarité par niveau. Un même niveau peut être attribué à plusieurs classes.
            </div>
        </div>

        {{-- Statistiques rapides --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Total niveaux</h6>
                                <h3 class="mb-0">{{ $frais->count() }}</h3>
                            </div>
                            <i class="fas fa-layer-group fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Classes concernées</h6>
                                <h3 class="mb-0">{{ $frais->sum('classes_count') }}</h3>
                            </div>
                            <i class="fas fa-school fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Montant moyen</h6>
                                <h3 class="mb-0 small">{{ $frais->count() > 0 ? formater_montant($frais->avg('montant')) : '0 FCFA' }}</h3>
                            </div>
                            <i class="fas fa-chart-line fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grille des frais --}}
        <div class="row g-4">
            @forelse($frais->sortBy('montant') as $fraisScolaire)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 hover-card">
                        <div class="card-header bg-gradient-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    {{ $fraisScolaire->niveau }}
                                </h5>
                                <span class="badge bg-light text-primary">
                                    {{ $fraisScolaire->classes_count }} classe(s)
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- Montant principal --}}
                            <div class="text-center mb-4">
                                <small class="text-muted d-block mb-1">Frais de scolarité</small>
                                <h2 class="text-success mb-0">{{ formater_montant($fraisScolaire->montant) }}</h2>
                            </div>

                            {{-- Détails --}}
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted">Classes</small>
                                    <strong>{{ $fraisScolaire->classes_count }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted">Créé le</small>
                                    <strong>{{ $fraisScolaire->created_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('frais-scolaire.show', $fraisScolaire) }}"
                                class="btn btn-sm btn-info"
                                title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('frais-scolaire.edit', $fraisScolaire) }}"
                                class="btn btn-sm btn-warning"
                                title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete({{ $fraisScolaire->id }}, '{{ $fraisScolaire->niveau }}')"
                                        class="btn btn-sm btn-danger"
                                        title="Supprimer"
                                        {{ $fraisScolaire->classes_count > 0 ? 'disabled' : '' }}>
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
                            <h5 class="text-muted">Aucun frais scolaire enregistré</h5>
                            <p class="text-muted mb-4">Commencez par définir les frais pour chaque niveau</p>
                            <a href="{{ route('frais-scolaire.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Créer le premier frais scolaire
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

    @push('scripts')
        <script>
        function confirmDelete(id, niveau) {
            if (confirm(`Êtes-vous sûr de vouloir supprimer les frais du niveau "${niveau}" ?\nCette action est irréversible.`)) {
                const form = document.getElementById('delete-form');
                form.action = `/frais-scolaire/${id}`;
                form.submit();
            }
        }
        </script>
    @endpush

    @push('styles')
        <style>
        .hover-card {
            transition: all 0.3s ease;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }
        </style>
    @endpush
@endsection
