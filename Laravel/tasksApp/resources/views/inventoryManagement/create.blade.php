@extends('layouts.app')

@section('content')
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
        <h1 class="text-3xl font-semibold mb-6">Ajouter un stock</h1>
        <form action="{{ route('stocks.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="Fournisseur" class="block text-sm font-medium text-gray-700 mb-2">Fournisseur</label>
                <input type="text" value="{{ old('Fournisseur') }}" name="Fournisseur" id="Fournisseur"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('Fournisseur') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror"
                    placeholder="Titre de la tâche">
                @error('Fournisseur')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                        {{ $message }} </p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="Produit" class="block text-sm font-medium text-gray-700 mb-2">Produit</label>
                <input type="text" value="{{ old('Produit') }}" name="Produit" id="Produit"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('Produit') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror"
                    placeholder="Titre de la tâche">
                @error('Produit')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                        {{ $message }} </p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="Quantité" class="block text-sm font-medium text-gray-700 mb-2">Quantité</label>
                <input type="number" value="{{ old('Quantité') }}" name="Quantité" id="Quantité"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('Quantité') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror"
                    placeholder="Titre de la tâche">
                @error('Quantité')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                        {{ $message }} </p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Ajouter</button>
        </form>
    </div>
@endsection
