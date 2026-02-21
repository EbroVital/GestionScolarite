@extends('layouts.template')

@section('title', "Détails de l'élève")

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- En-tête --}}
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <h1 class="text-3xl font-bold text-gray-800">Fiche élève</h1>
            </div>
            <div class="flex gap-2">

                <button onclick="window.print()"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-print mr-2"></i> Imprimer
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Colonne gauche : Informations personnelles --}}
            <div class="lg:col-span-2">
                {{-- Carte principale --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 rounded-full h-20 w-20 flex items-center justify-center text-3xl font-bold text-blue-600 mr-4">
                            {{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $eleve->NomComplet }}</h2>
                            <p class="text-gray-600">Matricule : <span class="font-semibold">{{ $eleve->matricule }}</span></p>
                            <p class="text-gray-600">Classe : <span class="font-semibold">{{ $eleve->classe->niveau }}</span></p>
                        </div>
                    </div>

                    {{-- Informations détaillées --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-gray-400 w-8"></i>
                            <div>
                                <p class="text-xs text-gray-500">Date de naissance</p>
                                <p class="font-semibold">{{ $eleve->date_naissance->format('d/m/Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $eleve->date_naissance->age }} ans</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-venus-mars text-gray-400 w-8"></i>
                            <div>
                                <p class="text-xs text-gray-500">Sexe</p>
                                <p class="font-semibold">{{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-phone text-gray-400 w-8"></i>
                            <div>
                                <p class="text-xs text-gray-500">Téléphone parent</p>
                                <p class="font-semibold">{{ $eleve->telephone_parent }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-400 w-8"></i>
                            <div>
                                <p class="text-xs text-gray-500">Adresse</p>
                                <p class="font-semibold">{{ $eleve->adresse }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Historique des paiements --}}
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">
                        <i class="fas fa-money-bill-wave mr-2 text-green-600"></i>
                        Historique des paiements
                    </h3>

                    @if($eleve->paiements->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Reçu</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($eleve->paiements as $paiement)
                                        <tr>
                                            <td class="px-4 py-3 text-sm">{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3 text-sm font-semibold text-green-600">
                                                {{ formater_montant($paiement->montant) }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">{{ $paiement->typePaiement->libelle }}</td>
                                            <td class="px-4 py-3 text-sm">
                                                @if($paiement->recu)
                                                    <a href="{{ route('recus.show', $paiement->recu) }}"
                                                    class="text-blue-600 hover:underline">
                                                        {{ $paiement->recu->numero_recu }}
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Aucun paiement enregistré</p>
                    @endif
                </div>
            </div>

            {{-- Colonne droite : Résumé financier --}}
            <div>
                {{-- Carte résumé --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Situation financière</h3>

                    @php
                        $fraisScolaire = $eleve->classe->fraisScolaire->montant ?? 0;
                        $totalPaye = $eleve->paiements->sum('montant');
                        $solde = $fraisScolaire - $totalPaye;
                    @endphp

                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Frais de scolarité</span>
                            <span class="font-semibold text-gray-800">{{ formater_montant($fraisScolaire) }}</span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Total payé</span>
                            <span class="font-semibold text-green-600">{{ formater_montant($totalPaye) }}</span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600 font-semibold">Solde restant</span>
                            <span class="font-bold text-lg {{ $solde > 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ formater_montant($solde) }}
                            </span>
                        </div>

                        {{-- Barre de progression --}}
                        <div class="mt-4">
                            @php
                                $pourcentage = $fraisScolaire > 0 ? ($totalPaye / $fraisScolaire) * 100 : 0;
                            @endphp
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Progression</span>
                                <span class="font-semibold">{{ number_format($pourcentage, 0) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-600 h-3 rounded-full transition-all duration-500"
                                    style="width: {{ min($pourcentage, 100) }}%"></div>
                            </div>
                        </div>

                        {{-- Bouton paiement --}}
                        <a href="{{ route('paiements.create', ['eleve_id' => $eleve->id, 'classe_id' => $eleve->classe_id]) }}"
                        class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-semibold px-4 py-3 rounded-lg transition duration-200 mt-4">
                            <i class="fas fa-plus-circle mr-2"></i> Enregistrer un paiement
                        </a>
                    </div>
                </div>

                {{-- Informations complémentaires --}}
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-500">Année scolaire</p>
                            <p class="font-semibold">{{ $eleve->classe->anneeScolaire->libelle }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Date d'inscription</p>
                            <p class="font-semibold">{{ $eleve->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Dernière modification</p>
                            <p class="font-semibold">{{ $eleve->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
