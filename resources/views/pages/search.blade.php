@extends('layouts.app')
@section('content')
    <main class="flex-container">
        @include('partials.sidebar')
        @include('partials.searchCard')
    </main>
    @include('partials.footer')
@endsection
