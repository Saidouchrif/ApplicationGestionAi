<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Adherent;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un administrateur par défaut
        Adherent::create([
            'nom' => 'Administrateur',
            'email' => 'admin@bibreaders.test',
            'password_hash' => Hash::make('admin123'),
            'role' => 'admin',
            'date_inscription' => now(),
        ]);

        $this->command->info('Administrateur créé avec succès !');
        $this->command->info('Email: admin@bibreaders.test');
        $this->command->info('Mot de passe: admin123');
    }
}
