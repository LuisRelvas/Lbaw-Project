@extends('layouts.app')
@include('partials.confirmation')

@section('content')
    Search Page
    <nav class="search-page" id="searchpage-nav" role="tablist">
        <a class="search" id="spaceResults" data-toggle="pill" href="#results-spaces" role="tab">0 Spaces</a>
        <a class="search" id="userResults" data-toggle="pill" href="#results-users" role="tab">0 Users</a>
    </nav>

    <div class="tab-content">
        <section class="tab-pane" id="results-spaces" role="tabpanel"></section>
        <section class="tab-pane" id="results-users" role="tabpanel"></section>

    </div>
@endsection
