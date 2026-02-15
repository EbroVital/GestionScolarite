<?php

namespace App\Http\Controllers;

use App\Models\Recu;
use Illuminate\Http\Request;

class recuController extends Controller
{
    public function show($id) {

        $recu = $recu = Recu::with([
            'paiement.eleve.classe.anneeScolaire',
            'paiement.eleve.classe.fraisScolaire',
            'paiement.eleve.paiements.typePaiement',
            'paiement.eleve.paiements.recu',
            'paiement.typePaiement'
        ])->findOrFail($id);
        return view('recus.show', compact('recu'));
    }
}
