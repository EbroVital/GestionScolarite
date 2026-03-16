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
            'est_active' => false,
        ]);

        anneeScolaire::create([
            'libelle' => '2025-2026',
            'est_active' => true,
        ]);

    }
}
