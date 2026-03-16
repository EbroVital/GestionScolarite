
@extends('layouts.template')

@section('title', 'Reçu de paiement')

@section('content')
    <div class="container py-4">
        {{-- Boutons d'action (non imprimables) --}}
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> &nbsp; Retour
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('recus.download', $recu->id) }}" class="btn btn-success">
                    <i class="fas fa-download me-2"></i> &nbsp; Télécharger PDF
                </a>
            </div>
        </div>

        {{-- Reçu --}}
        <div class="card shadow-lg border-0" id="recu">
            <div class="card-body p-5">
                {{-- En-tête --}}
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h2 class="text-primary mb-1">ÉCOLE xx </h2>
                            <p class="text-muted mb-0">
                                Adresse de l'école<br>
                                Téléphone : +225 XX XX XX XX XX<br>
                                Email : contact@ecole.com
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="badge bg-success fs-5 px-4 py-2 mb-3 text-white">
                            <i class="fas fa-check-circle me-2"></i> &nbsp; PAYÉ
                        </div>
                        <div>
                            <h4 class="text-uppercase mb-1">Reçu N°</h4>
                            <h3 class="text-primary fw-bold">{{ $recu->numero_recu }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Séparateur --}}
                <hr class="border-primary border-2 mb-5">

                {{-- Informations du paiement --}}
                <div class="row mb-5">
                    <div class="col-md-6">
                        <h5 class="text-uppercase text-muted mb-3">Informations de l'élève</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted ps-0" style="width: 55%;">Nom complet :</td>
                                <td class="fw-bold">{{ $recu->paiement->eleve->nom_complet }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Matricule :</td>
                                <td class="fw-bold">{{ $recu->paiement->eleve->matricule }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Classe :</td>
                                <td class="fw-bold">{{ $recu->paiement->eleve->classe->nom }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Année scolaire :</td>
                                <td class="fw-bold">{{ $recu->paiement->eleve->classe->anneeScolaire->libelle }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-uppercase text-muted mb-3">Détails du paiement</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted ps-0" style="width: 50%;">Date :</td>
                                <td class="fw-bold">{{ $recu->date_emission }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Mode de paiement :</td>
                                <td class="fw-bold">{{ $recu->paiement->typePaiement->libelle }}</td>
                            </tr>
                            @if($recu->paiement->reference_transaction)
                                <tr>
                                    <td class="text-muted ps-0">Référence :</td>
                                    <td class="fw-bold">{{ $recu->paiement->reference_transaction }}</td>
                                </tr>
                            @endif
                            @if($recu->paiement->observation)
                                <tr>
                                    <td class="text-muted ps-0">Observation :</td>
                                    <td class="fw-bold">{{ $recu->paiement->observation }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- Montant principal --}}
                <div class="bg-light rounded p-4 mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-0">Montant payé</h5>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h2 class="text-success fw-bold mb-0">{{ formater_montant($recu->montant) }}</h2>
                        </div>
                    </div>
                </div>

                {{-- Situation financière --}}
                @php
                    $fraisTotal = $recu->paiement->eleve->classe->fraisScolaire->montant;
                    $totalPaye = $recu->paiement->eleve->paiements->sum('montant');
                    $soldeRestant = $fraisTotal - $totalPaye;
                @endphp

                <div class="card border-primary mb-5">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i> &nbsp; Situation financière de l'élève
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <small class="text-muted d-block mb-1">Frais de scolarité</small>
                                <h5 class="mb-0">{{ formater_montant($fraisTotal) }}</h5>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <small class="text-muted d-block mb-1">Total payé</small>
                                <h5 class="text-success mb-0">{{ formater_montant($totalPaye) }}</h5>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block mb-1">Solde restant</small>
                                <h5 class="{{ $soldeRestant > 0 ? 'text-danger' : 'text-success' }} mb-0">
                                    {{ formater_montant($soldeRestant) }}
                                </h5>
                            </div>
                        </div>

                        {{-- Barre de progression --}}
                        <div class="mt-3">
                            @php
                                $pourcentage = $fraisTotal > 0 ? ($totalPaye / $fraisTotal) * 100 : 0;
                            @endphp
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success"
                                    style="width: {{ min($pourcentage, 100) }}%"></div>
                            </div>
                            <small class="text-muted">{{ number_format($pourcentage) }}% payé</small>
                        </div>
                    </div>
                </div>

                {{-- Note et signature --}}
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note :</strong> Ce reçu fait foi de paiement. Veuillez le conserver précieusement.
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="text-muted mb-1">Signature et cachet</p>
                        <div class="border-top border-2 border-dark pt-4 mt-5">
                            <small class="text-muted">Le caissier</small>
                        </div>
                    </div>
                </div>

                {{-- Pied de page --}}
                <div class="text-center text-muted small border-top pt-3">
                    <p class="mb-1">Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
                    <p class="mb-0">Merci pour votre confiance</p>
                </div>
            </div>
        </div>

        {{-- Historique des paiements (non imprimable) --}}
        <div class="card shadow-sm mt-4 no-print">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2 text-primary"></i>
                    Historique des paiements de l'élève
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Montant</th>
                                <th>Mode</th>
                                <th>Reçu</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recu->paiement->eleve->paiements->sortByDesc('date_paiement') as $paiement)
                                <tr class="{{ $paiement->id === $recu->paiement_id ? 'table-success' : '' }}">
                                    <td>{{ $paiement->date_paiement }}</td>
                                    <td class="fw-bold text-success">{{ formater_montant($paiement->montant) }}</td>
                                    <td>{{ $paiement->typePaiement->libelle }}</td>
                                    <td>
                                        @if($paiement->recu)
                                            {{ $paiement->recu->numero_recu }}
                                            @if($paiement->id === $recu->paiement_id)
                                                <span class="badge bg-success ms-2">Actuel</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($paiement->recu && $paiement->id !== $recu->paiement_id)
                                            <a href="{{ route('recus.show', $paiement->recu) }}"
                                            class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




@endsection
