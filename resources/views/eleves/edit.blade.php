@extends('layouts.template')

@section('title', "Modifier l'élève")

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- En-tête --}}
        <div class="flex items-center mb-6">
            <a href="{{ route('eleves.show', $eleve) }}"
            class="mr-4 text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Modifier l'élève</h1>
        </div>

        {{-- Informations actuelles --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 max-w-3xl mx-auto">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                Vous modifiez la fiche de <strong>{{ $eleve->nom_complet }}</strong> (Matricule : {{ $eleve->matricule }})
            </p>
        </div>

        {{-- Formulaire --}}
        <div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
            <form action="{{ route('eleves.update', $eleve) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Informations personnelles --}}
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">
                        Informations personnelles
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nom --}}
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                name="nom"
                                id="nom"
                                value="{{ old('nom', $eleve->nom) }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nom') border-red-500 @enderror"
                                required>
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Prénom --}}
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                name="prenom"
                                id="prenom"
                                value="{{ old('prenom', $eleve->prenom) }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('prenom') border-red-500 @enderror"
                                required>
                            @error('prenom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Date de naissance --}}
                        <div>
                            <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-2">
                                Date de naissance <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                name="date_naissance"
                                id="date_naissance"
                                value="{{ old('date_naissance', $eleve->date_naissance->format('Y-m-d')) }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date_naissance') border-red-500 @enderror"
                                required>
                            @error('date_naissance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Sexe --}}
                        <div>
                            <label for="sexe" class="block text-sm font-medium text-gray-700 mb-2">
                                Sexe <span class="text-red-500">*</span>
                            </label>
                            <select name="sexe"
                                    id="sexe"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sexe') border-red-500 @enderror"
                                    required>
                                <option value="">-- Sélectionner --</option>
                                <option value="M" {{ old('sexe', $eleve->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('sexe', $eleve->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            @error('sexe')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Informations scolaires --}}
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">
                        Informations scolaires
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Matricule (non modifiable) --}}
                        <div>
                            <label for="matricule" class="block text-sm font-medium text-gray-700 mb-2">
                                Matricule
                            </label>
                            <input type="text"
                                id="matricule"
                                value="{{ $eleve->matricule }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                                disabled>
                            <p class="mt-1 text-xs text-gray-500">Le matricule ne peut pas être modifié</p>
                        </div>

                        {{-- Classe --}}
                        <div>
                            <label for="classe_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Classe <span class="text-red-500">*</span>
                            </label>
                            <select name="classe_id"
                                    id="classe_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('classe_id') border-red-500 @enderror"
                                    required>
                                <option value="">-- Sélectionner une classe --</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}"
                                        {{ old('classe_id', $eleve->classe_id) == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->niveau }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classe_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Informations de contact --}}
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">
                        Informations de contact
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Téléphone parent --}}
                        <div>
                            <label for="telephone_parent" class="block text-sm font-medium text-gray-700 mb-2">
                                Téléphone parent <span class="text-red-500">*</span>
                            </label>
                            <input type="tel"
                                name="telephone_parent"
                                id="telephone_parent"
                                value="{{ old('telephone_parent', $eleve->telephone_parent) }}"
                                placeholder="Ex: 0123456789"
                                maxlength="10"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telephone_parent') border-red-500 @enderror"
                                required>
                            @error('telephone_parent')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Adresse --}}
                        <div>
                            <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                                Adresse <span class="text-red-500">*</span>
                            </label>
                            <textarea name="adresse"
                                    id="adresse"
                                    rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('adresse') border-red-500 @enderror"
                                    required>{{ old('adresse', $eleve->adresse) }}</textarea>
                            @error('adresse')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Avertissement --}}
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Attention :</strong> La modification de la classe peut affecter les frais de scolarité de l'élève.
                    </p>
                </div>

                {{-- Boutons --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('eleves.show', $eleve) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-lg transition duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
