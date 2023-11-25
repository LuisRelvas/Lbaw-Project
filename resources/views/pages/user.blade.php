@extends('layouts.app')

@section('title', 'user')

@section('content')
<main class="flex-container">
    @include('partials.sidebar')

    <div class="userinfo" data-id="{{ $user->id }}">

        <span class="dot"></span>
        <div class="user">
            <p><a href="/profile/{{ $user->id }}">{{ $user->name }}</a></p>
        </div>

        <div class="username">
            <p>@ {{ $user->username }}</p>
        </div>
        @if (Auth::check())
            @if ($user->id == Auth::User()->id || Auth::User()->isAdmin(Auth::User()))
                <div class="button-container"><a class="button" href="/profile/{{ $user->id }}/editUser">Edit
                        Profile</a>
                    <a class="button" href="/logout" class="delete">&#10761;Delete Profile</a>
                    <a class ="button"
                        href="{{ Auth::check() && Auth::user()->isAdmin(Auth::user()) ? url('/admin') : url('/homepage') }}">Back
                        to
                        home page</a>
                </div>
                @if (Auth::User()->isAdmin(Auth::User()))
                    @if (!$isBlocked)
                        <form method="POST" action="/profile/block/{{ $user->id }}">
                            @csrf
                            <button type="submit">Block</button>
                        </form>
                    @else
                        <form method="POST" action="/profile/unblock/{{ $user->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Unblock</button>
                        </form>
                    @endif
                @endif
            @else
                @if(Auth::check() && Auth::user()->id != $user->id)
                    <button id="profileState{{$user->id}}" class="profile-interaction-button" onclick="changeProfileState({{$user->id}},{{Auth::user()->id}},{{$user->is_public}})">
                        @if(Auth::user()->isFollowing($user)) <i id="text-icon" aria-hidden="true"></i> Unfollow
                        @else <i id="text-icon" aria-hidden="true"></i> Follow
                        @endif
                    </button>
                @endif
            @endif
        @endif
        @foreach($wants as $want)
            @if(Auth::check() && $want->user_id2 == Auth::user()->id)
            <p>Follow request from {{ $want->user_id1 }}</p>
            <button onclick="declineFollowRequest({{ $want->user_id1 }}, {{ $want->user_id2 }})" class="button-join-delete">&#10761;
                <div><i class="cross"></i></div>
                </button>
                <button onclick="acceptFollowRequest({{ $want->user_id1 }}, {{ $want->user_id2 }})" class="button-join-accept"> &#10003;
                    <div><i class="tick"></i></div>
                </button>  
            @endif
        @endforeach
        @if (session('success'))
            <p class="success">
                {{ session('success') }}
            </p>
        @endif
    </div>
</main>
@include('partials.footer')
@endsection
