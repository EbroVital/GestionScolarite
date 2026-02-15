{{-- resources/views/type-paiement/index.blade.php --}}
@extends('layouts.template')

@section('title', 'Types de paiement')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Types de paiement</h1>
            <a href="{{ route('type-paiement.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nouveau type
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
                <strong>À propos :</strong> Les types de paiement permettent de catégoriser les modes de règlement utilisés (espèces, mobile money, virement, etc.)
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                {{-- Tableau des types --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i> Liste des types ({{ $typePaiements->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Libellé</th>
                                        <th class="text-center" style="width: 150px;">Utilisations</th>
                                        <th class="text-center" style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($typePaiements as $index => $type)
                                        <tr>
                                            <td class="text-muted">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="fas fa-credit-card text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $type->libelle }}</div>
                                                        <small class="text-muted">Créé le {{ $type->created_at->format('d/m/Y') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info rounded-pill">
                                                    {{ $type->paiements_count }} paiement(s)
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('type-paiement.show', $type) }}"
                                                    class="btn btn-info"
                                                    title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('type-paiement.edit', $type) }}"
                                                    class="btn btn-warning"
                                                    title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button onclick="confirmDelete({{ $type->id }}, '{{ $type->libelle }}')"
                                                            class="btn btn-danger"
                                                            title="Supprimer"
                                                            {{ $type->paiements_count > 0 ? 'disabled' : '' }}>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                                <p class="text-muted mb-3"> Aucun type de paiement enregistré</p>
                                                <a href="{{ route('type-paiement.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-1"></i> Créer le premier type
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Statistiques --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-pie me-2"></i> Statistiques
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Total types</small>
                            <h3 class="mb-0">{{ $typePaiements->count() }}</h3>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Total paiements</small>
                            <h3 class="mb-0">{{ $typePaiements->sum('paiements_count') }}</h3>
                        </div>
                        <div>
                            <small class="text-muted d-block">Type le plus utilisé</small>
                            @php
                                $plusUtilise = $typePaiements->sortByDesc('paiements_count')->first();
                            @endphp
                            @if($plusUtilise)
                                <strong>{{ $plusUtilise->libelle }}</strong>
                                <span class="badge bg-success ms-2">{{ $plusUtilise->paiements_count }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Types suggérés --}}
                <div class="card shadow-sm border-info">
                    <div class="card-header bg-info bg-opacity-10">
                        <h6 class="mb-0 text-white">
                            <i class="fas fa-lightbulb me-2"></i> Types suggérés
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Espèces</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Mobile Money</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Virement bancaire</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Chèque</li>
                            <li class="mb-0"><i class="fas fa-check text-success me-2"></i>Carte bancaire</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de confirmation de suppression --}}
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
        <script>
        function confirmDelete(id, libelle) {
            if (confirm(`Êtes-vous sûr de vouloir supprimer le type "${libelle}" ?\nCette action est irréversible.`)) {
                const form = document.getElementById('delete-form');
                form.action = `/type-paiement/${id}`;
                form.submit();
            }
        }
        </script>
    @endpush
@endsection
