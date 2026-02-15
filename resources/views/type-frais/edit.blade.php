
@extends('layouts.template')

@section('title', 'Modifier le type de paiement')

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 mb-0">Modifier le type de paiement</h1>
        </div>

        {{-- Info box --}}
        <div class="alert alert-info d-flex align-items-center mb-4">
            <i class="fas fa-info-circle me-2"></i>
            <div>
                Vous modifiez le type <strong>{{ $type->libelle }}</strong>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('type-paiement.update', $type) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Libellé --}}
                            <div class="mb-4">
                                <label for="libelle" class="form-label">
                                    <i class="fas fa-tag me-2 text-primary"></i>
                                    Libellé du type <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    name="libelle"
                                    id="libelle"
                                    value="{{ old('libelle', $type->libelle) }}"
                                    class="form-control form-control-lg @error('libelle') is-invalid @enderror"
                                    placeholder="Ex: Espèces, Mobile Money, Virement..."
                                    required
                                    autofocus>
                                <small class="text-muted">Saisissez un nom clair et unique</small>
                                @error('libelle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Avertissement si utilisé --}}
                            @if($type->paiements()->count() > 0)
                                <div class="alert alert-warning d-flex align-items-start mb-4">
                                    <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                    <div>
                                        <strong>Attention !</strong> Ce type est utilisé dans <strong>{{ $type->paiements()->count() }}</strong> paiement(s). La modification du libellé affectera l'affichage de tous ces paiements.
                                    </div>
                                </div>
                            @endif

                            {{-- Informations --}}
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3">Informations actuelles</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Paiements</small>
                                            <strong>{{ $type->paiements()->count() }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Créé le</small>
                                            <strong>{{ $type->created_at->format('d/m/Y') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Boutons --}}
                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('type-paiement.show', $type) }}" class="btn btn-secondary">
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
@endsection
