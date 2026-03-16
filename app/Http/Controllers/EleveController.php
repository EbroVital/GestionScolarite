<?php

namespace App\Http\Controllers;

use App\Http\Requests\EleveRequest;
use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            $search = trim($request->search);

            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                ->orWhere('prenom', 'like', "%{$search}%")
                ->orWhere('matricule', 'like', "%{$search}%")
                ->orWhere(DB::raw("CONCAT(prenom, ' ', nom)"), 'like', "%{$search}%")->orWhere(DB::raw("CONCAT(nom, ' ', prenom)"), 'like', "%{$search}%");
            });
        }

        $eleves = $query->paginate(10);
        $classes = Classe::all();

        return view('eleves.index', compact('eleves', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $classes = Classe::all();
        $classeId = $request->classe_id;
        return view('eleves.create', compact('classes', 'classeId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EleveRequest $request)
    {

        $info = $request->validated();
        $info['matricule'] = genererMatricule();

        // dd($request->all());

        Eleve::create($info);

        return redirect()->route('eleves.index')->with('message', 'Elève enregistré');
    }

    /**
     * Display the specified resource.
     */
    public function show(Eleve $elefe)
    {
        $elefe->load('classe', 'paiements');
        // dd($elefe);
        return view('eleves.show', compact('elefe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Eleve $elefe)
    {
        $classes = Classe::all();
        return view('eleves.edit', compact('elefe', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EleveRequest $request, Eleve $elefe)
    {
        $elefe->update($request->validated());
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
