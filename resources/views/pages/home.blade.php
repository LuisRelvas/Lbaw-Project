@extends('layouts.app')

@section('content')
    <main class="flex-container">
        @if (Auth::check())
            <div class="sidebar">
                <!-- Sidebar content -->
                <a href="#">Home</a>
                <a href=" {{ url('/search') }}">Explore</a>
                <a href = "{{ url('/profile/' . Auth::user()->id) }}">Profile</a>
                <a href="#">Notifications</a>
                <a href="#">Settings</a>
                <!-- Add more links as needed -->
            </div>
        @endif

        <div class="content">
            <div class="card-header">{{ __('Public Spaces') }}</div>
            <div class="card-body">
                <ul class="card-list">
                    @foreach ($publics as $public)
                        <li><a href="/space/{{ $public->id }}" class="card">{{ $public->content }}</a></li>
                    @endforeach
                </ul>
            </div>

            @if (Auth::check())
                <div class="card-header">{{ __('Spaces') }}</div>

                <div class="card-body">
                    <ul class="card-list">
                        @foreach ($spaces as $space)
                            <li><a href="/space/{{ $space->id }}" class="card">{{ $space->content }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="card-header">{{ __('My Spaces') }}</div>
                <div class="card-body">
                    <ul class="card-list">
                        @foreach ($mines as $mine)
                            <li><a href="/space/{{ $mine->id }}" class="card">{{ $mine->content }}</a></li>
                        @endforeach
                    </ul>
                </div>
        </div>
        @endif
        @if (Auth::check())
            <div class="searchbar">
                @include('partials.addSpace')
        @endif
        <input type="text" id="search" placeholder="Search..." style="color: white;">
        <div id="results-users"></div>
        <div id="results-spaces"></div>
        </div>
    </main>
@endsection
