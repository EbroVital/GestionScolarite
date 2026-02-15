
@extends('layouts.template')

@section('title', 'Détails de la classe')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('classe.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h2 mb-0">{{ $classe->nom }}</h1>
                    <p class="text-muted mb-0">{{ $classe->niveau }} - {{ $classe->anneeScolaire->libelle }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('classe.edit', $classe) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Modifier
                </a>
                <a href="{{ route('eleves.create', ['classe_id' => $classe->id]) }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i>Ajouter un élève
                </a>
            </div>
        </div>

        <div class="row g-4">
            {{-- Colonne principale --}}
            <div class="col-lg-8">
                {{-- Liste des élèves --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-users me-2 text-primary"></i>
                            Liste des élèves ({{ $classe->eleves->count() }})
                        </h5>
                        <a href="{{ route('eleves.index', ['classe_id' => $classe->id]) }}" class="btn btn-sm btn-outline-primary">
                            Voir tout
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if($classe->eleves->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Matricule</th>
                                            <th>Nom complet</th>
                                            <th>Sexe</th>
                                            <th>Solde</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($classe->eleves as $eleve)
                                            @php
                                                $solde = calculer_solde_eleve($eleve->id);
                                            @endphp
                                            <tr>
                                                <td class="fw-bold">{{ $eleve->matricule }}</td>
                                                <td>
                                                    <div class="fw-semibold">{{ $eleve->nom_complet }}</div>
                                                    <small class="text-muted">{{ $eleve->date_naissance->format('d/m/Y') }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $eleve->sexe == 'M' ? 'bg-primary' : 'bg-danger' }}">
                                                        {{ $eleve->sexe == 'M' ? 'M' : 'F' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold {{ $solde > 0 ? 'text-danger' : 'text-success' }}">
                                                        {{ formater_montant($solde) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('eleves.show', $eleve) }}"
                                                        class="btn btn-info"
                                                        title="Voir">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('paiements.create', ['eleve_id' => $eleve->id, 'classe_id' => $classe->id]) }}"
                                                        class="btn btn-success"
                                                        title="Paiement">
                                                            <i class="fas fa-money-bill"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-3">Aucun élève dans cette classe</p>
                                <a href="{{ route('eleves.create', ['classe_id' => $classe->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-1"></i>Ajouter le premier élève
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Informations générales --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informations
                        </h6>
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
                            <strong class="text-success fs-5">{{ formater_montant($classe->fraisScolaire->montant ?? 0) }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Nombre d'élèves</small>
                            <strong>{{ $classe->eleves->count() }}</strong>
                        </div>

                        <div>
                            <small class="text-muted d-block">Date de création</small>
                            <strong>{{ $classe->created_at->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Statistiques financières --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Statistiques
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $fraisTotal = ($classe->fraisScolaire->montant ?? 0) * $classe->eleves->count();
                            $totalEncaisse = $classe->eleves->sum(function($eleve) {
                                return $eleve->paiements->sum('montant');
                            });
                            $soldeTotal = $fraisTotal - $totalEncaisse;
                            $pourcentage = $fraisTotal > 0 ? ($totalEncaisse / $fraisTotal) * 100 : 0;
                        @endphp

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block">Frais attendus</small>
                            <strong class="text-info">{{ formater_montant($fraisTotal) }}</strong>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block">Total encaissé</small>
                            <strong class="text-success">{{ formater_montant($totalEncaisse) }}</strong>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block">Solde restant</small>
                            <strong class="text-danger">{{ formater_montant($soldeTotal) }}</strong>
                        </div>

                        {{-- Barre de progression --}}
                        <div>
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Taux de recouvrement</span>
                                <strong>{{ number_format($pourcentage, 1) }}%</strong>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success"
                                    style="width: {{ min($pourcentage, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Répartition par sexe --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-venus-mars me-2"></i>Répartition
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $garcons = $classe->eleves->where('sexe', 'M')->count();
                            $filles = $classe->eleves->where('sexe', 'F')->count();
                            $total = $classe->eleves->count();
                        @endphp

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span><i class="fas fa-mars text-primary me-1"></i> Garçons</span>
                                <strong>{{ $garcons }}</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary"
                                    style="width: {{ $total > 0 ? ($garcons / $total) * 100 : 0 }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span><i class="fas fa-venus text-danger me-1"></i> Filles</span>
                                <strong>{{ $filles }}</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-danger"
                                    style="width: {{ $total > 0 ? ($filles / $total) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
