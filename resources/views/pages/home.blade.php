@extends('layouts.app')
@include('partials.addSpace')
@section('content')
    <input type="text" id="search">
    <div id="results-users"></div>
    <div class="card-header">{{ __('Spaces') }}</div>

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
@endsection