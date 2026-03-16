<?php

namespace App\Http\Controllers;

use App\Models\TypePaiement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TypePaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $typePaiements = TypePaiement::withCount('paiements')->get();
        return view('type-frais.index', compact('typePaiements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('type-frais.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:type_paiements,libelle',
        ]);

        TypePaiement::create($validated);

        return Redirect()->route('type-paiement.index')->with('message', 'Type de paiement enregistré');

    }

    /**
     * Display the specified resource.
     */
    public function show(TypePaiement $type_paiement)
    {
        $type_paiement->load('paiements.eleve');
        // dd($type_paiement);
        return view('type-frais.show', compact('type_paiement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypePaiement $type_paiement)
    {
        // dd($type_paiement);
        return view('type-frais.edit', compact('type_paiement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypePaiement $type_paiement)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:type_paiements,libelle,' . $type_paiement->id,
        ]);

        $type_paiement->update($validated);

        return redirect()->route('type-paiement.index')->with('message', 'Mise à jour effectuée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypePaiement $type_paiement)
    {
        if ($type_paiement->paiements()->count() > 0) {
            return redirect()->route('type-paiement.index')
            ->with('message', "Impossible de supprimer '{$type_paiement->libelle}' car il est utilisé dans {$type_paiement->paiements()->count()} paiement(s)");
        }

        $libelle = $type_paiement->libelle;
        $type_paiement->delete();

        return redirect()->route('type-paiement.index')->with('message', "Le type de paiement '{$libelle}' a été supprimé avec succès");
    }
}
