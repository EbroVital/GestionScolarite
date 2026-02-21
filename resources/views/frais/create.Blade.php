
@extends('layouts.template')

@section('title', 'Créer un frais scolaire')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 mb-0">Ajouter un frais scolaire</h1>
        </div>

        <div class="row justify-content-center">
            <div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('frais-scolaire.store') }}" method="POST">
                            @csrf

                            {{-- Niveau --}}
                            <div class="mb-4">
                                <label for="niveau" class="form-label">
                                    <i class="fas fa-layer-group me-2 text-primary"></i>
                                    Niveau <span class="text-danger">*</span>
                                </label>
                                <select name="niveau"
                                        id="niveau"
                                        class="form-control form-select-lg @error('niveau') is-invalid @enderror"
                                        >
                                    <option value="">-- Sélectionner un niveau --</option>
                                    <option value="6ème" {{ old('niveau') == '6ème' ? 'selected' : '' }}>6ème</option>
                                    <option value="5ème" {{ old('niveau') == '5ème' ? 'selected' : '' }}>5ème</option>
                                    <option value="4ème" {{ old('niveau') == '4ème' ? 'selected' : '' }}>4ème</option>
                                    <option value="3ème" {{ old('niveau') == '3ème' ? 'selected' : '' }}>3ème</option>
                                    <option value="2nde" {{ old('niveau') == '2nde' ? 'selected' : '' }}>2nde</option>
                                    <option value="1ère" {{ old('niveau') == '1ère' ? 'selected' : '' }}>1ère</option>
                                    <option value="Tle" {{ old('niveau') == 'Tle' ? 'selected' : '' }}>Terminale</option>
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
                                        value="{{ old('montant') }}"
                                        min="0"
                                        step="1000"
                                        class="form-control @error('montant') is-invalid @enderror"
                                        placeholder="Ex: 100000"
                                        >
                                    <span class="input-group-text">FCFA</span>
                                    @error('montant')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Montant annuel de la scolarité pour ce niveau</small>
                            </div>

                            {{-- Montants suggérés --}}
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3">
                                        <i class="fas fa-lightbulb text-warning me-2"></i>Montants suggérés
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setMontant(50000)">
                                            50 000 FCFA
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setMontant(75000)">
                                            75 000 FCFA
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setMontant(100000)">
                                            100 000 FCFA
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setMontant(125000)">
                                            125 000 FCFA
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setMontant(150000)">
                                            150 000 FCFA
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Aperçu en temps réel --}}
                            <div class="card border-success mb-4">
                                <div class="card-body text-center">
                                    <small class="text-muted d-block mb-2">Aperçu du montant</small>
                                    <h3 class="text-success mb-0" id="preview">0 FCFA</h3>
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="alert alert-info d-flex align-items-start mb-4">
                                <i class="fas fa-info-circle me-2 mt-1"></i>
                                <div class="small">
                                    Ce montant sera appliqué à toutes les classes de ce niveau. Vous pourrez le modifier ultérieurement si nécessaire.
                                </div>
                            </div>

                            {{-- Boutons --}}
                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('frais-scolaire.index') }}" class="btn btn-secondary">
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


        <script>
            // Fonction pour définir le montant
            function setMontant(value) {
                document.getElementById('montant').value = value;
                updatePreview(value);
            }

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

            // Initialiser l'aperçu si un montant existe déjà
            window.addEventListener('DOMContentLoaded', function() {
                const montant = document.getElementById('montant').value;
                if (montant) {
                    updatePreview(montant);
                }
            });
        </script>
    
@endsection
