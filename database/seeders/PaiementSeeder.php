<?php

namespace Database\Seeders;

use App\Models\Eleve;
use App\Models\Paiement;
use App\Models\Recu;
use App\Models\TypePaiement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eleves = Eleve::with('classe.fraisScolaire')->get();
        $typesPaiement = TypePaiement::all();
        $compteurRecu = 1;

        foreach ($eleves as $eleve) {

            $fraisTotal = $eleve->classe->fraisScolaire->montant;

            // Certains élèves ont tout payé, d'autres partiellement
            $statutPaiement = rand(1, 10);

            if ($statutPaiement <= 3) {
                // 30% ont tout payé en une fois
                $this->creerPaiement($eleve, $fraisTotal, $typesPaiement, $compteurRecu);
                $compteurRecu++;
            } elseif ($statutPaiement <= 6) {
                // 30% ont payé en 2 fois
                $premiere = round($fraisTotal * 0.6);
                $deuxieme = $fraisTotal - $premiere;

                $this->creerPaiement($eleve, $premiere, $typesPaiement, $compteurRecu, now()->subDays(rand(30, 90)));
                $compteurRecu++;

                $this->creerPaiement($eleve, $deuxieme, $typesPaiement, $compteurRecu, now()->subDays(rand(1, 29)));
                $compteurRecu++;
            } elseif ($statutPaiement <= 8) {
                // 20% ont payé en 3 fois
                $premiere = round($fraisTotal * 0.4);
                $deuxieme = round($fraisTotal * 0.3);
                $troisieme = $fraisTotal - $premiere - $deuxieme;

                $this->creerPaiement($eleve, $premiere, $typesPaiement, $compteurRecu, now()->subDays(rand(60, 120)));
                $compteurRecu++;

                $this->creerPaiement($eleve, $deuxieme, $typesPaiement, $compteurRecu, now()->subDays(rand(30, 59)));
                $compteurRecu++;

                $this->creerPaiement($eleve, $troisieme, $typesPaiement, $compteurRecu, now()->subDays(rand(1, 29)));
                $compteurRecu++;
            } else {
                // 20% ont payé partiellement (50-80%)
                $montant = round($fraisTotal * (rand(50, 80) / 100));
                $this->creerPaiement($eleve, $montant, $typesPaiement, $compteurRecu);
                $compteurRecu++;
            }

        }

    }

    private function creerPaiement($eleve, $montant, $typesPaiement, $compteurRecu, $date = null)
    {
        $typePaiement = $typesPaiement->random();
        $datePaiement = $date ?? now()->subDays(rand(0, 30));

        $paiement = Paiement::create([
            'eleve_id' => $eleve->id,
            'type_paiement_id' => $typePaiement->id,
            'montant' => $montant,
            'date_paiement' => $datePaiement,
            'observation' => rand(1, 10) > 7 ? 'Paiement ' . ['tranche 1', 'tranche 2', 'tranche 3'][rand(0, 2)] : null,
            'reference_transaction' => $typePaiement->libelle === 'Mobile Money' ? 'TXN' . rand(100000, 999999) : null,
        ]);

        Recu::create([
            'paiement_id' => $paiement->id,
            'numero_recu' => sprintf("REC-%s-%05d", date('Y'), $compteurRecu),
            'montant' => $montant,
            'date_emission' => $datePaiement,
        ]);
    }
}
