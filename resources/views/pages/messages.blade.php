@extends('layouts.app')

@section('content')
    <div class="messages-container">
        @include('partials.sidebar')
        @include('partials.messagesCard')
        @include('partials.sideSearchbar')
    </div>
    @include('partials.footer')
@endsection
