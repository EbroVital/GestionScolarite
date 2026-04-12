@extends('layouts.template')

@section('title', 'Dashboard')
@section('h1', 'Tableau de bord')

@section('content')

    <div class="row mb-3">

        {{-- Année scolaire --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Année scolaire</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $anneeScolaire }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Paiements du jour --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Paiements du jour</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formater_montant($todayEncaisse) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total encaissé --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total encaissé</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formater_montant($totalEncaisse) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total attendu --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total attendu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formater_montant($totalAttendu) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Nombre total d'élèves --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total élèves inscrits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEleves }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2">
                                    <i class="fas fa-arrow-up"></i> {{ $nouveauxCeMois }} ce mois-ci
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Taux de recouvrement --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Taux de recouvrement</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tauxRecouvrement }} %</div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{ $tauxRecouvrement }}%"></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Montant restant à collecter --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Reste à collecter</div>
                            <div class="h5 mb-0 font-weight-bold text-danger">{{ formater_montant($totalRestant) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-danger opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Nouveaux inscrits ce mois --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Nouveaux inscrits ce mois</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $nouveauxCeMois }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau stats par classe --}}
        <div class="col-xl-8 mb-4">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Statistiques par classe</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Classe</th>
                                    <th class="text-center">À jour</th>
                                    <th class="text-center">En retard</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statsParClasse as $stat)
                                <tr>
                                    <td class="text-center">{{ $stat['classe'] }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success text-white">{{ $stat['aJour'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($stat['enRetard'] > 0)
                                            <span class="badge bg-danger text-white">{{ $stat['enRetard'] }}</span>
                                        @else
                                            <span>0</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $stat['total'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Élèves en retard depuis +30 jours --}}
        <div class="col-xl-8 mb-4">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Élèves en retard depuis +30 jours
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Élève</th>
                                    <th>Classe</th>
                                    <th class="text-right">Solde dû</th>
                                    <th>Dernier paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($elevesEnRetard as $eleve)
                                <tr>
                                    <td>{{ $eleve['nom'] }}</td>
                                    <td>{{ $eleve['classe'] }}</td>
                                    <td class="text-right text-danger font-weight-bold">
                                        {{ formater_montant($eleve['solde']) }}
                                    </td>
                                    <td>{{ $eleve['dernierPaiement'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-success py-3">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Aucun élève en retard depuis plus de 30 jours
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
