<?php

namespace App\Http\Controllers;

use App\Http\Requests\EleveRequest;
use App\Models\anneeScolaire;
use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Http\Request;

class EleveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {

    //     $query = Eleve::with('classe');

    //     if ($request->filled('classe_id')) {

    //         $search = $request->search;

    //         $query->where(function($q) use ($search){
    //             $q->where('nom', 'like', "%{$search}%")->orWhere('prenom', 'like', "%{$search}%")->orWhere('matricule', 'like', "%{$search}%");
    //         });

    //         $eleves = $query->paginate(10);
    //         $classes = Classe::all();

    //         return view('eleves.index', compact('eleves', 'classes'));

    //     }

    // }

    public function index(Request $request)
    {
        $query = Eleve::with('classe');

        // Filtre par classe
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        // Filtre par recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                ->orWhere('prenom', 'like', "%{$search}%")
                ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $eleves = $query->paginate(10);
        $classes = Classe::all();

        return view('eleves.index', compact('eleves', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classe::all();
        return view('eleves.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EleveRequest $request)
    {
        anneeScolaire::firstOrCreate([
            'libelle' => annee_scolaire_actuelle()
        ]);

        $info = $request->validated();
        $info['matricule'] = genererMatricule();

        Eleve::create($info);

        return redirect()->route('eleves.index')->with('message', 'Elève enregistré');
    }

    /**
     * Display the specified resource.
     */
    public function show(Eleve $eleve)
    {
        $eleve->load('classe', 'paiements');
        return view('eleves.show', compact('eleve'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Eleve $eleve)
    {
        $classes = Classe::all();
        return view('eleves.edit', compact('eleve', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EleveRequest $request, Eleve $eleve)
    {
        $eleve->update($request->validated());
        return redirect()->route('eleves.index')->with('message', 'Mise à jour éffectuée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
