@extends('layouts.app')

@section('content')
    <script type="text/javascript" src={{ url('js/groups.js') }} defer></script>
    <div class="group-container">
        @include('partials.sidebar')

        @include ('partials.groupCard')

        @include ('partials.groupSideBar')
    </div>
    @include('partials.footer')
@endsection
