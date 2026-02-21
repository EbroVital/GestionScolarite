
@extends('layouts.template')

@section('title', 'Modifier les frais scolaires')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 mb-0">Modifier les frais scolaires</h1>
        </div>

        {{-- Info box --}}
        <div class="alert alert-info d-flex align-items-center mb-4">
            <i class="fas fa-info-circle me-2"></i>
            <div>
                Vous modifiez les frais du niveau <strong>{{ $frais->niveau }}</strong>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('frais-scolaire.update', $frais) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Niveau --}}
                            <div class="mb-4">
                                <label for="niveau" class="form-label">
                                    <i class="fas fa-layer-group me-2 text-primary"></i>
                                    Niveau <span class="text-danger">*</span>
                                </label>
                                <select name="niveau"
                                        id="niveau"
                                        class="form-select form-select-lg @error('niveau') is-invalid @enderror"
                                        required>
                                    <option value="">-- Sélectionner un niveau --</option>
                                    <option value="6ème" {{ old('niveau', $frais->niveau) == '6ème' ? 'selected' : '' }}>6ème</option>
                                    <option value="5ème" {{ old('niveau', $frais->niveau) == '5ème' ? 'selected' : '' }}>5ème</option>
                                    <option value="4ème" {{ old('niveau', $frais->niveau) == '4ème' ? 'selected' : '' }}>4ème</option>
                                    <option value="3ème" {{ old('niveau', $frais->niveau) == '3ème' ? 'selected' : '' }}>3ème</option>
                                    <option value="2nde" {{ old('niveau', $frais->niveau) == '2nde' ? 'selected' : '' }}>2nde</option>
                                    <option value="1ère" {{ old('niveau', $frais->niveau) == '1ère' ? 'selected' : '' }}>1ère</option>
                                    <option value="Tle" {{ old('niveau', $frais->niveau) == 'Tle' ? 'selected' : '' }}>Terminale</option>
                                </select>
                                <small class="text-muted">Choisissez le niveau scolaire concerné</small>
                                @error('niveau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Montant --}}
                            <div class="mb-4">
                                <label for="montant" class="form-label">
                                    <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                                    Montant (FCFA) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="number"
                                        name="montant"
                                        id="montant"
                                        value="{{ old('montant', $frais->montant) }}"
                                        min="0"
                                        step="1000"
                                        class="form-control @error('montant') is-invalid @enderror"
                                        placeholder="Ex: 100000"
                                        required>
                                    <span class="input-group-text">FCFA</span>
                                    @error('montant')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Montant annuel de la scolarité pour ce niveau</small>
                            </div>

                            {{-- Aperçu en temps réel --}}
                            <div class="card border-success mb-4">
                                <div class="card-body text-center">
                                    <small class="text-muted d-block mb-2">Aperçu du montant</small>
                                    <h3 class="text-success mb-0" id="preview">{{ formater_montant($frais->montant) }}</h3>
                                </div>
                            </div>

                            {{-- Avertissement si utilisé --}}
                            @if($frais->classes()->count() > 0)
                                <div class="alert alert-warning d-flex align-items-start mb-4">
                                    <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                    <div>
                                        <strong>Attention !</strong> Ces frais sont utilisés par <strong>{{ $frais->classes()->count() }}</strong> classe(s) regroupant <strong>{{ $frais->classes->sum(function($c) { return $c->eleves->count(); }) }}</strong> élève(s). La modification affectera toutes ces classes.
                                    </div>
                                </div>
                            @endif

                            {{-- Informations actuelles --}}
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3">Informations actuelles</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Montant actuel</small>
                                            <strong class="text-success">{{ formater_montant($frais->montant) }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Classes</small>
                                            <strong>{{ $frais->classes()->count() }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Boutons --}}
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('frais-scolaire.show') }}" class="btn btn-secondary">
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
            // Fonction pour formater le montant
            function formatMontant(montant) {
                return new Intl.NumberFormat('fr-FR').format(montant) + ' FCFA';
            }

            // Mettre à jour l'aperçu en temps réel
            function updatePreview(value) {
                const preview = document.getElementById('preview');
                preview.textContent = value > 0 ? formatMontant(value) : '0 FCFA';
            }

            // Écouter les changements dans le champ montant
            document.getElementById('montant').addEventListener('input', function() {
                updatePreview(this.value);
            });

            // Initialiser l'aperçu avec le montant actuel
            window.addEventListener('DOMContentLoaded', function() {
                const montant = document.getElementById('montant').value;
                if (montant) {
                    updatePreview(montant);
                }
            });
        </script>
    @endpush
@endsection
