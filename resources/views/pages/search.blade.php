@extends('layouts.app')

@section('content')
    <h1>Search Page</h1>
    <form action="{{ url('homepage/search') }}" method="get">
            <input type="text" id="search" name="search" placeholder="Search..." style="color: black;" pattern="[a-zA-Z0-9\s]+">
            <button type="submit">Search</button>
    </form>
   @foreach($users as $user)
    <h2><a href="/profile/{{$user->id}}">{{ $user->username }}</a></h2>
   @endforeach
@endsection
