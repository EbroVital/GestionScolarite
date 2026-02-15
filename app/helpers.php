<?php

use App\Models\Eleve;
use App\Models\Recu;

        function formater_montant($montant)
        {
            return number_format($montant, 0, ',', ' ') . ' FCFA';
        }


    function annee_scolaire_actuelle()
    {
        $mois = now()->month; // Mois actuel
        $anneeActuelle = now()->year; // Année actuelle

        // Si on est entre septembre et décembre, l'année scolaire commence cette année
        // Si on est entre janvier et août, l'année scolaire a commencé l'année dernière
        if ($mois >= 9) {
            // Septembre à décembre : 2025-2026
            $debut = $anneeActuelle;
            $fin = $anneeActuelle + 1;
        } else {
            // Janvier à août : 2024-2025
            $debut = $anneeActuelle - 1;
            $fin = $anneeActuelle;
        }

        return "{$debut}-{$fin}";
    }


     function genererMatricule()
    {
        $annee = date('Y');
        $dernierEleve = Eleve::whereYear('created_at', $annee)->latest()->first();

        if ($dernierEleve) {
            $dernierNumero = (int) substr($dernierEleve->matricule, -4);
            $nouveauNumero = str_pad($dernierNumero + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nouveauNumero = '0001';
        }

        return "EL{$annee}{$nouveauNumero}";
    }

    function calculer_solde_eleve($eleveId)
    {
        $eleve = Eleve::find($eleveId);
        if (!$eleve) return 0;

        $fraisScolaire = $eleve->classe->fraisScolaire->montant ?? 0;
        $totalPaiements = $eleve->paiements()->sum('montant');

        return $fraisScolaire - $totalPaiements;
    }

    function generer_numero_recu()
    {
        $annee = date('Y');
        $dernier = Recu::latest('id')->first();
        $numero = $dernier ? ($dernier->id + 1) : 1;

        return sprintf("REC-%s-%05d", $annee, $numero);
    }

