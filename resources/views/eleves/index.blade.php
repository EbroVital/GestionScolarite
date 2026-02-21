@extends('layouts.template')

@section('title', 'Liste des élèves')

@section('content')

    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            @section('h3', 'Liste des élèves')
            <a href="{{ route('eleves.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nouvel élève
            </a>
        </div>

        {{-- Messages de succès --}}
        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filtres de recherche --}}
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('eleves.index') }}" method="GET">
                    <div class="row g-3">
                        {{-- Filtre par classe --}}
                        <div class="col-md-4">
                            <label for="classe_id" class="form-label">Classe</label>
                            <select name="classe_id" id="classe_id" class="form-control">
                                <option value="">Toutes les classes</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->niveau }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Barre de recherche --}}
                        <div class="col-md-5">
                            <label for="search" class="form-label">Recherche</label>
                            <input type="text"
                                name="search"
                                id="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Nom, prénom ou matricule...">
                        </div>

                        {{-- Boutons --}}
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                {{-- <i class="fas fa-search me-1"></i> --}}Rechercher
                            </button>
                            <a href="{{ route('eleves.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tableau des élèves --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Matricule</th>
                                <th class="text-center">Nom complet</th>
                                <th class="text-center">Date de naissance</th>
                                <th class="text-center">Classe</th>
                                <th class="text-center">Sexe</th>
                                <th class="text-center">Adresse</th>
                                <th class="text-center">Téléphone d'un parent</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($eleves as $eleve)
                                <tr>
                                    <td class="fw-bold">{{ $eleve->matricule }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $eleve->NomComplet }}</div>
                                    </td>
                                    <td> <small class="text-muted">{{ $eleve->date_naissance->format('d/m/Y') }}</small> </td>
                                    <td>{{ $eleve->classe->nom ?? 'Non définie' }}</td>
                                    <td>
                                        <span class="text-white badge {{ $eleve->sexe == 'M' ? 'bg-primary' : 'bg-danger' }}">
                                            {{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}
                                        </span>
                                    </td>
                                    <td>{{ $eleve->adresse }}</td>
                                    <td>{{ $eleve->telephone_parent }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('eleves.show', $eleve) }}"
                                            class="btn btn-info"
                                            title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('eleves.edit', $eleve) }}"
                                            class="btn btn-warning"
                                            title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {{-- <button onclick="confirmDelete({{ $eleve->id }})"
                                                    class="btn btn-danger"
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button> --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted mb-0">Aucun élève trouvé</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if($eleves->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Affichage de {{ $eleves->firstItem() }} à {{ $eleves->lastItem() }} sur {{ $eleves->total() }} élèves
                        </div>
                        {{ $eleves->links() }}
                    </div>
                </div>
            @endif
        </div>

        {{-- Statistiques --}}
        <div class="mt-3">
            <p class="text-muted small mb-0">
                <i class="fas fa-users me-1"></i>Total : <strong>{{ $eleves->total() }}</strong> élève(s)
            </p>
        </div>
    </div>

    {{-- Modal de confirmation de suppression --}}
    {{-- <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form> --}}

    {{-- @push('scripts')
        <script>
        function confirmDelete(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet élève ?')) {
                const form = document.getElementById('delete-form');
                form.action = `/eleves/${id}`;
                form.submit();
            }
        }
        </script>
    @endpush --}}

@endsection

