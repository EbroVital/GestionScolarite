<?php

namespace Database\Seeders;

use App\Models\fraisScolaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FraisScolaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $frais = [
            ['niveau' => '6ème', 'montant' => 80000],
            ['niveau' => '5ème', 'montant' => 85000],
            ['niveau' => '4ème', 'montant' => 90000],
            ['niveau' => '3ème', 'montant' => 95000],
            ['niveau' => '2nde', 'montant' => 100000],
            ['niveau' => '1ère', 'montant' => 110000],
            ['niveau' => 'Tle', 'montant' => 120000],
        ];

        foreach ($frais as $fraisScolaire) {
            fraisScolaire::create($fraisScolaire);
        }
    }
}
