{{-- resources/views/paiements/create.blade.php --}}
@extends('layouts.template')

@section('title', 'Enregistrer un paiement')

@section('content')

    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 mb-0">Enregistrer un paiement</h1>
        </div>

        <div class="row">
            {{-- Formulaire --}}
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('paiements.store') }}" method="POST" id="paiementForm">
                            @csrf

                            {{-- Sélection classe --}}
                            <div class="mb-4">
                                <label for="classe_id" class="form-label">
                                    <i class="fas fa-school me-2 text-primary"></i>
                                     Classe <span class="text-danger">*</span>
                                </label>
                                <select name="classe_id"
                                        id="classe_id"
                                        class="form-control @error('classe_id') is-invalid @enderror">
                                    <option value="">-- Sélectionner une classe --</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}"
                                            {{ $classeId == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->niveau }} ({{ $classe->anneeScolaire->libelle }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('classe_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sélection élève --}}
                            <div class="mb-4">
                                <label for="eleve_id" class="form-label">
                                    <i class="fas fa-user-graduate me-2 text-primary"></i>
                                     Élève <span class="text-danger">*</span>
                                </label>
                                <select name="eleve_id"
                                        id="eleve_id"
                                        class="form-control @error('eleve_id') is-invalid @enderror"
                                        {{ !$classeId ? 'disabled' : '' }}
                                        required>
                                    <option value="">-- Sélectionner un élève --</option>
                                    @foreach($eleves as $eleveItem)
                                        <option value="{{ $eleveItem->id }}"
                                            {{ $eleveId == $eleveItem->id ? 'selected' : '' }}>
                                            {{ $eleveItem->prenom }} {{ $eleveItem->nom }} ({{ $eleveItem->matricule }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('eleve_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Informations élève (si sélectionné) --}}
                            @if($eleve)
                                <div class="alert alert-info mb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Frais de scolarité</small>
                                            <strong>{{ formater_montant($frais->montant) }}</strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Total payé</small>
                                            <strong class="text-success">{{ formater_montant($eleve->paiements->sum('montant')) }}</strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Solde restant</small>
                                            <strong class="{{ $solde > 0 ? 'text-danger' : 'text-success' }}">
                                                {{ formater_montant($solde) }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Type de paiement --}}
                            <div class="mb-4">
                                <label for="type_paiement_id" class="form-label">
                                    <i class="fas fa-credit-card me-2 text-primary"></i>
                                     Type de paiement <span class="text-danger">*</span>
                                </label>
                                <select name="type_paiement_id"
                                        id="type_paiement_id"
                                        class="form-control @error('type_paiement_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Sélectionner un type --</option>
                                    @foreach($typesPaiement as $type)
                                        <option value="{{ $type->id }}" {{ old('type_paiement_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_paiement_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Montant --}}
                            <div class="mb-4">
                                <label for="montant" class="form-label">
                                    <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                                    Montant (FCFA) <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                    name="montant"
                                    id="montant"
                                    value="{{ old('montant') }}"
                                    min="0"
                                    max="{{ $solde ?? '' }}"
                                    step="100"
                                    class="form-control form-control-lg @error('montant') is-invalid @enderror"
                                    placeholder="Ex: 50000"
                                    required>
                                @if($solde)
                                    <small class="text-muted">Maximum : {{ formater_montant($solde) }}</small>
                                @endif
                                @error('montant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Date de paiement --}}
                            <div class="mb-4">
                                <label for="date_paiement" class="form-label">
                                    <i class="fas fa-calendar me-2 text-primary"></i>
                                    Date du paiement <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                    name="date_paiement"
                                    id="date_paiement"
                                    value="{{ old('date_paiement', date('Y-m-d')) }}"
                                    class="form-control @error('date_paiement') is-invalid @enderror"
                                    required>
                                @error('date_paiement')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Référence transaction --}}
                            <div class="mb-4">
                                <label for="reference_transaction" class="form-label">
                                    <i class="fas fa-hashtag me-2 text-primary"></i>
                                    Référence transaction (optionnel)
                                </label>
                                <input type="text"
                                    name="reference_transaction"
                                    id="reference_transaction"
                                    value="{{ old('reference_transaction') }}"
                                    class="form-control @error('reference_transaction') is-invalid @enderror"
                                    placeholder="Ex: TXN123456">
                                <small class="text-muted">Pour Mobile Money, chèque, virement, etc.</small>
                                @error('reference_transaction')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Observation --}}
                            <div class="mb-4">
                                <label for="observation" class="form-label">
                                    <i class="fas fa-comment me-2 text-primary"></i>
                                    Observation (optionnel)
                                </label>
                                <textarea name="observation"
                                        id="observation"
                                        rows="3"
                                        class="form-control @error('observation') is-invalid @enderror"
                                        placeholder="Notes complémentaires...">{{ old('observation') }}</textarea>
                                @error('observation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Boutons --}}
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('paiements.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check me-1"></i>Enregistrer le paiement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Sidebar aide --}}
            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Instructions
                        </h6>
                    </div>
                    <div class="card-body">
                        <ol class="mb-0 ps-3">
                            <li class="mb-2">Sélectionnez la classe de l'élève</li>
                            <li class="mb-2">Choisissez l'élève concerné</li>
                            <li class="mb-2">Vérifiez le solde restant</li>
                            <li class="mb-2">Saisissez le montant du paiement</li>
                            <li class="mb-0">Un reçu sera généré automatiquement</li>
                        </ol>
                    </div>
                </div>

                <div class="card shadow-sm border-warning">
                    <div class="card-body">
                        <h6 class="text-warning mb-2">
                            <i class="fas fa-exclamation-triangle me-2"></i>Important
                        </h6>
                        <ul class="small mb-0 ps-3">
                            <li class="mb-1">Le montant ne peut pas dépasser le solde restant</li>
                            <li class="mb-1">Le reçu sera automatiquement généré</li>
                            <li class="mb-0">Vérifiez bien les informations avant de valider</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Charger les élèves quand on change de classe
            document.getElementById('classe_id').addEventListener('change', function() {
                const classeId = this.value;
                const eleveSelect = document.getElementById('eleve_id');

                if (!classeId) {
                    eleveSelect.disabled = true;
                    eleveSelect.innerHTML = '<option value="">-- Sélectionner un élève --</option>';
                    return;
                }

                // Recharger la page avec la classe sélectionnée
                window.location.href = `{{ route('paiements.create') }}?classe_id=${classeId}`;
            });

            // Recharger la page quand on sélectionne un élève
            document.getElementById('eleve_id').addEventListener('change', function() {
                const eleveId = this.value;
                const classeId = document.getElementById('classe_id').value;

                if (eleveId && classeId) {
                    window.location.href = `{{ route('paiements.create') }}?classe_id=${classeId}&eleve_id=${eleveId}`;
                }
            });
        </script>
    @endpush

@endsection
