@extends('layouts.app')

@section('content')
    <main class="flex-container">
        @if(Auth::check())
        <div class="sidebar">
            <!-- Sidebar content -->
            <a href="#">Home</a>
            <a href=" {{ url('/search') }}">Explore</a>
            <a href = "{{ url('/profile/'.Auth::user()->id) }}">Profile</a>
            <a href="#">Notifications</a>
            <a href="#">Settings</a>
            <!-- Add more links as needed -->
        </div>
        @endif

        <div class="content">
            
        <div class="card-header">{{ __('Public Spaces') }}</div>
    <div class="card-body">
        <ul>
            @foreach ($publics as $public)
                <li><a href="/space/{{ $public->id }}">{{ $public->content }}</a></li>
            @endforeach
        </ul>
    </div>
    @if(Auth::user())
    <div class="card-header">{{ __('Spaces from following') }}</div>
    <div class="card-body">
        <ul>
            @foreach ($spaces as $space)
                <li><a href="/space/{{ $space->id }}">{{ $space->content }}</a></li>
            @endforeach
        </ul>
    </div>

    
    <div class="card-header">{{ __('My Spaces') }}</div>
    <div class="card-body">
        <ul>
            @foreach ($mines as $mine)
                <li><a href="/space/{{ $mine->id }}">{{ $mine->content }}</a></li>
            @endforeach
        </ul>
    @endif


    </main>
@endsection
