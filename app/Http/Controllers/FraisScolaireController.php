<?php

namespace App\Http\Controllers;

use App\Models\fraisScolaire;
use Illuminate\Http\Request;

class FraisScolaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $frais = fraisScolaire::withCount('classes')->get();
        return view('frais.index', compact('frais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frais.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'niveau' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0'
        ],
            [
            'niveau.required' => 'Le niveau est obligatoire',
            'niveau.unique' => 'Ce niveau existe déjà',
            'montant.required' => 'Le montant est obligatoire',
            'montant.min' => 'Le montant doit être positif',
        ]);

        fraisScolaire::create($validated);

        return redirect()->route('frais-scolaire.index')->with('message', 'Montant des frais ajoutés');
    }

    /**
     * Display the specified resource.
     */
    public function show(fraisScolaire $frais)
    {
        $frais->load('classes.eleves');
        return view('frais.show', compact('frais'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(fraisScolaire $frais)
    {
        return view('frais.edit', compact('frais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, fraisScolaire $frais)
    {
        $validated = $request->validate([
            'niveau' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0'
        ], [
            'niveau.required' => 'Le niveau est obligatoire',
            'niveau.unique' => 'Ce niveau existe déjà',
            'montant.required' => 'Le montant est obligatoire',
            'montant.min' => 'Le montant doit être positif',
        ]);

        $frais->update($validated);

        return redirect()->route('frais-scolaire.index')->with('message', 'Mise à jour éffectuée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(fraisScolaire $frais)
    {
        // Vérifier si le frais est utilisé par des classes
        $count = $frais->classes()->count();

        if ($count > 0) {
            return redirect()->route('frais-scolaire.index')
                ->with('error', "Impossible de supprimer ce frais car il est utilisé par {$count} classe(s)");
        }

        $niveau = $frais->niveau;
        $frais->delete();

        return redirect()->route('frais-scolaire.index')
            ->with('success', "Les frais du niveau '{$niveau}' ont été supprimés avec succès");
    }

}
