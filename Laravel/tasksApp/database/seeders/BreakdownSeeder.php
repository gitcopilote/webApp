<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Breakdown;
class BreakdownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Breakdown::create([
            'name' => 'Terminaux ',
        ]);

        Breakdown::create([
            'name' => 'Logiciel',
        ]);

        Breakdown::create([
            'name' => 'Chaud et Froid',
        ]);

        Breakdown::create([
            'name' => 'Energie',
        ]);
        Breakdown::create([
            'name' => 'Transmission',
        ]);
        Breakdown::create([
            'name' => 'Radio',
        ]);

    }
}
