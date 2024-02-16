
@extends('layouts.app')

@section('content')

<h1 class="text-3xl text-black-500 mb-3 mt-10">Toute les tâche en cours</h1>

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


@if(session('error'))
    <div id="success-notification" class="bg-red-100 border mt-2 border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="closeNotification('success-notification')">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
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
                    tache
                </th>

                <th scope="col" class="px-6 py-3">
                    description
                </th>
                <th scope="col" class="px-6 py-3">
                    Nom du maintenancier
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>

        @foreach($tasks as $task)
            <tr class="bg-white border-b white:bg-gray-900 ">
                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                {{ $task->name}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                {{ $task->description}}
                </th>


                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                    @if ($task->user)
                        {{ $task->user->name }}
                    @else
                        Aucun maintenancier assigné
                    @endif
                </th>
                {{-- <td class="px-6 py-4">
                    <a href="#" class="font-medium bg-blue-500 px-2 py2 text-white rounded-md hover:underline">{{ $task->status}}</a>
                </td> --}}


                @canany(['maintenancier', 'administrateur'])
                <td class="px-6 py-4">
                    <a href="#" class="font-medium bg-blue-500 px-2 py2 text-white rounded-md hover:underline">{{ $task->status }}</a>
                </td>
                @endcanany

                <td class="px-6 py-4">


                    {{-- @if ($task->status != 'nouveau')
                    <a href="{{ route('task.assignedView',['task' => $task->id ]) }}" class="font-medium bg-green-500 px-2 py2 text-white rounded-md hover:underline">Attribuer</a>
                    @endif --}}

                    @Can('administrateur')
                    <a href="{{ route('task.assignedViews',['task' => $task->id ]) }}" class="font-medium bg-green-500 px-2 py2 text-white rounded-md hover:underline">Attribuer</a>
                     @endcan

                       {{-- si status est différent de nouveu tout les maintenancier ne peuve supprimé cette tache sauf l'administrateur --}}
                    @Can('administrateur')
                    <a href="{{ route('task.unassigned',['task' => $task->id ]) }}" class="font-medium bg-red-500 px-2 py2 text-white rounded-md hover:underline">desassigné</a>
                     @endcan


                     {{-- @Can('administrateur')
                     <a href="{{ route('task.unassigned',['task' => $task->id ]) }}" class="font-medium bg-red-500 px-2 py2 text-white rounded-md hover:underline">desassigné</a>
                      @endcan --}}

                    {{-- <a href="{{ route('task.removed',['task' => $task->id ]) }}" class="font-medium bg-red-500 px-2 py2 text-white rounded-md  hover:underline">Remove</a> --}}



                    @if ($task->status != 'nouveau')
                    @can('administrateur')
                    <a href="{{ route('task.removed',['task' => $task->id ]) }}" class="font-medium bg-red-500 px-2 py2 text-white rounded-md  hover:underline">Remove</a>
                    @endcan
                    @else
                    <a href="{{ route('task.removed',['task' => $task->id ]) }}" class="font-medium bg-red-500 px-2 py2 text-white rounded-md  hover:underline">Remove</a>
                    @endif




                    <a href="{{ route('task.edit',['task' => $task->id ]) }}" class="font-medium bg-blue-500 px-2 py2 text-white rounded-md hover:underline">Edit</a>
                    <a href="{{ route('task.show',['task' => $task->id ]) }}" class="font-medium bg-yellow-500 px-2 py2 text-white rounded-md hover:underline">voir</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<br>
<a href="#" class="font-medium bg-blue-500 px-4 py-2 text-white rounded-md hover:none">Back</a>

@endsection
