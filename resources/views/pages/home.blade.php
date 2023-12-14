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
                    @if (Auth::check())
                        @php
                            $allSpaces = $publics
                                ->concat($spaces)
                                ->sortByDesc('date')
                                ->reverse();
                            $allSpaces = $allSpaces->unique('id');
                        @endphp
                        @include('partials.addSpace')

                        @foreach ($allSpaces as $space)
                            <li><a href="/space/{{ $space->id }}" class="card">{{ $space->content }}</a></li>
                        @endforeach
                    @else
                        @foreach ($publics as $space)
                            <li><a href="/space/{{ $space->id }}" class="card">{{ $space->content }}</a></li>
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
                <div id="results-groups"></div>
                <div id="results-comments"></div>
            @endif
            @if (Auth::check())
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
