@extends('layouts.template')

@section('title', "Détails de l'élève")

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <h1 class="h2 mb-0">Fiche élève</h1>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('eleves.edit', $elefe) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Modifier
                </a>
                {{-- <button onclick="window.print()" class="btn btn-secondary">
                    <i class="fas fa-print me-1"></i> Imprimer
                </button> --}}
            </div>
        </div>

        <div class="row g-4">
            {{-- Colonne gauche : Informations principales --}}
            <div class="col-lg-8">
                {{-- Carte principale --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 80px; height: 80px;">
                                <span class="fs-2 fw-bold text-white">
                                    {{ substr($elefe->nom, 0, 1) }}{{ substr($elefe->prenom, 0, 1) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="mb-1">{{ $elefe->nom_complet }}</h3>
                                <p class="mb-0 text-muted">Matricule : <strong>{{ $elefe->matricule }}</strong></p>
                                <p class="mb-0 text-muted">Classe : <strong>{{ $elefe->classe->nom }}</strong></p>
                            </div>
                        </div>

                        {{-- Informations détaillées --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-calendar-alt text-muted me-3 mt-1"></i> &nbsp;
                                    <div>
                                        <small class="text-muted d-block">Date de naissance</small>
                                        <strong>{{ $elefe->date_naissance->format('d/m/Y') }}</strong>
                                        <small class="text-muted d-block">{{ $elefe->date_naissance->age }} ans</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-venus-mars text-muted me-3 mt-1"></i> &nbsp;
                                    <div>
                                        <small class="text-muted d-block">Sexe</small>
                                        <strong>{{ $elefe->sexe == 'M' ? 'Masculin' : 'Féminin' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-phone text-muted me-3 mt-1"></i> &nbsp;
                                    <div>
                                        <small class="text-muted d-block">Téléphone parent</small>
                                        <strong>{{ $elefe->telephone_parent }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-map-marker-alt text-muted me-3 mt-1"></i> &nbsp;
                                    <div>
                                        <small class="text-muted d-block">Adresse</small>
                                        <strong>{{ $elefe->adresse }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Historique des paiements --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                            Historique des paiements
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($elefe->paiements->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Montant</th>
                                            <th>Type</th>
                                            <th>Reçu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($elefe->paiements as $paiement)
                                            <tr>
                                                <td>{{ $paiement->date_paiement }}</td>
                                                <td class="fw-bold text-success">
                                                    {{ formater_montant($paiement->montant) }}
                                                </td>
                                                <td>{{ $paiement->typePaiement->libelle }}</td>
                                                <td>
                                                    @if($paiement->recu)
                                                        <a href="{{ route('recus.show', $paiement->recu) }}"
                                                        class="text-decoration-none">
                                                            {{ $paiement->recu->numero_recu }}
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Aucun paiement enregistré</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Colonne droite : Résumé financier --}}
            <div class="col-lg-4">
                {{-- Carte résumé financier --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Situation financière</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $fraisScolaire = $elefe->classe->fraisScolaire->montant ?? 0;
                            $totalPaye = $elefe->paiements->sum('montant');
                            $solde = $fraisScolaire - $totalPaye;
                            $pourcentage = $fraisScolaire > 0 ? ($totalPaye / $fraisScolaire) * 100 : 0;
                        @endphp

                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Frais de scolarité</span>
                                <strong>{{ formater_montant($fraisScolaire) }}</strong>
                            </div>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Total payé</span>
                                <strong class="text-success">{{ formater_montant($totalPaye) }}</strong>
                            </div>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted fw-bold">Solde restant</span>
                                <strong class="fs-5 {{ $solde > 0 ? 'text-danger' : 'text-success' }}">
                                    {{ formater_montant($solde) }}
                                </strong>
                            </div>
                        </div>

                        {{-- Barre de progression --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Progression</span>
                                <strong>{{ number_format($pourcentage, 0) }}%</strong>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success"
                                    role="progressbar"
                                    style="width: {{ min($pourcentage, 100) }}%"
                                    aria-valuenow="{{ $pourcentage }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>

                        {{-- Bouton paiement --}}
                        <a href="{{ route('paiements.create', ['eleve_id' => $elefe->id, 'classe_id' => $elefe->classe_id]) }}"
                        class="btn btn-primary w-100 mt-3">
                            <i class="fas fa-plus-circle me-1"></i> Enregistrer un paiement
                        </a>
                    </div>
                </div>

                {{-- Informations complémentaires --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Informations</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Année scolaire</small>
                            <strong>{{ $elefe->classe->anneeScolaire->libelle }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Date d'inscription</small>
                            <strong>{{ $elefe->created_at->format('d/m/Y') }}</strong>
                        </div>
                        <div>
                            <small class="text-muted d-block">Dernière modification</small>
                            <strong>{{ $elefe->updated_at->format('d/m/Y à H:i') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
