@extends('layouts.app')

@section('content')
    <h1>Search Page</h1>
   @foreach($users as $user)
    <h2><a href="/profile/{{$user->id}}">{{ $user->username }}</a></h2>
   @endforeach
@endsection
