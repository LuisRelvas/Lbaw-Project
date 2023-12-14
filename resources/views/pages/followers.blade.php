@extends('layouts.app')

@section('content')
    @include('partials.sidebar')

    <div id="main-content">
        @foreach($follows as $follow)
            @php
                $user = \App\Models\User::findOrFail($follow->user_id1); 
            @endphp
            <div class="user">
                <h2><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></h2>
                <button id="remove{{ $user->id }}" onclick="removeFollower({{ $user->id }},{{Auth::user()->id}})" class="button-user">
                    <i class="fa-solid fa-user-minus"></i> Unfollow
                </button>
            </div>
        @endforeach
    </div>
@endsection