
@extends('layouts.template')

@section('title', 'Créer un type de paiement')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 mb-0">Créer un type de paiement</h1>
        </div>

        <div class="row justify-content-center">
            <div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('type-paiement.store') }}" method="POST">
                            @csrf

                            {{-- Libellé --}}
                            <div class="mb-4">
                                <label for="libelle" class="form-label">
                                    <i class="fas fa-tag me-2 text-primary"></i>
                                    Libellé du type <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    name="libelle"
                                    id="libelle"
                                    value="{{ old('libelle') }}"
                                    class="form-control form-control-lg @error('libelle') is-invalid @enderror"
                                    placeholder="Ex: Espèces, Mobile Money, Virement..."
                                    required
                                    autofocus>
                                <small class="text-muted">Saisissez un nom clair et unique</small>
                                @error('libelle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Exemples --}}
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3">
                                        <i class="fas fa-lightbulb text-warning me-2"></i> Exemples
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setLibelle('Espèces')">
                                            Espèces
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setLibelle('Mobile Money')">
                                            Mobile Money
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setLibelle('Virement bancaire')">
                                            Virement bancaire
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setLibelle('Chèque')">
                                            Chèque
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setLibelle('Carte bancaire')">
                                            Carte bancaire
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="alert alert-info d-flex align-items-start mb-4">
                                <i class="fas fa-info-circle me-2 mt-1"></i>
                                <div class="small">
                                    Le type de paiement vous permet de suivre les différents modes de règlement utilisés par les parents d'élèves.
                                </div>
                            </div>

                            {{-- Boutons --}}
                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('type-paiement.index') }}" class="btn btn-secondary">
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
        function setLibelle(value) {
            document.getElementById('libelle').value = value;
            document.getElementById('libelle').focus();
        }
        </script>
    @endpush
@endsection
