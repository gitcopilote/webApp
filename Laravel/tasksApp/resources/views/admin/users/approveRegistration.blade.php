@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Approve Registration') }}</div>

                <div class="card-body">
                    @if ($pendingUser)
                        <p>Name: {{ $pendingUser->name }}</p>
                        <p>Email: {{ $pendingUser->email }}</p>

                        <form action="{{ route('approveRegistration', $pendingUser->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">accepter</button>
                        </form>

                        {{-- <form action="{{ route('approveRegistration', $pendingUser->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">refuser</button>
                        </form> --}}

                        <form action="{{ route('rejectRegistration', $pendingUser->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">refuser</button>
                        </form>
                    @else
                        <p>Aucun utilisateur en attente n'a été trouvé.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if ($pendingUser)
    <div class="mt-3">
        <span class="text-gray-500">Demande d'inscription créée
            @if (Auth::user()->id == $pendingUser->created_by)
                vous
            @else
                {{ $pendingUser->created_by_name }}
            @endif {{ $pendingUser->created_at->diffForHumans() }}
        </span>
    </div>
@endif

@endsection






