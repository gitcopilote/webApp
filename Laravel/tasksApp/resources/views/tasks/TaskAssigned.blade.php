@extends('layouts.app')

@section('content')
    <h1 class="text-3xl text-black-500 mb-3 mt-10">Mes taches</h1>


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




    {{-- @foreach ($tasks as $task)
        <div class="px-2 py-5 shadow-sm hover:shadow-md rounded border mb-5 border-gray-200">
            <h1 class="text-xl font-bold text-black-800">nom de la tache: {{ $task->name }}</h1>
            <p class="text-md text-gray-800">Description: {{ $task->description }}</p>
            <p class="mt-2">Date de debut : {{ $task->start_date }}</p>
            <p class="mt-2">Date d'échéance : {{ $task->due_date }}</p>
            <p class="mt-2 text-red  {{$task->statusColor()}} ">statut: {{ $task->status }}</p>
            <div class="flex-column">

                @if ($task->status == 'En cours')
                    <form action="{{ route('task.maskAsTermined', ['task' => $task->id]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <button class="bg-green-500 px-2 py-1 rounded-md text-white mt-3 font-bold" type="submit">Marquer
                            comme terminé</button>
                    </form>
                @endif

                @if ($task->isActive())
                    <form action="{{ route('task.startTask', ['task' => $task->id]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <button class="bg-green-500 px-2 py-1 rounded-md text-white mt-3 font-bold" type="submit">commencer la tache</button>
                    </form>
                @endif
            </div>


        </div>
    @endforeach --}}


    @foreach ($tasks as $task)
        <div class="px-2 py-5 shadow-sm hover:shadow-md rounded border mb-5 border-gray-200">
            <h1 class="text-xl font-bold text-black-800">nom de la tache: {{ $task->name }}</h1>
            <p class="text-md text-gray-800">Description: {{ $task->description }}</p>
            <p class="mt-2">Date de debut : {{ $task->start_date }}</p>
            <p class="mt-2">Date d'échéance : {{ $task->due_date }}</p>

            {{-- ici doit être dans un bloc en rouge --}}
            <p class="mt-2 text-red  {{ $task->statusColor() }} ">statut: {{ $task->status }}</p>


            <div class="flex-column">


                @if ($task->status == 'En cours')
                    <form action="{{ route('task.maskAsTermined', ['task' => $task->id]) }}" method="POST">
                        @csrf
                        @method('POST')


                        <div class="mb-6">
                            <label for="MaintenanceAssistant"
                                class="block mb-2 text-sm font-medium text-gray-700">Mintenancier assistant</label>
                            <select name="MaintenanceAssistant" id="MaintenanceAssistant"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                               @error('MaintenanceAssistant') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                                <option value="" disabled selected>Choix du maintenancier</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}"
                                        {{ old('MaintenanceAssistant') == $user->name ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('breakdown')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{ $message }} </p>
                            @enderror
                        </div>


                        <div class="mb-6">
                            <label for="resolved" class="block mb-2 text-sm font-medium text-gray-900">Comment avez vous
                                résolue ce problème</label>
                            <textarea id="resolved" value="{{ old('resolved') }}" name="resolved" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500
                            @error('resolved') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror"></textarea>
                            @error('resolved')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{ $message }} </p>
                            @enderror
                        </div>

                        <label for="status" class="block text-sm font-medium text-gray-700">
                            Choisir le statut :
                        </label>
                        <select id="status" name="status" class="mt-1 mb-3 p-2 border border-gray-300 rounded-md">
                            <option value="non traiter">non traiter</option>
                            <option value="partiellement résolue">partiellement resolue</option>
                            <option value="totalement résolue">totalement résolue</option>
                            <option value="problème persistant">problème persistant</option>
                        </select>

                        {{-- Ajouter un champ input caché pour stocker la valeur sélectionnée --}}
                        <input type="hidden" name="selected_status" id="selected_status">

                        <button class="bg-green-500 px-2 py-1 rounded-md text-white font-bold" type="submit"
                            onclick="setSelectedStatus()">soumettre</button>
                    </form>
                @endif
                @if ($task->isActive())
                    <form action="{{ route('task.startTask', ['task' => $task->id]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <button id="taskButton" onchange="setSelectedStatus()"
                            class="bg-green-500 px-2 py-1 rounded-md text-white mt-3 font-bold"
                            onclick="setSelectedStatus()" type="submit">commencer la tache</button>
                    </form>
                @endif

            </div>

            <script>
                // JavaScript pour mettre à jour la valeur du champ caché lorsqu'une option est sélectionnée
                function setSelectedStatus() {
                    var selectedStatus = document.getElementById('status').value;
                    document.getElementById('selected_status').value = selectedStatus;


                    selectedStatusField.value = selectedStatus;

                    // Vérifier si selected_status a une valeur
                    if (selectedStatus) {
                        // Changer le texte du bouton en "Modifier la tâche"
                        taskButton.innerHTML = "Modifier la tâche";
                    } else {
                        // Sinon, remettre le texte du bouton en "Commencer la tâche"
                        taskButton.innerHTML = "Commencer la tâche";
                    }
                }
            </script>
        </div>
    @endforeach


    {{-- <script>
        function hideButton(taskId) {
            // Cacher le bouton une fois qu'il est cliqué
            document.getElementById('submitButton' + taskId).style.display = 'none';
            // Optionnel : Envoyer le formulaire après avoir caché le bouton
            document.getElementById('updateForm' + taskId).submit();
        }
    </script> --}}
@endsection
