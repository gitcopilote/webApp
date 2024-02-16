@extends('layouts.app')

@section('content')

<h1 class="text-3xl text-black-500 mb-3 mt-10">Editer la tache</h1>

<div class="bg-white shadow-lg px-4 py-6 rounded-md">
    <form method="POST" action="{{route('task.updated',['task' => $task->id])}}">
        @csrf



        {{-- <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-700 ">Nom de la panne</label>
            <input type="text" value="{{ old('name') ?? $task->name }}" name="name" id="name" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="Titre de la tâche">
            @error('name')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div> --}}




        <div class="mb-6">
            <label for="breakdown" class="block mb-2 text-sm font-medium text-gray-700">Nom de la panne</label>
            <select name="breakdown" id="breakdown" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('breakdown') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                <option >{{ old('name') ?? $task->name }}</option>
                @foreach ($breakdowns as $breakdown)
                    <option value="{{ $breakdown->name }}" {{ old('breakdown') == $breakdown->name ? 'selected' : '' }}>
                        {{ $breakdown->name }}
                    </option>
                @endforeach
            </select>
            @error('breakdown')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }} </p>
            @enderror
        </div>








        {{-- <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-700 ">Lieu de maintenance</label>
            <input type="text" value="{{ old('place') ?? $task->place }}" name="place" id="place" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('place') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="lieu de maintenance">
            @error('place')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div> --}}







        <div class="mb-6">
            {{-- <label for="location" class="block mb-2 text-sm font-medium text-gray-700 ">Lieu de maintenance  actuel: {{ old('place') ?? $task->place }}"</label> --}}
            <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Lieu de maintenance</label>
            <select name="location" id="location" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('location') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                <option >{{ old('place') ?? $task->place }}</option>
                @foreach ($locations as $locations)
                <option value="{{ $locations->name }}" {{ old('location') == $locations->name ? 'selected' : '' }}>
                    {{ $locations->name }}
                </option>
                @endforeach
            </select>
            @error('location')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }} </p>
            @enderror
        </div>





















        <div class="mb-6">
            <label for="dateStart" class="block mb-2 text-sm font-medium text-gray-700">Date de début</label>
            <input type="date" value="{{ old('start_date') ?? $task->start_date }}" name="start_date" id="dateStart" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
            @error('start_date') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
            @error('start_date')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="dateEnd" class="block mb-2 text-sm font-medium text-gray-700">Date de fin</label>
            <input type="date" value="{{ old('due_date') ?? $task->due_date }}" name="due_date" id="dateEnd" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
            @error('due_date') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
            @error('due_date')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div>

        <label for="status" class="block mb-2 text-sm font-medium text-gray-700">Status</label>
        {{-- <label for="status" class="block mb-2 text-sm font-medium text-gray-700">Status actuel: {{ old('status') ?? $task->status }}  </label> --}}
        <select id="status" type="text" name="status" class="mt-1 mb-3 p-2 border border-gray-300 rounded-md">
            <option>{{ old('status') ?? $task->status }}</option>
            <option value="non traiter">non traiter</option>
            {{-- <option value="partiellement résolue">partiellement resolue</option>
            <option value="totalement résolue">totalement résolue</option> --}}
            <option value="problème persistant">problème persistant</option>
            <option value="transmis">transmis</option>
            <option value="prise en charge">prise en charge</option>
        </select>






        <div class="mb-6">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Votre description</label>
            <textarea id="message" name="description" value="{{ old('description') ?? $task->description }}" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500
             @error('description') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="Laissez un commentaire..."> {{ old('description') ?? $task->description }}</textarea>
            @error('description')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div>
        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Editer</button>
    </form>
</div>

@endsection



