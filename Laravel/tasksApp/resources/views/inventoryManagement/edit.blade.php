@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-semibold mb-6">Modifier stock</h1>
    <form action="{{ route('stocks.update', $stock->id) }}"  method="POST">
        @csrf

        <div class="mb-4">
            <label for="Fournisseur" class="block text-sm font-medium text-gray-700 mb-2">Fournisseur</label>
            <input type="text"  value="{{old('Fournisseur') ?? $stock->supplier }}" name="Fournisseur" id="Fournisseur" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('Fournisseur') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" >
            @error('Fournisseur')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="Produit" class="block text-sm font-medium text-gray-700 mb-2">Produit</label>
            <input type="text" value="{{ old('Produit') ?? $stock->product }}" name="Produit" id="Produit" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('Produit') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
            @error('Produit')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="Quantité" class="block text-sm font-medium text-gray-700 mb-2">Stock total disponible</label>
            <input type="number"  value="{{ old('Quantité') ?? $stock->quantity}}"name="Quantité" id="Quantité" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('Quantité') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" >
            @error('Quantité')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div>


        <div class="mb-4">
            <label for="AdQuantité" class="block text-sm font-medium text-gray-700 mb-2">Ajouter une noevelle quantité au stock disponible</label>
            <input type="number"  value="{{ old('AdQuantité')}}"name="AdQuantité" id="AdQuantité" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" >
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Modifier</button>
    </form>
</div>
@endsection
