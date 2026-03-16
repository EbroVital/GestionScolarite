<?php

namespace App\Http\Controllers;

use App\Models\Recu;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function downloadPDF($id)
    {
        $recu = Recu::with([
            'paiement.eleve.classe.anneeScolaire',
            'paiement.eleve.classe.fraisScolaire',
            'paiement.eleve.paiements.typePaiement',
            'paiement.eleve.paiements.recu',
            'paiement.typePaiement'
        ])->findOrFail($id);

        // Générer le PDF à partir de la vue
        $pdf = Pdf::loadView('recus.pdf', compact('recu'))
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        // Télécharger le PDF
        return $pdf->download("recu-{$recu->numero_recu}.pdf");

        // Ou afficher dans le navigateur
        // return $pdf->stream("recu-{$recu->numero_recu}.pdf");
    }
}
