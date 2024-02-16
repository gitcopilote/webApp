@extends('layouts.app')

@section('content')

<h1 class="text-3xl text-black-500 mb-3 mt-10">Liste des utilisateurs</h1>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    @if(session('success'))
    <div id="success-notification" class="bg-green-100 border mt-2 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="closeNotification('success-notification')">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
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
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nom
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Roles
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="bg-white border-b white:bg-gray-900 ">
                    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
                        @foreach ($user->roles as $role)
                            {{ $role->name }}
                            @if (!$loop->last){{-- Pour éviter la virgule après le dernier rôle --}}
                                ,
                            @endif
                        @endforeach
                    </td>
                    <td class="px-6 py-4">


                        {{-- <form action="{{ route('admin.users.delete', ['user' => $user->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <!-- Ajoutez un bouton de confirmation de suppression si nécessaire -->
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')">Supprimer</button>
                        </form> --}}
                        <a href="{{ route('admin.users.delete', ['user' => $user->id]) }}" class="font-medium bg-red-500 px-2 py2 text-white rounded-md hover:underline">remove</a>
                        <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="font-medium bg-blue-500 px-2 py2 text-white rounded-md hover:underline">Edit role</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<br>
<a href="#" class="font-medium bg-blue-500 px-4 py-2 text-white rounded-md hover:none">Back</a>

@endsection
