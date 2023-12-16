@extends('layouts.app')

@section('title', 'user')
@section('content')


<main class="flex-container">
    @include('partials.sidebar')

    <div class="userinfo" data-id="{{ $user->id }}">
    
        <div class="profile-container">
            <img src="{{ asset($user->media()) }}" class="profile-img" width="10%"
                style="border-radius: 50%; padding: 1em" alt="profile media">
            <div class="profile-info">
                <div class="user" id="user{{$user->id}}">
                    <p><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></p>
                    <div class="username">
                        <div class="name">{{ $user->name }}</div>
                    </div>
                    <p>
                    <div class="email">{{ $user->email }}</div>
                    </p>
                    @if (Auth::check() && Auth::user()->id == $user->id)
                    <p>Following: <a href="/profile/{{$user->id}}/following">{{ $countFollows }}</a></p>
                    <p>Followers: <a href="/profile/{{$user->id}}/followers">{{ $countFollowers }}</a>
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @if (Auth::check())
        @if ($user->id == Auth::User()->id || Auth::User()->isAdmin(Auth::User()))
        <button id="editUser{{ $user->id }}" onclick="editUser({{ $user->id }})" class="button-user-comment">
            &#9998;
            <div id="text-config"><i id="text-icon" class="pencil"></i></div>
        </button>
        <button id="cancelEditUser{{ $user->id }}" style="visibility: hidden;"
            onclick="cancelEditUser({{ $user->id }})">Cancel</button>
            @include ('partials.editUser')
            <a class="button" href="/profile/{{ $user->id }}/editUser/password">Change Password <i
                    class="fa-solid fa-key"></i></a>
            <button id="deleteProfile{{ $user->id }}" onclick="deleteProfile({{ $user->id }})" class="button-user">
                <i class="fa-solid fa-trash"></i>
            </button>
            <a class="button"
                href="{{ Auth::check() && Auth::user()->isAdmin(Auth::user()) ? url('/admin') : url('/homepage') }}">
                <i class="fa-solid fa-arrow-left"></i> <i class="fa-solid fa-house"></i>
            </a>
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
        @if (Auth::check() && Auth::user()->id != $user->id && $user->id != 1)
        <button id="profileState{{ $user->id }}" class="profile-interaction-button"
            onclick="changeProfileState({{ $user->id }},{{ Auth::user()->id }},{{ $user->is_public }})">
            @if (Auth::user()->isFollowing($user))
            <i id="text-icon" aria-hidden="true"></i> Unfollow
            @elseif(Auth::user()->hasSentFollowRequest($user))
            <i id="text-icon" aria-hidden="true"></i> Pending
            @else
            <i id="text-icon" aria-hidden="true"></i> Follow
            @endif
        </button>
        @else
        <h3>Account Deleted</h3>
        @endif
        @endif
        @endif
        <div class="card-body">
            <ul class="card-list">
                @if ((Auth::check() && (Auth::user()->isFollowing($user) || $user->is_public == 0 || Auth::user()->id ==
                $user->id)) || Auth::check() && Auth::user()->isAdmin(Auth::user()))
                @foreach ($spaces as $space)
                <li><a href="/space/{{ $space->id }}" class="card">{{ $space->content }}</a></li>
                @endforeach
                @endif

            </ul>
        </div>
    </div>
    @if (session('success'))
    <p class="success">
        {{ session('success') }}
    </p>
    @endif
    </div>
    @include('partials.sideSearchbar')

</main>
@include('partials.footer')
@endsection





