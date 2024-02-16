@extends('layouts.app')

@section('content')

    <h1 class="text-3xl text-black-500 mb-3 mt-10">Titre de la taches</h1>
    <div>
        <p>
            <!-- Afficher le nom de la tâche -->
        <h1>{{ $task->name }}</h1>

        <!-- Afficher d'autres informations de la tâche -->
        <p>Description: {{ $task->description }}</p>
        <p>Date de début: {{ $task->start_date }}</p>
        <p>Date d'échéance: {{ $task->due_date }}</p>

        <!-- Afficher des informations de l'utilisateur lié à la tâche -->
        {{-- <p>Assigné à: {{ $task->user->name }}</p>
        <p>Email de l'assigné: {{ $task->user->email }}</p> --}}


        <p>Email de l'assigné:</p>
        @if ($task->user)
            <p> {{ $task->user->email }}</p>
        @else
            <p>Aucune adresse email </p>
        @endif


        <p>Assigné à:</p>
        @if ($task->user)
            <p>{{ $task->user->name }}</p>
        @else
            <p>Aucun maintenancier assigné</p>
        @endif

        <!-- Ajoutez d'autres champs de l'utilisateur selon votre modèle User -->

        <p>Lieu: {{ $task->place }}</p>

        <!-- Vous pouvez également utiliser des liens pour naviguer vers d'autres pages ou actions -->
        {{-- <a href="{{ route('user.show', $task->user->id) }}">Voir le profil de l'assigné</a> --}}


        <!-- Afficher le nom de l'utilisateur créateur -->
        <p>Créé par: {{ $task->users->name }}</p>

        <!-- Afficher le nom de l'utilisateur créateur -->
         <p>Status: {{ $task->status }}</p>

        <!-- Afficher des informations supplémentaires de l'utilisateur créateur -->
        <p>Email du créateur: {{ $task->users->email }}</p>

        <p>Signaler le: {{ $task->created_at }}</p>

        <p>modifier le: {{ $task->updated_at }}</p>



        </p>

        <div class="mt-3">

            {{-- @if (isset($task))
        <div class="mt-3">
            <span class="text-gray-500">taches attribuer à
            @if (Auth::user()->id == $task->user_assigned_to)
                vous
            @else
                {{$task->user->name}}
            @endif
        </span>
        </div>
    @endif --}}



            @if (isset($task))
                <div class="mt-3">
                    <span class="text-gray-500">Tâche attribuée à
                        @if (Auth::user()->id == $task->user_assigned_to)
                            vous
                        @elseif(isset($task->user))
                            {{ $task->user->name }} {{-- Accéder au nom de l'utilisateur assigné à la tâche --}}
                        @else
                        @endif
                    </span>
                </div>
            @endif




            @if (isset($task))
                <div class="mt-3">
                    <span class="text-gray-500">Publié par
                        @if (Auth::user()->id == $task->user_created_by)
                            vous
                        @else
                            {{ $task->name }}
                        @endif {{ $task->created_at->diffForHumans() }}
                    </span>
                </div>
            @endif





        </div>

        <a href="{{ route('task.alltasks') }}"
            class="inline-flex items-center mt-10 px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
            Retour
        </a>

    </div>
@endsection
