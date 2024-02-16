<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $stocks = Stock::all();
        $stocks = Stock::whereNotNull('supplier')
            ->whereNotNull('product')
            ->whereNotNull('quantity')
            ->get();
        return view('inventoryManagement.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventoryManagement.create');
    }

    /**
     * Store a newly created resource in storage.
     */


    // public function store(Request $request, Stock $stock)
    // {
    //     $request->validate([
    //         'Fournisseur' => ['required'],
    //         'Produit' => ['required'],
    //         'Quantité' => ['required'],
    //     ]);

    //     Stock::create([
    //         'supplier' =>  $request->Fournisseur,
    //         'product' =>   $request->Produit,
    //         'quantity' =>  $request->Quantité,
    //     ]);

    //     return redirect()->route('stocks.index')->with('success', 'enregistrement effectuer avec succès.');
    // }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'Fournisseur' => ['required'],
    //         'Produit' => ['required'],
    //         'Quantité' => ['required', 'integer', 'min:1'], // Ajoutez des règles de validation supplémentaires si nécessaire
    //     ]);

    //     $existingStock = Stock::where('product', $request->Produit)
    //         ->where('supplier', $request->Fournisseur)
    //         ->first();

    //     if ($existingStock) {
    //         return redirect()->back()->with('error', 'Ce stock existe déjà.');
    //     }

    //     Stock::create([
    //         'supplier' =>  $request->Fournisseur,
    //         'product' =>   $request->Produit,
    //         'quantity' =>  $request->Quantité,
    //         'quantityRemaining' => $request->Quantité,
    //     ]);

    //     return redirect()->route('stocks.index')->with('success', 'Enregistrement effectué avec succès.');
    // }


    public function store(Request $request)
{
    // Validation des données du formulaire
    $request->validate([
        'Fournisseur' => ['required'],
        'Produit' => ['required'],
        'Quantité' => ['required', 'integer', 'min:1'], // Ajoutez des règles de validation supplémentaires si nécessaire
    ]);

    // Recherche d'un stock avec le même produit et fournisseur
    $existingStock = Stock::where('product', $request->Produit)
        ->where('supplier', $request->Fournisseur)
        ->first();

    // Si un stock avec le même produit et fournisseur existe déjà
    if ($existingStock) {
        // Mettre à jour les valeurs quantity et quantityRemaining en ajoutant la nouvelle quantité
        $existingStock->quantity += $request->Quantité;
        $existingStock->quantityRemaining += $request->Quantité;
        $existingStock->save();

        // Redirection avec un message de succès
        return redirect()->route('stocks.index')->with('success', 'Stock mis à jour avec succès.');
    }

    // Création d'un nouveau stock
    Stock::create([
        'supplier' =>  $request->Fournisseur,
        'product' =>   $request->Produit,
        'quantity' =>  $request->Quantité,
        'quantityRemaining' => $request->Quantité, // La quantité restante est initialisée avec la quantité entrée
    ]);

    // Redirection avec un message de succès
    return redirect()->route('stocks.index')->with('success', 'Enregistrement effectué avec succès.');
}





    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stock = Stock::findOrFail($id);
        return view('inventoryManagement.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return view('inventoryManagement.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {

    //     if (!empty($request->AdQuantité)) {
    //         $request->validate([
    //             'Fournisseur' => ['required'],
    //             'Produit' => ['required'],
    //             'Quantité' => ['required'],
    //         ]);


    //         Stock::where('id', $id)->update([
    //             'supplier' => $request->Fournisseur,
    //             'product' => $request->Produit,
    //             'quantity' => $request->AdQuantité,
    //         ]);

    //         return redirect()->route('stocks.index')->with('success', 'modifier avec succès.');
    //     }

    //     $request->validate([
    //         'Fournisseur' => ['required'],
    //         'Produit' => ['required'],
    //         'Quantité' => ['required'],
    //     ]);


    //     Stock::where('id', $id)->update([
    //         'supplier' => $request->Fournisseur,
    //         'product' => $request->Produit,
    //         'quantity' => $request->Quantité,
    //     ]);


    //     return redirect()->route('stocks.index')->with('success', 'modifier avec succès.');
    // }



    public function update(Request $request, $id)
    {
        $request->validate([
            'Fournisseur' => ['required'],
            'Produit' => ['required'],
            'Quantité' => ['required'],
        ]);

        // Récupérer le stock existant
        $stock = Stock::find($id);

        if (!$stock) {
            return redirect()->route('stocks.index')->with('error', 'Stock non trouvé.');
        }

        // Ajouter AdQuantité à la quantité existante
        // $newQuantity = $stock->quantity + $request->AdQuantité;


        if ($request->AdQuantité) {

            // dd('ad');

            $newQuantity = $stock->quantity + $request->AdQuantité;
            // Mettre à jour le stock avec la nouvelle quantité
            $stock->update([
                'supplier' => $request->Fournisseur,
                'product' => $request->Produit,
                'quantity' => $newQuantity,
                'quantityRemaining' =>  $newQuantity
            ]);
        } elseif($request->Quantité) {

            // dd($request->Quantité);

            $stock->update([
                'supplier' => $request->Fournisseur,
                'product' => $request->Produit,
                'quantity' => $request->Quantité,
                'quantityRemaining' => $request->Quantité,
            ]);
        }






        return redirect()->route('stocks.index')->with('success', 'Quantité ajoutée avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'suprimer avec succès.');
    }
}
