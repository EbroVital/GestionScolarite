<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Paiement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $anneeScolaire = annee_scolaire_actuelle();

        // ── Données de base ──────────────────────────────────────────
        $eleves = Eleve::with(['classe.fraisScolaire', 'paiements'])->get();
        $classes = Classe::with(['eleves', 'fraisScolaire'])->get();

        // ── Stats élèves ─────────────────────────────────────────────
        $totalEleves = $eleves->count();
        $nouveauxCeMois = Eleve::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year) ->count();

        // ── Stats financières globales ────────────────────────────────
        $totalEncaisse = Paiement::sum('montant');
        $todayEncaisse = Paiement::where('date_paiement', today())->sum('montant');

        $totalAttendu = $classes->sum(function ($classe) {
            $frais = $classe->fraisScolaire->montant ?? 0;
            return $frais * $classe->eleves->count();
        });

        $totalRestant = $totalAttendu - $totalEncaisse;
        $tauxRecouvrement = $totalAttendu > 0
            ? round(($totalEncaisse / $totalAttendu) * 100, 2)
            : 0;

        // ── Paiements par mois (12 derniers mois) ─────────────────────
        $paiementsParMois = Paiement::selectRaw('MONTH(date_paiement) as mois, YEAR(date_paiement) as annee, SUM(montant) as total')
            ->where('date_paiement', '>=', now()->subMonths(12))
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get()
            ->map(fn($p) => [
                'label' => \Carbon\Carbon::createFromDate($p->annee, $p->mois, 1)->translatedFormat('M Y'),
                'total' => $p->total,
            ]);

        // ── Stats par classe ──────────────────────────────────────────
        $statsParClasse = $classes->map(function ($classe) use ($eleves) {
            $elevesClasse = $eleves->where('classe_id', $classe->id);
            $frais = $classe->fraisScolaire->montant ?? 0;

            $aJour    = $elevesClasse->filter(fn($e) => $e->paiements->sum('montant') >= $frais)->count();
            $enRetard = $elevesClasse->filter(fn($e) => $e->paiements->sum('montant') < $frais)->count();

            return [
                'classe'   => $classe->nom,
                'aJour'    => $aJour,
                'enRetard' => $enRetard,
                'total'    => $elevesClasse->count(),
            ];
        });

        // ── Élèves en retard depuis plus de 30 jours ──────────────────
        $elevesEnRetard = $eleves->filter(function ($eleve) {
            $frais      = $eleve->classe->fraisScolaire->montant ?? 0;
            $totalPaye  = $eleve->paiements->sum('montant');
            $solde      = $frais - $totalPaye;
            $dernierPaiement = $eleve->paiements->max('date_paiement');

            return $solde > 0 && (
                is_null($dernierPaiement) ||
                \Carbon\Carbon::parse($dernierPaiement)->diffInDays(now()) > 30
            );
        })->map(fn($e) => [
            'nom'            => $e->nom . ' ' . $e->prenom,
            'classe'         => $e->classe->nom,
            'solde'          => ($e->classe->fraisScolaire->montant ?? 0) - $e->paiements->sum('montant'),
            'dernierPaiement' => $e->paiements->max('date_paiement') ?? 'Aucun',
        ])->values();

        return view('dashboard', compact(
            'anneeScolaire',
            'totalEleves',
            'nouveauxCeMois',
            'totalEncaisse',
            'todayEncaisse',
            'totalAttendu',
            'totalRestant',
            'tauxRecouvrement',
            'paiementsParMois',
            'statsParClasse',
            'elevesEnRetard'
        ));
    }
}
