@extends('layouts.app')

@section('content')
    @include('partials.sidebar')

    <div id="followsDiv">
        @if(isset($follows) && count($follows) == 0)
            <h2>No follows yet</h2>
        @endif
        @foreach($follows as $follow)
            @php
                $user = \App\Models\User::findOrFail($follow->user_id2); 
            @endphp
            
            <div class="user">
                <h2><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></h2>
                <button id="remove{{ $user->id }}" onclick="stopFollowing({{ $user->id }})" class="button-user">Unfollow</button>
            </div>
        @endforeach
    </div>
@endsection