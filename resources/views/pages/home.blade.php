@extends('layouts.app')

@section('content')

    <main class="flex-container">
        @include('partials.sidebar')

        <div class="content">
            @if ($errors->has('profile'))
                <span class="error">
                    {{ $errors->first('profile') }}
                </span>
            @endif
            @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
            @endif
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
            @endif
        </div>
        <div class="searchbar">
            @if (Auth::check())
                @include('partials.addGroup')
                @include('partials.addSpace')
                @if (session('success'))
                    <p class="success">
                        {{ session('success') }}
                    </p>
                @endif
            @endif
            <input type="text" id="search" placeholder="Search..." style="color: white;" pattern="[a-zA-Z0-9\s]+">
            <div id="results-users"></div>
            @if (Auth::check())
                <div id="results-spaces"></div>
            @endif
        </div>
    </main>
    @include('partials.footer')
@endsection
