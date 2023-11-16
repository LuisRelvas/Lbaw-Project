@extends('layouts.app')
@include('partials.confirmation')

@section('content')
    <header id="search-header" class="search-page-card">
        <h1>Search Page</h1><br>
        <input type="search" id="search" placeholder="Search..."></input>
    </header><br>

    <nav class="nav nav-pills nav-justified myNav" id="searchpage-nav" role="tablist">
        <a class="nav-item nav-link text-white search-nav-bar-button" id="userResults" data-toggle="pill" href="#results-users" role="tab">0 Users</a>
    </nav>

    <div class="tab-content">
        <section class="tab-pane" id="results-users" role="tabpanel"></section>
    </div>
@endsection