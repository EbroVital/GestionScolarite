<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClasseRequest;
use App\Models\anneeScolaire;
use App\Models\Classe;
use App\Models\fraisScolaire;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classe::withCount('eleves')->get();
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $frais = fraisScolaire::all();
        return view('classes.create', compact('frais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClasseRequest $request)
    {
        $anneeScolaire = anneeScolaire::where("libelle", annee_scolaire_actuelle())->where('est_active', true)->first();

        if(!$anneeScolaire){

            $anneeScolaire = anneeScolaire::firstOrCreate([
                'libelle' => annee_scolaire_actuelle(),
                'est_active' => true
            ]);

        }

            $info = $request->validated();
            $info['annee_scolaire_id'] = $anneeScolaire->id;

            Classe::create($info);

        return redirect()->route('classe.index')->with('message', 'Classe enregistrée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classe $classe)
    {
        $classe->load('eleves', 'fraisScolaire');
        return view('classes.show', compact('classe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classe $classe)
    {
        return view('classes.edit', compact('classe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClasseRequest $request, Classe $classe)
    {

        $info = $request->validated();

        $classe->update($info);

        return redirect()->route('classe.index')->with('message', 'Mise à jour éffectué');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classe $classe)
    {
        if($classe->eleves()->count() > 0){
            return redirect()->route('classe.index')->with('message', 'Impossible de supprimer cette classe');
        }

        $classe->delete();

        return redirect()->route('classe.index')->with('message', 'Suppression éffectuée');
    }
}
