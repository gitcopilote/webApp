<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;  // Assurez-vous que c'est correctement importé
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création d'utilisateurs fictifs dans notre base de données

        $administrateur = User::create([
            'name' => 'kouadio',
            'email' => 'kouadio@gmail.com',
            'password' => Hash::make('password')
        ]);

        $magasinier = User::create([
            'name' => 'kouassi',
            'email' => 'kouassi@gmail.com',
            'password' => Hash::make('password')
        ]);

        $maintenancier = User::create([
            'name' => 'ange',
            'email' => 'ange@gmail.com',
            'password' => Hash::make('password')
        ]);

        // On rattache les rôles créés précédemment aux utilisateurs

        $administrateur->roles()->attach([1,2]);
        $magasinier->roles()->attach([2]);
        $maintenancier->roles()->attach([3]);
    }
}
