@extends('layouts.app')

@section('content')

<h1 class="text-3xl text-black-500 mb-3 mt-10">Creer une nouvelle taches</h1>

<div class="bg-white shadow-lg px-4 py-6 rounded-md">
    <form method="POST" action="{{route('task.store')}}">
        @csrf




        <div class="mb-6">
            <label for="breakdown" class="block mb-2 text-sm font-medium text-gray-700">Nom de la panne</label>
            <select name="breakdown" id="breakdown" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('breakdown') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                <option value="" disabled selected>Choisissez une panne</option>
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



        <div class="mb-6">
            <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Lieu de maintenance</label>
            <select name="location" id="location" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
               @error('location') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                <option value="" disabled selected>Choisissez un lieu</option>
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
            <input type="date" value="{{ old('start_date') }}" name="start_date" id="dateStart" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
            @error('start_date') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
            @error('start_date')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="dateEnd" class="block mb-2 text-sm font-medium text-gray-700">Date de fin</label>
            <input type="date" value="{{ old('due_date') }}" name="due_date" id="dateEnd" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
            @error('due_date') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
            @error('due_date')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
            <textarea id="message" value="{{ old('description') }}" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500
            @error('description') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="voter description........"></textarea>
            @error('description')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{$message}} </p>
            @enderror
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Envoyer</button>
    </form>
</div>

@endsection
