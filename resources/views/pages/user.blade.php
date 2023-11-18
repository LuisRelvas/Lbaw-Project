@extends('layouts.app')

@section('title', 'user')

@section('content')

<div class="userinfo" data-id="{{ $user->id }}">

    <span class="dot"></span>
    <div class="user">
    <p><a href="/profile/{{ $user->id }}">{{ $user->name }}</a></p>
    </div>

    <div class="username">
        <p>@ {{ $user->username }}</p>
    </div>

    @if(Auth::check())
    @if($user->id == Auth::User()->id) 

    <a class="button" href="/profile/{{ $user->id }}/editUser">Edit Profile</a>
    <a class="button" href="/logout" class="delete">&#10761;Delete Profile</a>

    @else
    @if(!$isFollowing)
        <form method="POST" action="/profile/follow/{{ $user->id }}">
        @csrf
        <button type="submit">Follow</button>
         </form>
    @else($isFollowing)
        <form method="POST" action="/profile/unfollow/{{ $user->id }}">
        @csrf
        @method('DELETE')
        <button type="submit">Unfollow</button>
    </form>
    @endif
    @endif
    @endif
    <a class="button" href="/homepage">Back to home page</a>

</div>

@endsection
