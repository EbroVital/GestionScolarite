
@extends('layouts.template')

@section('title', 'Modifier la classe')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('classe.show', $classe) }}" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="h2 mb-0">Modifier la classe</h1>
        </div>

        {{-- Info box --}}
        <div class="alert alert-info d-flex align-items-center mb-4">
            <i class="fas fa-info-circle me-2"></i>
            <div>
                Vous modifiez la classe <strong>{{ $classe->niveau }}</strong>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('classe.update', $classe) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Nom de la classe --}}
                            <div class="mb-4">
                                <label for="nom" class="form-label">
                                    <i class="fas fa-tag me-2 text-primary"></i>
                                    Nom de la classe <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    name="nom"
                                    id="nom"
                                    value="{{ old('nom', $classe->nom) }}"
                                    class="form-control @error('nom') is-invalid @enderror"
                                    placeholder="Ex: 6ème A, 3ème B"
                                    required>
                                <small class="text-muted">Saisissez le nom complet de la classe</small>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Niveau --}}
                            <div class="mb-4">
                                <label for="niveau" class="form-label">
                                    <i class="fas fa-layer-group me-2 text-primary"></i>
                                    Niveau <span class="text-danger">*</span>
                                </label>
                                <select name="niveau"
                                        id="niveau"
                                        class="form-select @error('niveau') is-invalid @enderror"
                                        required>
                                    <option value="">-- Sélectionner un niveau --</option>
                                    <option value="6ème" {{ old('niveau', $classe->niveau) == '6ème' ? 'selected' : '' }}>6ème</option>
                                    <option value="5ème" {{ old('niveau', $classe->niveau) == '5ème' ? 'selected' : '' }}>5ème</option>
                                    <option value="4ème" {{ old('niveau', $classe->niveau) == '4ème' ? 'selected' : '' }}>4ème</option>
                                    <option value="3ème" {{ old('niveau', $classe->niveau) == '3ème' ? 'selected' : '' }}>3ème</option>
                                    <option value="2nde" {{ old('niveau', $classe->niveau) == '2nde' ? 'selected' : '' }}>2nde</option>
                                    <option value="1ère" {{ old('niveau', $classe->niveau) == '1ère' ? 'selected' : '' }}>1ère</option>
                                    <option value="Tle" {{ old('niveau', $classe->niveau) == 'Tle' ? 'selected' : '' }}>Terminale</option>
                                </select>
                                @error('niveau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Année scolaire (non modifiable) --}}
                            <div class="mb-4">
                                <label for="annee_scolaire" class="form-label">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                    Année scolaire
                                </label>
                                <input type="text"
                                    id="annee_scolaire"
                                    value="{{ $classe->anneeScolaire->libelle }}"
                                    class="form-control"
                                    disabled>
                                <small class="text-muted">L'année scolaire ne peut pas être modifiée</small>
                            </div>

                            {{-- Frais scolaire --}}
                            <div class="mb-4">
                                <label for="frais_scolaire_id" class="form-label">
                                    <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                                    Frais de scolarité <span class="text-danger">*</span>
                                </label>
                                <select name="frais_scolaire_id"
                                        id="frais_scolaire_id"
                                        class="form-select @error('frais_scolaire_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Sélectionner les frais --</option>
                                    @foreach(\App\Models\FraisScolaire::all() as $fraisScolaire)
                                        <option value="{{ $fraisScolaire->id }}"
                                            {{ old('frais_scolaire_id', $classe->frais_scolaire_id) == $fraisScolaire->id ? 'selected' : '' }}>
                                            {{ $fraisScolaire->niveau }} - {{ formater_montant($fraisScolaire->montant) }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Choisissez les frais correspondant au niveau</small>
                                @error('frais_scolaire_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Avertissement --}}
                            @if($classe->eleves->count() > 0)
                                <div class="alert alert-warning d-flex align-items-start mb-4">
                                    <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                    <div>
                                        <strong>Attention !</strong> Cette classe contient {{ $classe->eleves->count() }} élève(s). La modification des frais de scolarité affectera tous les élèves de cette classe.
                                    </div>
                                </div>
                            @endif

                            {{-- Informations --}}
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3">Informations actuelles</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Nombre d'élèves</small>
                                            <strong>{{ $classe->eleves->count() }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Date de création</small>
                                            <strong>{{ $classe->created_at->format('d/m/Y') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Boutons --}}
                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('classes.show', $classe) }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
        // Auto-sélectionner les frais selon le niveau
        document.getElementById('niveau').addEventListener('change', function() {
            const niveau = this.value;
            const fraisSelect = document.getElementById('frais_scolaire_id');

            // Chercher l'option correspondante
            for (let option of fraisSelect.options) {
                if (option.text.includes(niveau)) {
                    fraisSelect.value = option.value;
                    break;
                }
            }
        });
        </script>
    @endpush
@endsection
