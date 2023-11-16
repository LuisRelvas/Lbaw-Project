@extends('layouts.app')

@section('content')
    <input type="text" id="search">
    <button class="searchpagebutton" onclick="handleSearchButtonClick()">Search</button>
    <div id="results-users"></div>
@endsection