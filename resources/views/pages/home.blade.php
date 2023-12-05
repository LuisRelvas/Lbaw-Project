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
            <div class="card-body">
                <ul class="card-list">
                    @foreach ($publics as $public)
                        <li><a href="/space/{{ $public->id }}" class="card">{{ $public->content }}</a></li>
                    @endforeach
                    @if (Auth::check())
                        @foreach ($spaces as $space)
                            <li><a href="/space/{{ $space->id }}" class="card">{{ $space->content }}</a></li>
                        @endforeach
                        @foreach ($mines as $mine)
                            <li><a href="/space/{{ $mine->id }}" class="card">{{ $mine->content }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="searchbar">

            <input type="text" id="search" placeholder="Search..." style="color: white;" pattern="[a-zA-Z0-9\s]+">
            <div id="results-users"></div>
            @if (Auth::check())
                <div id="results-spaces"></div>
            @endif
            @if (Auth::check())
                @include('partials.addGroup')
                @include('partials.addSpace')
                @if (session('success'))
                    <p class="success">
                        {{ session('success') }}
                    </p>
                @endif
            @endif
        </div>
    </main>
    @include('partials.footer')
@endsection
