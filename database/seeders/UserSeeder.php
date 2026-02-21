<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrateur
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@ecole.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Caissiers
        User::create([
            'name' => 'Marie Kouassi',
            'email' => 'caissier1@ecole.com',
            'password' => Hash::make('password'),
            'role' => 'caissier',
        ]);

         User::create([
            'name' => 'Jean Koné',
            'email' => 'caissier2@ecole.com',
            'password' => Hash::make('password'),
            'role' => 'caissier',
        ]);


    }
}
