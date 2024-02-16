@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-semibold mb-6">Modifier stock</h1>
         <form action="{{ route('transactions.update', $transaction->id) }}"  method="POST">

        <form>
            @csrf



            <div class="mb-6">
                <label for="nom" class="block mb-2 text-sm font-medium text-gray-700">Nom du maintenancier</label>
                <select name="nom" id="nom"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('nom') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                    <option>{{ $transaction->maintainerName }}</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->name }}" {{ old('nom') == $user->name ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('nom')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                        {{ $message }} </p>
                @enderror
            </div>


            <div class="mb-6">
                <label for="Produit" class="block mb-2 text-sm font-medium text-gray-700">Produit</label>
                <select name="Produit" id="Produit"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('Produit') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                    <option>{{$transaction->product}}</option>
                    @foreach ($stocks as $stock)
                        <option value="{{ $stock }}" {{ old('Produit') == $stock ? 'selected' : '' }}>
                            {{ $stock }}
                        </option>
                    @endforeach
                </select>
                @error('Produit')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                        {{ $message }} </p>
                @enderror
            </div>






            <div class="mb-6">
                <label for="transaction" class="block mb-2 text-sm font-medium text-gray-700">Transaction</label>
                <select name="transaction" id="transaction"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('transaction') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                    <option>{{$transaction->action}}</option>
                    <option>Dépot</option>
                    <option>Retrait</option>
                </select>
                @error('transaction')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                        {{ $message }} </p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="Quantité" class="block text-sm font-medium text-gray-700 mb-2">Montant de transaction</label>
                <input  type="number"  value="{{ old('Quantité') ?? $transaction->quantityOutgoing}}"name="Quantité" id="Quantité" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                   @error('Quantité') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" >
                @error('Quantité')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Modifier</button>
        </form>
    </div>
@endsection



















