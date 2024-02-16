<?php

// Fichier UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $administrateur = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $magasinier = User::create([
            'name' => 'mag',
            'email' => 'mag@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $maintenancier = User::create([
            'name' => 'main',
            'email' => 'main@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $administrateur->roles()->attach([1]); // L'ID du rôle administrateur
        $magasinier->roles()->attach([2]); // L'ID du rôle magasinier
        $maintenancier->roles()->attach([3]); // L'ID du rôle maintenancier
    }
}
