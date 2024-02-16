@extends('layouts.app')

@section('content')

<h1 class="text-3xl text-black-500 mb-3 mt-10">Editer</h1>

<div class="bg-white shadow-lg px-4 py-6 rounded-md">
    <form method="POST" action="{{route('admin.users.update',['user' => $user->id] ) }}">
   @csrf
    @foreach ($roles as $role)
        <div class="flex items-start mb-6">
            <div class="flex items-center h-5">
              <input id="role" type="checkbox" value="{{$role->id}} " name="roles[]"


              @if ($user->roles->contains('id',$role->id) )
                  checked
              @endif


              class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300  dark:focus:ring-blue-600 ">
            </div>
            <label for="role" class="ml-2 text-sm font-medium text-gray-900">{{$role->name}}</label>
        </div>
    @endforeach
        <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Attribuer</button>
    </form>
</div>

@endsection
