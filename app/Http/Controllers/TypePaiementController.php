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
        return view('type-frais.index', compact('TypePaiements'));
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
    public function show(TypePaiement $type)
    {
        $type->load('paiements.eleve');
        return view('type-frais.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypePaiement $type)
    {
        return view('type-frais.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypePaiement $type)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:type_paiements,libelle,' . $type->id,
        ]);

        $type->update($validated);

        return redirect()->route('type-paiement.index')->with('message', 'Mise à jour effectuée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypePaiement $type)
    {
        if ($type->paiements()->count() > 0) {
            return redirect()->route('type-paiement.index')
            ->with('message', "Impossible de supprimer '{$type->libelle}' car il est utilisé dans {$type->paiements()->count()} paiement(s)");
        }

        $libelle = $type->libelle;
        $type->delete();

        return redirect()->route('type-paiement.index')->with('message', "Le type de paiement '{$libelle}' a été supprimé avec succès");
    }
}
