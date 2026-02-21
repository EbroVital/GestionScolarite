<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EleveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $noms = [
            ['nom' => 'Kouassi', 'prenom' => 'Aya'],
            ['nom' => 'Koné', 'prenom' => 'Ibrahim'],
            ['nom' => 'Yao', 'prenom' => 'Adjoua'],
            ['nom' => 'Traoré', 'prenom' => 'Mamadou'],
            ['nom' => 'Bamba', 'prenom' => 'Fatou'],
            ['nom' => 'Touré', 'prenom' => 'Moussa'],
            ['nom' => 'Koffi', 'prenom' => 'Akissi'],
            ['nom' => 'Ouattara', 'prenom' => 'Seydou'],
            ['nom' => 'N\'Guessan', 'prenom' => 'Affoué'],
            ['nom' => 'Diallo', 'prenom' => 'Alpha'],
            ['nom' => 'Sylla', 'prenom' => 'Mariam'],
            ['nom' => 'Camara', 'prenom' => 'Lassina'],
            ['nom' => 'Dosso', 'prenom' => 'Aminata'],
            ['nom' => 'Sangaré', 'prenom' => 'Yacouba'],
            ['nom' => 'Konan', 'prenom' => 'N\'Dri'],
            ['nom' => 'Bakayoko', 'prenom' => 'Karidja'],
            ['nom' => 'Diabaté', 'prenom' => 'Adama'],
            ['nom' => 'Coulibaly', 'prenom' => 'Tenin'],
            ['nom' => 'Soro', 'prenom' => 'Lacina'],
            ['nom' => 'Dao', 'prenom' => 'Hawa'],
        ];

        $adresses = [
            'Cocody, Angré 8ème tranche',
            'Yopougon, Sicogi',
            'Marcory, Zone 4',
            'Abobo, Avocatier',
            'Plateau, Commerce',
            'Treichville, Zone 3',
            'Port-Bouët, Vridi',
            'Koumassi, Remblais',
        ];

        $classes = Classe::all();
        $compteur = 1;

        foreach ($classes as $classe) {

            // 8 à 12 élèves par classe
            $nombreEleves = rand(8, 12);

            for ($i = 0; $i < $nombreEleves; $i++) {
                if ($compteur > count($noms)) {
                    $compteur = 1; // Réinitialiser si on manque de noms
                }


                $nom = $noms[$compteur - 1];
                $sexe = in_array($nom['prenom'], ['Aya', 'Adjoua', 'Fatou', 'Akissi', 'Affoué', 'Mariam', 'Aminata', 'Karidja', 'Tenin', 'Hawa']) ? 'F' : 'M';

                Eleve::create([
                    'matricule' => 'EL' . date('Y') . str_pad($compteur, 4, '0', STR_PAD_LEFT),
                    'nom' => $nom['nom'],
                    'prenom' => $nom['prenom'],
                    'sexe' => $sexe,
                    'date_naissance' => now()->subYears(rand(10, 18))->subDays(rand(0, 365)),
                    'telephone_parent' => '07' . rand(10, 99) . rand(10, 99) . rand(10, 99) . rand(10, 99),
                    'adresse' => $adresses[array_rand($adresses)],
                    'classe_id' => $classe->id,
                ]);

                $compteur++;

            }

        }


    }
}
