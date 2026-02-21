<?php

namespace Database\Seeders;

use App\Models\anneeScolaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnneeScolaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        anneeScolaire::create([
            'libelle' => '2024-2025',
            'date_debut' => '2024-09-01',
            'date_fin' => '2025-08-31',
            'est_active' => true,
        ]);

        AnneeScolaire::create([
            'libelle' => '2023-2024',
            'date_debut' => '2023-09-01',
            'date_fin' => '2024-08-31',
            'est_active' => false,
        ]);

    }
}
