@extends('layouts.template')

@section('title', "Modifier l'élève")

@section('content')
    <div class="container py-4">
        {{-- En-tête --}}
        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 mb-0">Modifier un élève</h1>
        </div>

        {{-- Informations actuelles --}}
        <div class="alert alert-info d-flex align-items-center mb-4">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                Vous modifiez la fiche de <strong>{{ $elefe->nom_complet }}</strong> (Matricule : {{ $elefe->matricule }})
            </p>
        </div>

        {{-- Formulaire --}}
        <div class="row">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('eleves.update', $elefe) }}" method="POST">

                            @csrf
                            @method('PUT')

                            {{-- Informations personnelles --}}
                            <div class="mb-4">
                                <h5 class="border-bottom text-center pb-2 mb-3">
                                    <i class="fas fa-user me-2 text-primary"></i>   Informations personnelles
                                </h5>

                                <div class="row g-3">
                                    {{-- Nom --}}
                                    <div class="col-md-6">
                                        <label for="nom" class="form-label">
                                            Nom <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            name="nom"
                                            id="nom"
                                            value="{{ old('nom', $elefe->nom) }}"
                                            class="form-control @error('nom') is-invalid @enderror"
                                            required>
                                        @error('nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Prénom --}}
                                    <div class="col-md-6">
                                        <label for="prenom" class="form-label">
                                            Prénom <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            name="prenom"
                                            id="prenom"
                                            value="{{ old('prenom', $elefe->prenom) }}"
                                            class="form-control @error('prenom') is-invalid @enderror"
                                            required>
                                        @error('prenom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Date de naissance --}}
                                    <div class="col-md-6">
                                        <label for="date_naissance" class="form-label">
                                            Date de naissance <span class="text-danger">*</span>
                                        </label>
                                        <input type="date"
                                            name="date_naissance"
                                            id="date_naissance"
                                            value="{{ old('date_naissance', $elefe->date_naissance->format('Y-m-d')) }}"
                                            class="form-control @error('date_naissance') is-invalid @enderror"
                                            required>
                                        @error('date_naissance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Sexe --}}
                                    <div class="col-md-6">
                                        <label for="sexe" class="form-label">
                                            Sexe <span class="text-danger">*</span>
                                        </label>
                                        <select name="sexe"
                                                id="sexe"
                                                class="form-control @error('sexe') is-invalid @enderror"
                                                required>
                                            <option value="">-- Sélectionner --</option>
                                            <option value="M" {{ old('sexe', $elefe->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                            <option value="F" {{ old('sexe', $elefe->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                                        </select>
                                        @error('sexe')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Informations scolaires --}}
                            <div class="mb-4">
                                <h5 class="border-bottom text-center pb-2 mb-3">
                                    <i class="fas fa-graduation-cap me-2 text-primary"></i>   Informations scolaires
                                </h5>

                                <div class="row g-3">
                                    {{-- Classe --}}
                                    <div class="col-md-6">
                                        <label for="classe_id" class="form-label">
                                            Classe <span class="text-danger">*</span>
                                        </label>
                                        <select name="classe_id"
                                                id="classe_id"
                                                class="form-control @error('classe_id') is-invalid @enderror"
                                                required>
                                            <option value="">-- Sélectionner une classe --</option>
                                            @foreach($classes as $classe)
                                                <option value="{{ $classe->id }}"
                                                    {{ old('classe_id', $elefe->classe_id) == $classe->id ? 'selected' : '' }}>
                                                    {{ $classe->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('classe_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">

                                        <label for="matricule" class="form-label">
                                         Matricule <span class="text-success">*</span>
                                        </label>
                                    <input type="text"
                                        id="matricule"
                                        value="{{ $elefe->matricule }}"
                                        class="form-control"
                                        disabled>
                                    <p class="text text-info">Le matricule ne peut pas être modifié</p>
                                </div>

                                </div>

                            </div>

                            {{-- Informations de contact --}}
                            <div class="mb-4">
                                <h5 class="border-bottom text-center pb-2 mb-3">
                                    <i class="fas fa-address-book me-2 text-primary"></i>  Informations de contact
                                </h5>

                                <div class="row g-3">
                                    {{-- Téléphone parent --}}
                                    <div class="col-md-6">
                                        <label for="telephone_parent" class="form-label">
                                            Téléphone parent <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel"
                                            name="telephone_parent"
                                            id="telephone_parent"
                                            value="{{ old('telephone_parent', $elefe->telephone_parent) }}"
                                            placeholder="Ex: 0123456789"
                                            maxlength="10"
                                            class="form-control @error('telephone_parent') is-invalid @enderror"
                                            required>
                                        @error('telephone_parent')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Adresse --}}
                                    <div class="col-md-6">
                                        <label for="adresse" class="form-label">
                                            Adresse <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="adresse"
                                                id="adresse"
                                                rows="3"
                                                class="form-control @error('adresse') is-invalid @enderror"
                                                required>{{ old('adresse', $elefe->adresse) }}</textarea>
                                        @error('adresse')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Boutons --}}
                                <a href="{{ route('eleves.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> &nbsp; Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> &nbsp; Enregistrer
                                </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
