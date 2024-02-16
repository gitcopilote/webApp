<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\User;

use App\Models\Transaction;



use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $stocks = Transaction::all();

        // Récupérer tous les stocks avec maintainerName, action et quantityOutgoing non vides
        // $stocks = Stock::whereNotNull('maintainerName')
        //     ->whereNotNull('action')
        //     ->whereNotNull('quantityOutgoing')
        //     ->get();
        return view('transaction.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //

        // Récupérer tous les produits disponibles
        //  $stocks = Stock::all();


        // Récupérer tous les produits disponibles
        $stocks = Stock::distinct()->pluck('product');

        // Récupérer tous les utilisateurs disponibles
        $users = User::all();


        // dd($productQuantity);

        // Retourner la vue avec les stocks
        return view('transaction.create', compact('stocks', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */






    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'nom' => ['required'],
            'Produit' => ['required'],
            'Quantité' => ['required', 'numeric', 'min:1'],
            'transaction' => ['required', Rule::in(['Dépot', 'Retrait'])], // Assurez-vous que la transaction est soit 'Dépot' soit 'Retrait'
        ]);

        // Récupérer le produit
        $product = Stock::where('product', $request->Produit)->first();

        // Vérifier si le produit existe
        if (!$product) {
            return redirect()->back()->with('error', 'Produit introuvable.');
        }

        // Vérifier si la quantité demandée est valide en fonction du type de transaction
        if ($request->transaction == 'Dépot') {
            if (($product->quantityRemaining + $request->Quantité) > $product->quantity) {
                return redirect()->back()->with('error', 'Transaction impossible. La quantité demandée dépasse la quantité disponible.');
            }
        } else {
            if (($product->quantityRemaining - $request->Quantité) < 0) {
                return redirect()->back()->with('error', 'Transaction impossible. La quantité demandée dépasse la quantité disponible.');
            }
        }

        // Utilisation de transactions de base de données pour garantir l'atomicité des opérations
        try {
            DB::beginTransaction();

            // Mettre à jour la quantité restante du produit
            if ($request->transaction == 'Dépot') {
                $product->quantityRemaining += $request->Quantité;
            } else {
                $product->quantityRemaining -= $request->Quantité;
            }
            $product->save();

            // Créer une nouvelle entrée dans la table Stock pour enregistrer la transaction
            Transaction::create([
                'maintainerName' => $request->nom,
                'product' => $request->Produit,
                'quantityOutgoing' => $request->Quantité,
                'quantity' => $product->quantity,
                'quantityRemaining' => $product->quantityRemaining,
                'action' => $request->transaction,
            ]);

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Enregistrement effectué avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de la transaction.');
        }
    }




    // public function store(Request $request)
    // {
    //     // Valider les données du formulaire
    //     $request->validate([
    //         'nom' => ['required'],
    //         'Produit' => ['required'],
    //         'Quantité' => ['required', 'numeric', 'min:1'],
    //         'transaction' => ['required', Rule::in(['Dépot', 'Retrait'])], // Assurez-vous que la transaction est soit 'Dépot' soit 'Retrait'
    //     ]);

    //     // Récupérer le produit
    //     $product = Stock::where('product', $request->Produit)->first();

    //     // Vérifier si le produit existe
    //     if (!$product) {
    //         return redirect()->back()->with('error', 'Produit introuvable.');
    //     }




    //     $newQuantityRemaining = 0;


    //     while ($product->quantityRemaining > $request->Quantité) {

    //         $newQuantityRemaining = $product->quantityRemaining - $request->Quantité;

    //         // dd($newQuantityRemaining .' '.$product->quantityRemaining. ' '.$request->Quantité);
    //         // $product->update(['quantityRemaining' => $newQuantityRemaining]);



    //         Stock::create([
    //             'maintainerName' => $request->nom,
    //             'product' => $request->Produit,
    //             'quantityOutgoing' => $request->Quantité,
    //             'quantity' => $product->quantity,
    //              'quantityRemaining' =>  $newQuantityRemaining,
    //             'action' => $request->transaction,
    //         ]);
    //         return redirect()->route('transactions.index')->with('success', 'Enregistrement effectué avec succès.');
    //         break;
    //     }
    // }





















    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $transaction = Transaction::findOrFail($id);
        return view('transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //

    //     $transaction = Transaction::findOrFail($id);
    //     return view('transaction.edit', compact('transaction'));
    // }


    public function edit(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        $stocks = Stock::distinct()->pluck('product');

        // Récupérer tous les utilisateurs disponibles
        $users = User::all();


        return view('transaction.edit', compact('transaction', 'stocks', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //

    //     dd($request);

    //     $request->validate([
    //         'nom' => ['required'],
    //         'Produit' => ['required'],
    //         'Quantité' => ['required', 'numeric', 'min:1'],
    //         'transaction' => ['required', Rule::in(['Dépot', 'Retrait'])], // Assurez-vous que la transaction est soit 'Dépot' soit 'Retrait'
    //     ]);

    //     $product = Stock::where('product', $request->Produit)->first();

    //      // Vérifier si le produit existe
    //      if (!$product) {
    //         return redirect()->back()->with('error', 'Produit introuvable.');
    //     }

    //     // Vérifier si la quantité demandée est valide en fonction du type de transaction
    //     if ($request->transaction == 'Dépot') {
    //         if (($product->quantityRemaining + $request->Quantité) > $product->quantity) {
    //             return redirect()->back()->with('error', 'Transaction impossible. La quantité demandée dépasse la quantité disponible.');
    //         }
    //     } else {
    //         if (($product->quantityRemaining - $request->Quantité) < 0) {
    //             return redirect()->back()->with('error', 'Transaction impossible. La quantité demandée dépasse la quantité disponible.');
    //         }
    //     }
    //     $result = 0;

    //     if ($request->transaction == 'Dépot') {
    //         $product->quantityRemaining += $request->Quantité;
    //         $result =   $product->quantityRemaining + $request->Quantité;
    //     } else {
    //         $product->quantityRemaining -= $request->Quantité;
    //         $result =   $product->quantityRemaining - $request->Quantité;
    //     }


    //     // dd( $result);
    //     // $product->save();



    //     // Transaction::where('id', $id)->update([
    //     //     'maintainerName' => $request->nom,
    //     //     'product' => $request->Produit,
    //     //     // 'quantity' => $request->Quantité,
    //     //     'quantityOutgoing' => $request->Quantité,
    //     //     'action' => $request->transaction,

    //     //     'quantityRemaining' => $request->quantityRemaining,


    //     // ]);


    //     return redirect()->route('transactions.index')->with('success', 'modifier avec succès.');
    // }



    public function update(Request $request, string $id)

    {
        // Valider les données du formulaire
        $request->validate([
            'nom' => ['required'],
            'Produit' => ['required'],
            'Quantité' => ['required', 'numeric', 'min:1'],
            'transaction' => ['required', Rule::in(['Dépot', 'Retrait'])], // Assurez-vous que la transaction est soit 'Dépot' soit 'Retrait'
        ]);

        // Récupérer le produit
        $product = Stock::where('product', $request->Produit)->first();


        // Vérifier si le produit existe
        if (!$product) {
            return redirect()->back()->with('error', 'Produit introuvable.');
        }

        // Vérifier si la quantité demandée est valide en fonction du type de transaction
        if ($request->transaction == 'Dépot') {


           // dd($product->quantityRemaining .' ' .$request->Quantité);
            if (($product->quantityRemaining + $request->Quantité) > $product->quantity) {
                return redirect()->back()->with('error', 'Transaction impossible. La quantité demandée dépasse la quantité disponible.');
            }
        } else {
            if (($product->quantityRemaining - $request->Quantité) < 0) {
                return redirect()->back()->with('error', 'Transaction impossible. La quantité demandée dépasse la quantité disponible.');
            }
        }

        // Utilisation de transactions de base de données pour garantir l'atomicité des opérations
        try {
            DB::beginTransaction();

            // Mettre à jour la quantité restante du produit
            if ($request->transaction == 'Dépot') {
                $product->quantityRemaining += $request->Quantité;
            } else {
                $product->quantityRemaining -= $request->Quantité;
            }
            $product->save();


            echo($product->quantityRemaining);
            // dd($transactionResultat);


            Transaction::where('id', $id)->update([
                'maintainerName' => $request->nom,
                'product' => $request->Produit,
                'quantityOutgoing' => $request->Quantité,
                'quantity' => $product->quantity,
                'quantityRemaining' => $product->quantityRemaining,
                'action' => $request->transaction,
            ]);

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Enregistrement effectué avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de la transaction.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $stock = Transaction::findOrFail($id);
        $stock->delete();

        return redirect()->route('transactions.index')->with('success', 'suprimer avec succès.');
    }
}
