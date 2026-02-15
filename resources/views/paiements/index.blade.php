@extends('layouts.template')

@section('title', 'Liste des paiements')

@section('content')

    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Liste des paiements</h1>
            <a href="{{ route('paiements.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nouveau paiement
            </a>
        </div>

        {{-- Messages --}}
        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Carte statistiques --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Total encaissé</h6>
                                <h3 class="mb-0">{{ $total }}</h3>
                            </div>
                            <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Nombre de paiements</h6>
                                <h3 class="mb-0">{{ $paiements->count() }}</h3>
                            </div>
                            <i class="fas fa-receipt fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Aujourd'hui</h6>
                                <h3 class="mb-0">{{ $paiements->where('date_paiement', '>=', today())->sum('montant') }}</h3>
                            </div>
                            <i class="fas fa-calendar-day fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau des paiements --}}
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    Historique des paiements
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Élève</th>
                                <th>Classe</th>
                                <th>Montant</th>
                                <th>Type</th>
                                <th>Reçu</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paiements as $paiement)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $paiement->date_paiement->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $paiement->date_paiement->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $paiement->eleve->nom_complet }}</div>
                                        <small class="text-muted">{{ $paiement->eleve->matricule }}</small>
                                    </td>
                                    <td>{{ $paiement->eleve->classe->niveau }}</td>
                                    <td class="fw-bold text-success">{{ formater_montant($paiement->montant) }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $paiement->typePaiement->libelle }}</span>
                                    </td>
                                    <td>
                                        @if($paiement->recu)
                                            <a href="{{ route('recus.show', $paiement->recu) }}"
                                            class="text-decoration-none">
                                                <i class="fas fa-file-invoice me-1"></i>
                                                {{ $paiement->recu->numero_recu }}
                                            </a>
                                        @endif
                                    </td>
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
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted mb-0">Aucun paiement enregistré</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
