@extends('layouts.app')
@section('content')
    @if(Auth::user())
    <input type="text" id="search">
    <div id="results-users"></div>
    @include('partials.addSpace')
    @endif

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
@endsection