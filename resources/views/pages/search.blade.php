@extends('layouts.app')
@section('content')
    <div class="search-page-container">
        @include('partials.sidebar')
        @include('partials.searchCard')
    </div>
    @include('partials.footer')
@endsection
