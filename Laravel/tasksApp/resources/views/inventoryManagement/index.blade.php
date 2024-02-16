@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div id="success-notification"
            class="bg-green-100 border mt-2 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                onclick="closeNotification('success-notification')">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>

        <script>
            function closeNotification(notificationId) {
                var notification = document.getElementById(notificationId);
                notification.style.display = 'none';
            }

            // Fermer l'alerte après un certain délai (par exemple, 5000 millisecondes = 5 secondes)
            setTimeout(function() {
                closeNotification('success-notification');
            }, 5000); // Ajoutez cette partie si vous souhaitez que l'alerte se ferme automatiquement après un certain délai
        </script>
    @endif



    @if (session('error'))
        <div id="success-notification" class="bg-red-100 border mt-2 border-red-400 text-red-700 px-4 py-3 rounded relative"
            role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                onclick="closeNotification('success-notification')">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>

        <script>
            function closeNotification(notificationId) {
                var notification = document.getElementById(notificationId);
                notification.style.display = 'none';
            }

            // Fermer l'alerte après un certain délai (par exemple, 5000 millisecondes = 5 secondes)
            setTimeout(function() {
                closeNotification('success-notification');
            }, 5000); // Ajoutez cette partie si vous souhaitez que l'alerte se ferme automatiquement après un certain délai
        </script>
    @endif

    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-semibold mb-6">Liste des stocks</h1>
        <a href="{{ route('stocks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4 inline-block">Ajouter
            un stock</a>


        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-6 py-3 border-b border-gray-300 text-left text-sm font-bold uppercase">id
                        <th class="px-6 py-3 border-b border-gray-300 text-left text-sm font-bold uppercase">Fournisseur
                        </th>
                        <th class="px-6 py-3 border-b border-gray-300 text-left text-sm font-bold uppercase">Produit</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-left text-sm font-bold uppercase">Quantité Totale</th>
                         <th class="px-6 py-3 border-b border-gray-300 text-left text-sm font-bold uppercase">Quantité
                            restant</th>
                        {{-- <th class="px-6 py-3 border-b border-gray-300 text-left text-sm font-bold uppercase">Quantité
                            transaction</th> --}}
                        <th class="px-6 py-3 border-b border-gray-300 text-left text-sm font-bold uppercase">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $stock)
                        <tr class="bg-white border-b white:bg-gray-900 ">
                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $stock->id }}</th>
                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $stock->supplier }}</th>
                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $stock->product }}</th>
                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $stock->quantity }}</th>
                             <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $stock->quantityRemaining }}</th>
                            {{-- <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $stock->quantityOutgoing }}</th> --}}
                            <th class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('stocks.show', $stock->id) }}"
                                    class="font-medium bg-blue-500 px-2 py2 text-white rounded-md hover:underline">Voir</a>
                                <a href="{{ route('stocks.edit', $stock->id) }}"
                                    class="font-medium bg-blue-500 px-2 py2 text-white rounded-md hover:underline">Modifier</a>

                                <a href="{{ route('stocks.destroy', $stock->id) }}"
                                    class="font-medium bg-red-500 px-2 py2 text-white rounded-md  hover:underline">Remove</a>


                                {{-- <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"  class="font-medium bg-red-500 px-2 py2 text-white rounded-md hover:underline"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce stock ?')">Supprimer</button>
                                </form> --}}
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4 inline-block">Retour</a>
    </div>
@endsection
