@extends('layouts.app')

@section('content')
    <h1 class="text-3xl text-black-500 mb-3 mt-10">Historique des taches</h1>


        @if ($histories->isEmpty())
            <p>Aucun historique disponible.</p>
            <br>
            <a href="#" class="font-medium bg-blue-500 px-4 py-2 text-white rounded-md hover:none">Back</a>
        @else
        @if (session('error'))
            <div id="success-notification"
                class="bg-red-100 border mt-2 border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
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

            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            tache
                        </th>

                        {{-- <th scope="col" class="px-6 py-3">
                        description
                    </th> --}}

                        <th> lieu de maintenance</th>

                        <th scope="col" class="px-6 py-3">
                            Nom du maintenancier
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            date de debut
                        </th>
                        <th scope="col" class="px-6 py-3">
                            date d'échance
                        </th>
                        <th scope="col" class="px-6 py-3">
                            date de fin de maintenance
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($histories as $history)
                        <tr class="bg-white border-b white:bg-gray-900 ">
                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $history->name }}
                            </th>
                            {{-- <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                            {{ $history->description }}
                        </th> --}}

                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $history->place }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $history->user }}
                            </th>
                            <td class="px-6 py-4">
                                <a href="#"
                                    class="font-medium bg-blue-500 px-2 py2 text-white rounded-md hover:underline">{{ $history->status }}</a>
                            </td>

                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $history->start_date }}
                            </th>

                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $history->due_date }}
                            </th>

                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                                {{ $history->updated_at }}
                            </th>




                            <td class="px-6 py-4">
                                {{-- <a href="{{ route('task.edit',['task' =>$history->id ]) }}" class="font-medium bg-blue-500 px-2 py2 text-white rounded-md hover:underline">Edit</a> --}}
                                <a href="{{ route('histories.show', ['history' => $history->id]) }}"
                                    class="font-medium bg-yellow-500 px-2 py2 text-white rounded-md hover:underline">voir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <a href="#" class="font-medium bg-blue-500 px-4 py-2 text-white rounded-md hover:none">Back</a>
            <a href="{{ route('histories.balanceSheet') }}"
            class="font-medium bg-blue-500 px-4 py-2 text-white rounded-md hover:none">Télécharger</a>
            <a href="{{ route('histories.destroyHistory') }}"
            class="font-medium bg-blue-500 px-4 py-2 text-white rounded-md hover:none">Supprimer</a>
        </div>
       @endif
    </div>
    <br>

@endsection
