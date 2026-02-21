<?php

namespace Database\Seeders;

use App\Models\TypePaiement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypePaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Espèces',
            'Mobile Money',
            'Virement bancaire',
            'Chèque',
            'Carte bancaire',
        ];

        foreach ($types as $type) {
            TypePaiement::create(['libelle' => $type]);
        }
    }
}
