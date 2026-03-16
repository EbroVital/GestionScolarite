
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
                Vous modifiez le type <strong>{{ $type_paiement->libelle }}</strong>
            </div>
        </div>

        <div class="container justify-content-center">
            <div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('type-paiement.update', $type_paiement) }}" method="POST">
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
                                    value="{{ old('libelle', $type_paiement->libelle) }}"
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
                            @if($type_paiement->paiements()->count() > 0)
                                <div class="alert alert-warning d-flex align-items-start mb-4">
                                    <i class="fas fa-exclamation-triangle me-2 mt-1"></i> &nbsp;
                                    <div>
                                        <strong>Attention !</strong> Ce type est utilisé dans <strong>{{ $type_paiement->paiements()->count() }}</strong> paiement(s). La modification du libellé affectera l'affichage de tous ces paiements.
                                    </div>
                                </div>
                            @endif

                            {{-- Informations --}}
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3 text-center">Informations actuelles</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Paiements</small>
                                            <strong>{{ $type_paiement->paiements()->count() }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Créé le</small>
                                            <strong>{{ $type_paiement->created_at->format('d/m/Y') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Boutons --}}
                            <a href="{{ route('type-paiement.show', $type_paiement) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> &nbsp; Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> &nbsp;Enregistrer les modifications
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
