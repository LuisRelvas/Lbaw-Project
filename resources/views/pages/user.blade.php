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
    @if($user->id == Auth::User()->id || Auth::User()->isAdmin(Auth::User())) 
    <h3><a class="button" href="/profile/{{ $user->id }}/editUser">Edit Profile</a></h3>
    <h3><a class="button" href="/logout" class="delete">&#10761;Delete Profile</a></h3>
    @if(Auth::User()->isAdmin(Auth::User()))
        @if(!$isBlocked)
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
    @if(!$isFollowing)
        <form method="POST" action="/profile/follow/{{ $user->id }}">
        @csrf
        <button type="submit">Follow</button>
         </form>
    @else
        <form method="POST" action="/profile/unfollow/{{ $user->id }}">
        @csrf
        @method('DELETE')
        <button type="submit">Unfollow</button>
    </form>
    @endif
    @endif
     @endif
     <h3><a class ="button" href="{{ Auth::check() && Auth::user()->isAdmin(Auth::user()) ? url('/admin') : url('/homepage') }}">Back to home page</a></h3>
</article>

@endsection