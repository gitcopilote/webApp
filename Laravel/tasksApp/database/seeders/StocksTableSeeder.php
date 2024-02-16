<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;

class StocksTableSeeder extends Seeder
{
    public function run()
    {
        // Création de quelques stocks fictifs
        Stock::create([
            'supplier' => 'Fournisseur 1',
            'product' => 'Produit 1',
            'quantity' => 100,
            'quantityRemaining' => 100,
            'quantityOutgoing' => 0,
        ]);

        Stock::create([
            'supplier' => 'Fournisseur 2',
            'product' => 'Produit 2',
            'quantity' => 150,
            'quantityRemaining' => 150,
            'quantityOutgoing' => 0,
        ]);

        Stock::create([
            'supplier' => 'Fournisseur 3',
            'product' => 'Produit 3',
            'quantity' => 200,
            'quantityRemaining' => 200,
            'quantityOutgoing' => 0,
        ]);

        // Vous pouvez ajouter autant de stocks que nécessaire ici
    }
}
