@extends('layouts.app')

@section('title', 'user')

@section('content')

<article class="user" data-id="{{ $user->id }}">

    <header>
    <h2><a href="/profile/{{ $user->id }}">{{ $user->name }}</a></h2>
    </header>
    <h1>{{ $user->username }}</h1>
    @if(Auth::check())
    @if($user->id == Auth::User()->id || Auth::User()->isAdmin(Auth::User())) 
    <h3><a href="/profile/{{ $user->id }}/editUser">Edit Profile</a></h3>
    <h3><a href="/logout" class="delete">&#10761;Delete Profile</a></h3>
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
     <h3><a href="{{ Auth::check() && Auth::user()->isAdmin(Auth::user()) ? url('/admin') : url('/homepage') }}">Back to home page</a></h3>
</article>

@endsection