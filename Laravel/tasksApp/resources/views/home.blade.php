@extends('layouts.app')

@section('content')
    <h1 class="text-3xl text-black-500 mb-3 mt-10">Tableau de bord</h1>

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




    <div class="flex flex-row  items-center ">
        <ul class="flex flex-row justify-between items-center mb-3 md:mb-0">

            @Can('maintenancier')
                <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('task.MyTask') }}" class="hover:text-gray-400">Mes
                        tâches(6)</a></li>
            @endcan

            @Can('maintenancier')
                <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('histories.historyIndex') }}"
                        class="hover:text-gray-400">Historique des taches</a></li>
            @endcan

            @can('administrateur')
                <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('histories.historyIndex') }}"
                        class="hover:text-gray-400">Historique des taches</a></li>
            @endcan


            @can('maintenancier')
                <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('task.index') }}" class="hover:text-gray-400">Mes taches
                        creer</a></li>
            @endcan

            @can('administrateur')
                <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('task.index') }}" class="hover:text-gray-400">Mes taches
                        creer</a></li>
            @endcan



            @Can('administrateur')
                <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('admin.users.index') }}" class="hover:text-gray-400">Gestion
                        des users</a></li>
            @endcan

            @Can('administrateur')
                <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('task.create') }}" class="hover:text-gray-400">Créer des
                        tâches</a></li>
            @endcan


            @Can('maintenancier')
                <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('task.create') }}" class="hover:text-gray-400">Créer des
                        tâches</a></li>
            @endcan



            {{-- @Can('admin_main')
            <li class="md:mr-5 py-2 md:py-0"><a href="#" class="hover:text-gray-400">Créer des tâches</a></li>
            @endcan --}}





            @Can('administrateur')
                <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('task.alltasks') }}" class="hover:text-gray-400">Liste des
                        tâches</a>
                </li>
            @endcan


            @Can('administrateur')
                <li class="md:mr-5 py-2 md:py-0"><a href=" {{ route('stocks.index') }}" class="hover:text-gray-400">gestion de stocks</a></li>
            @endcan

            @Can('administrateur')
                <li class="md:mr-5 py-2 md:py-0"><a href=" {{ route('transactions.index') }}" class="hover:text-gray-400">stock transaction</a></li>
            @endcan


            {{-- @Can('main_maga')
            <li class="md:mr-5 py-2 md:py-0"><a href="#" class="hover:text-gray-400">gestion de stocks</a></li>
            @endcan  --}}


            @Can('magasinier')
                <li class="md:mr-5 py-2 md:py-0"><a href="#" class="hover:text-gray-400">gestion de stocks</a></li>
            @endcan




            <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('editedPassword') }}" class="hover:text-gray-400">modifier m
                    de passe</a></li>



            <li class="md:mr-5 py-2 md:py-0"><a href="{{ route('edited') }}" class="hover:text-gray-400">modifier info
                    p</a></li>



        </ul>
    </div>
@endsection
