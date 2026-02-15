
@extends('layouts.template')

@section('title', 'Détails du type de paiement')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <div>
                    <h1 class="h2 mb-0">{{ $type->libelle }}</h1>
                    <p class="text-muted mb-0">Type de paiement</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('type-paiement.edit', $type) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Modifier
                </a>
                @if($type->paiements->count() === 0)
                    <button onclick="confirmDelete({{ $type->id }}, '{{ $type->libelle }}')" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                @endif
            </div>
        </div>

        <div class="row g-4">
            {{-- Colonne principale --}}
            <div class="col-lg-8">
                {{-- Historique des paiements --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2 text-primary"></i>
                            Historique des paiements ({{ $type->paiements->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($type->paiements->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Élève</th>
                                            <th>Classe</th>
                                            <th>Montant</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($type->paiements->sortByDesc('date_paiement')->take(20) as $paiement)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{ $paiement->date_paiement->format('d/m/Y') }}</div>
                                                    <small class="text-muted">{{ $paiement->date_paiement->format('H:i') }}</small>
                                                </td>
                                                <td>
                                                    <div>{{ $paiement->eleve->nom_complet }}</div>
                                                    <small class="text-muted">{{ $paiement->eleve->matricule }}</small>
                                                </td>
                                                <td>{{ $paiement->eleve->classe->nom }}</td>
                                                <td class="fw-bold text-success">{{ formater_montant($paiement->montant) }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('eleves.show', $paiement->eleve) }}"
                                                        class="btn btn-info"
                                                        title="Voir l'élève">
                                                            <i class="fas fa-user"></i>
                                                        </a>
                                                        @if($paiement->recu)
                                                            <a href="{{ route('recus.show', $paiement->recu) }}"
                                                            class="btn btn-primary"
                                                            title="Voir le reçu">
                                                                <i class="fas fa-receipt"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($type->paiements->count() > 20)
                                <div class="card-footer bg-white text-center">
                                    <small class="text-muted">
                                        Affichage des 20 derniers paiements sur {{ $type->paiements->count() }}
                                    </small>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Aucun paiement avec ce type</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Informations --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informations
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Libellé</small>
                            <strong class="fs-5">{{ $type->libelle }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Nombre de paiements</small>
                            <strong>{{ $type->paiements->count() }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Date de création</small>
                            <strong>{{ $type->created_at->format('d/m/Y') }}</strong>
                        </div>

                        <div>
                            <small class="text-muted d-block">Dernière modification</small>
                            <strong>{{ $type->updated_at->format('d/m/Y à H:i') }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Statistiques --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Statistiques
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $totalMontant = $type->paiements->sum('montant');
                            $dernierPaiement = $type->paiements->sortByDesc('date_paiement')->first();
                            $moyenneMontant = $type->paiements->count() > 0 ? $totalMontant / $type->paiements->count() : 0;
                        @endphp

                        <div class="mb-3">
                            <small class="text-muted d-block">Montant total</small>
                            <strong class="text-success fs-5">{{ formater_montant($totalMontant) }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Montant moyen</small>
                            <strong>{{ formater_montant($moyenneMontant) }}</strong>
                        </div>

                        <div>
                            <small class="text-muted d-block">Dernier paiement</small>
                            @if($dernierPaiement)
                                <strong>{{ $dernierPaiement->date_paiement->format('d/m/Y') }}</strong>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Alerte si utilisé --}}
                @if($type->paiements->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Note :</strong> Ce type est utilisé dans {{ $type->paiements->count() }} paiement(s) et ne peut pas être supprimé.
                    </div>
                @endif
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
