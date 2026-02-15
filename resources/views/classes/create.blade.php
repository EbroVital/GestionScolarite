
@extends('layouts.template')

@section('title', 'Créer une classe')

@section('content')
<div class="container py-4">
    {{-- En-tête --}}
    <div class="d-flex align-items-center mb-4">
        <h1 class="h2 mb-0"> Créer une classe</h1>
    </div>

    <div class="row justify-content-center">
        <div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('classe.store') }}" method="POST">
                        @csrf

                        {{-- Nom de la classe --}}
                        <div class="mb-4">
                            <label for="nom" class="form-label">
                                <i class="fas fa-tag me-2 text-primary"></i>
                                Nom de la classe <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="nom"
                                   id="nom"
                                   value="{{ old('nom') }}"
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
                                    class="form-control @error('niveau') is-invalid @enderror"
                                    required>
                                <option value="">-- Sélectionner un niveau --</option>
                                <option value="6ème" {{ old('niveau') == '6ème' ? 'selected' : '' }}>6ème</option>
                                <option value="5ème" {{ old('niveau') == '5ème' ? 'selected' : '' }}>5ème</option>
                                <option value="4ème" {{ old('niveau') == '4ème' ? 'selected' : '' }}>4ème</option>
                                <option value="3ème" {{ old('niveau') == '3ème' ? 'selected' : '' }}>3ème</option>
                                <option value="2nde" {{ old('niveau') == '2nde' ? 'selected' : '' }}>2nde</option>
                                <option value="1ère" {{ old('niveau') == '1ère' ? 'selected' : '' }}>1ère</option>
                                <option value="Tle" {{ old('niveau') == 'Tle' ? 'selected' : '' }}>Terminale</option>
                            </select>
                            @error('niveau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Année scolaire --}}
                        <div class="mb-4">
                            <label for="annee_scolaire_id" class="form-label">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                Année scolaire <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="annee_scolaire_id"
                                   id="annee_scolaire_id"
                                   value="{{ annee_scolaire_actuelle() }}"
                                   class="form-control"
                                   readonly>
                            <small class="text-muted">L'année scolaire actuelle sera automatiquement assignée</small>
                        </div>

                        {{-- Frais scolaire --}}
                        <div class="mb-4">
                            <label for="frais_scolaire_id" class="form-label">
                                <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                                Frais de scolarité <span class="text-danger">*</span>
                            </label>
                            <select name="frais_scolaire_id"
                                    id="frais_scolaire_id"
                                    class="form-control @error('frais_scolaire_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Sélectionner les frais --</option>
                                @foreach($frais as $fraisScolaire)
                                    <option value="{{ $fraisScolaire->id }}" {{ old('frais_scolaire_id') == $fraisScolaire->id ? 'selected' : '' }}>
                                        {{ $fraisScolaire->niveau }} - {{ formater_montant($fraisScolaire->montant) }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Choisissez les frais correspondant au niveau</small>
                            @error('frais_scolaire_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Info box --}}
                        <div class="alert alert-info d-flex align-items-start mb-4">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <strong> Astuce :</strong> Le nom de la classe doit être unique. Si vous créez plusieurs classes du même niveau (ex: 6ème A, 6ème B), différenciez-les clairement.
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex justify-content-start gap-2">
                            <a href="{{ route('classe.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Enregistrer
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
