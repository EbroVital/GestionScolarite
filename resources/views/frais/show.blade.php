
@extends('layouts.template')

@section('title', 'Détails des frais scolaires')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('frais-scolaire.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h2 mb-0">Frais - {{ $frais->niveau }}</h1>
                    <p class="text-muted mb-0">{{ formater_montant($frais->montant) }}</p>
                </div>
            </div>
            {{-- <div class="d-flex gap-2">
                <a href="{{ route('frais-scolaire.edit', $frais) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Modifier
                </a>
                @if($frais->classes->count() === 0)
                    <button onclick="confirmDelete({{ $frais->id }}, '{{ $frais->niveau }}')" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                @endif
            </div> --}}
        </div>

        <div class="row g-4">
            {{-- Colonne principale --}}
            <div class="col-lg-8">
                {{-- Classes concernées --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-school me-2 text-primary"></i>
                            Classes concernées ({{ $frais->classes->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($frais->classes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Classe</th>
                                            <th>Année scolaire</th>
                                            <th class="text-center">Élèves</th>
                                            <th class="text-end">Revenu attendu</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($frais->classes as $classe)
                                            @php
                                                $revenuAttendu = $frais->montant * $classe->eleves->count();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{ $classe->nom }}</div>
                                                </td>
                                                <td>{{ $classe->anneeScolaire->libelle }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-info rounded-pill">
                                                        {{ $classe->eleves->count() }} élève(s)
                                                    </span>
                                                </td>
                                                <td class="text-end fw-bold text-success">
                                                    {{ formater_montant($revenuAttendu) }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('classe.show', $classe) }}"
                                                    class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th class="text-center">
                                                {{ $frais->classes->sum(function($c) { return $c->eleves->count(); }) }} élèves
                                            </th>
                                            <th class="text-end text-success">
                                                @php
                                                    $totalRevenu = $frais->classes->sum(function($c) use ($frais) {
                                                        return $frais->montant * $c->eleves->count();
                                                    });
                                                @endphp
                                                {{ formater_montant($totalRevenu) }}
                                            </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-school-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-3">Aucune classe n'utilise ces frais</p>
                                <a href="{{ route('classe.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Créer une classe
                                </a>
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
                            <small class="text-muted d-block">Niveau</small>
                            <strong class="fs-5">{{ $frais->niveau }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Montant annuel</small>
                            <strong class="text-success fs-4">{{ formater_montant($frais->montant) }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Classes concernées</small>
                            <strong>{{ $frais->classes->count() }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Total élèves</small>
                            <strong>{{ $frais->classes->sum(function($c) { return $c->eleves->count(); }) }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Date de création</small>
                            <strong>{{ $frais->created_at->format('d/m/Y') }}</strong>
                        </div>

                        <div>
                            <small class="text-muted d-block">Dernière modification</small>
                            <strong>{{ $frais->updated_at->format('d/m/Y à H:i') }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Statistiques financières --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-pie me-2"></i>Statistiques
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $totalEleves = $frais->classes->sum(function($c) { return $c->eleves->count(); });
                            $revenuAttendu = $frais->montant * $totalEleves;
                            $revenuParClasse = $frais->classes->count() > 0 ? $revenuAttendu / $frais->classes->count() : 0;
                        @endphp

                        <div class="mb-3">
                            <small class="text-muted d-block">Revenu attendu total</small>
                            <strong class="text-success fs-5">{{ formater_montant($revenuAttendu) }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Revenu moyen par classe</small>
                            <strong>{{ formater_montant($revenuParClasse) }}</strong>
                        </div>

                        <div>
                            <small class="text-muted d-block">Élèves par classe (moyenne)</small>
                            <strong>{{ $frais->classes->count() > 0 ? round($totalEleves / $frais->classes->count(), 1) : 0 }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Alerte si utilisé --}}
                @if($frais->classes->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Note :</strong> Ces frais sont utilisés par {{ $frais->classes->count() }} classe(s) et ne peuvent pas être supprimés.
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Ces frais ne sont pas encore utilisés. Vous pouvez les modifier ou les supprimer.
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


        <script>
        function confirmDelete(id, niveau) {
            if (confirm(`Êtes-vous sûr de vouloir supprimer les frais du niveau "${niveau}" ?\nCette action est irréversible.`)) {
                const form = document.getElementById('delete-form');
                form.action = `/frais-scolaire/${id}`;
                form.submit();
            }
        }
        </script>
    
@endsection
