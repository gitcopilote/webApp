<?php

// Fichier RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'administrateur']);
        Role::create(['name' => 'magasinier']);
        Role::create(['name' => 'maintenancier']);
    }
}

