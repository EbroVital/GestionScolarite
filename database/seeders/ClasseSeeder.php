<?php

namespace Database\Seeders;

use App\Models\anneeScolaire;
use App\Models\Classe;
use App\Models\fraisScolaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anneeScolaire = anneeScolaire::where('libelle', '2024-2025')->first();

        $classes = [
            ['nom' => '6ème A', 'niveau' => '6ème'],
            ['nom' => '6ème B', 'niveau' => '6ème'],
            ['nom' => '5ème A', 'niveau' => '5ème'],
            ['nom' => '5ème B', 'niveau' => '5ème'],
            ['nom' => '4ème A', 'niveau' => '4ème'],
            ['nom' => '4ème B', 'niveau' => '4ème'],
            ['nom' => '3ème A', 'niveau' => '3ème'],
            ['nom' => '3ème B', 'niveau' => '3ème'],
            ['nom' => '2nde A', 'niveau' => '2nde'],
            ['nom' => '2nde B', 'niveau' => '2nde'],
            ['nom' => '1ère A', 'niveau' => '1ère'],
            ['nom' => 'Tle A', 'niveau' => 'Tle'],
        ];

        foreach ($classes as $classeData) {
            $frais = fraisScolaire::where('niveau', $classeData['niveau'])->first();

            Classe::create([
                'nom' => $classeData['nom'],
                'niveau' => $classeData['niveau'],
                'annee_scolaire_id' => $anneeScolaire->id,
                'frais_scolaire_id' => $frais->id,
            ]);
        }

    }
}
