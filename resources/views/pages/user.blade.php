@extends('layouts.app')

@section('title', 'user')

@section('content')


<article class="user" data-id="{{ $user->id }}">
    <header>
        <h2><a href="/profile/{{ $user->id }}">{{ $user->id }}</a></h2>
    </header>
    <h3><a href="/cards">Back to home page</a></h3>
    <h3><a href="/profile/{{ $user->id }}/editUser">Edit Profile</a></h3>
</article>

@endsection
