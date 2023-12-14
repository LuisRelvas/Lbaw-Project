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
                    <div class="user">
                        <p><a href="/profile/{{ $user->id }}">{{ $user->name }}</a></p>
                        <div class="username">
                            <p>{{ $user->username }}</p>
                        </div>

                        @if (Auth::check() && Auth::user()->id == $user->id)
                            <p>Following: <a href="#"
                                    onclick="showFollows({{ Auth::user()->getFollowings() }})">{{ $countFollows }}</a></p>
                            <p>Followers: <a href="#"
                                    onclick="showFollowers({{ Auth::user()->getFollowers() }})">{{ $countFollowers }}</a>
                            </p>
                            <div class="follow-card">
                                <div id="followsDiv">
                                    <h3>Following</h3>
                                    <ul id="followsList"></ul>
                                </div>

                                <div id="followersDiv">
                                    <h3>Followers</h3>
                                    <ul id="followersList"></ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if (Auth::check())
                @if ($user->id == Auth::User()->id || Auth::User()->isAdmin(Auth::User()))
                    <div class="button-container"><a class="button" href="/profile/{{ $user->id }}/editUser">Edit
                            Profile <i class="fa-solid fa-user-pen"></i></a>
                        <button id="deleteProfile{{ $user->id }}" onclick="deleteProfile({{ $user->id }})"
                            class="button-user">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        <a class ="button"
                            href="{{ Auth::check() && Auth::user()->isAdmin(Auth::user()) ? url('/admin') : url('/homepage') }}">
                            <i class="fa-solid fa-arrow-left"></i> <i class="fa-solid fa-house"></i>
                        </a>
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
                    @if (Auth::check() && Auth::user()->id != $user->id && $user->deleted == false)
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
                    @if (Auth::check() && (Auth::user()->isFollowing($user) || $user->is_public == 0 || Auth::user()->id == $user->id))
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

    </main>
    @include('partials.footer')
@endsection
