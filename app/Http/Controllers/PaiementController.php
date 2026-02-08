<?php

namespace App\Http\Controllers;

use App\Http\Requests\paiementRequest;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\fraisScolaire;
use App\Models\Paiement;
use App\Models\Recu;
use App\Models\TypePaiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paiements = Paiement::with('eleves', 'typePaiement', 'recu')->get();
        $total = Paiement::sum('montant');
        return view('paiements.index', compact('paiements', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // on recupere l'ID de la classe ainsi que de l'eleve
        $eleveId = $request->get('eleve_id');
        $classeId = $request->get('classe_id');

        // ensuite on recupere tous les eleves de la classe si une classe est selectionnée
        $eleves = $classeId ? Eleve::where('classe_id', $classeId)->get() : collect();

        // on recupere aussi toute les classes
       $classes = Classe::with(['anneeScolaire', 'fraisScolaire'])->get();

        // on recupere tous les types de paiements
        $typesPaiement  = TypePaiement::all();

        // Si élève sélectionné, récupérer ses infos complètes
        $eleve = null;
        $frais = null;
        $solde = null;

        if ($eleveId) {
            $eleve = Eleve::with(['classe.fraisScolaire', 'paiements'])->findOrFail($eleveId);
            $frais = $eleve->classe->fraisScolaire;
            $totalPaye = $eleve->paiements()->sum('montant');
            $solde = $frais->montant - $totalPaye;
        }

        return view('paiements.create', compact('classes',
        'eleves',
        'eleve',
        'frais',
        'solde',
        'typesPaiement',
        'classeId',
        'eleveId'));
    }


    // rechercher les eleves
    public function getEleves($classeId)
    {
        $eleves = Eleve::where('classe_id', $classeId)
            ->select('id', 'nom', 'prenom', 'matricule')
            ->get();

        return response()->json($eleves);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'type_paiement_id' => 'required|exists:type_paiements,id',
            'montant' => 'required|numeric|min:0',
            'observation' => 'nullable|string',
            'reference_transaction' => 'nullable|string',
            'date_paiement' => 'required|date'
        ]);

        // Vérifier que le montant ne dépasse pas le solde
        $eleve = Eleve::with(['classe.fraisScolaire', 'paiements'])->findOrFail($validated['eleve_id']);
        $solde = calculer_solde_eleve($eleve->id);

        if ($validated['montant'] > $solde) {
            return back()->withErrors(['montant' => 'Le montant dépasse le solde restant.']);
        }

        // Créer le paiement
        $paiement = Paiement::create([
            'eleve_id' => $validated['eleve_id'],
            'type_paiement_id' => $validated['type_paiement_id'],
            'montant' => $validated['montant'],
            'date_paiement' => now(),
            'observation' => $validated['observation'],
            'reference_transaction' => $validated['reference_transaction']
        ]);

        // Créer le reçu
        $recu = Recu::create([
            'paiement_id' => $paiement->id,
            'numero_recu' => generer_numero_recu(),
            'montant' => $paiement->montant,
            'date_emission' => now(),
        ]);

        return redirect()->route('recus.show', $recu->id)->with('message', 'Paiement enregistré avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
