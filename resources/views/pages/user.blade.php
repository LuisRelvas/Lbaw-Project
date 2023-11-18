@extends('layouts.app')

@section('title', 'user')

@section('content')

<article class="user" data-id="{{ $user->id }}">

    <header>
    <h2><a href="/profile/{{ $user->id }}">{{ $user->name }}</a></h2>
    </header>
    <h1>{{ $user->username }}</h1>
    @if($user->id == Auth::User()->id) 
    <h3><a href="/profile/{{ $user->id }}/editUser">Edit Profile</a></h3>
    <h3><a href="/logout" class="delete">&#10761;Delete Profile</a></h3>
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
    <h3><a href="/homepage">Back to home page</a></h3>

</article>

@endsection