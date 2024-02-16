@extends('layouts.app')

@section('content')
    <h1 class="text-3xl text-black-500 mb-3 mt-10">Titre de la taches</h1>
    <div>
        <p>
            <!-- Afficher le nom de la tâche -->
        <h1>nom de la tache: {{ $history->name }}</h1>
        <!-- Afficher d'autres informations de la tâche -->
        <p>nom du maintenancier: {{ $history->user }}</p>
        <p>Description: {{ $history->description }}</p>
        <p>Date de début: {{ $history->start_date }}</p>
        <p>Date d'échéance: {{ $history->due_date }}</p>
        <p>Lieu de maintenance: {{ $history->place }}</p>
        <p>fin de maintenance: {{ $history->updated_at }}</p>
        <p>status: {{ $history->status }}</p>
        {{-- <!-- Afficher le nom de l'utilisateur créateur -->
        <p>Créé par: {{ $history->users->name }}</p> --}}
        <div class="mt-3">
        </div>

        <a href="{{ route('task.alltasks') }}"
            class="inline-flex items-center mt-10 px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
            Retour
        </a>

    </div>
@endsection
