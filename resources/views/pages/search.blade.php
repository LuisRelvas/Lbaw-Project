@extends('layouts.app')

<script>
    function toggleFilters() {
        var filters = document.getElementById('filters');
        if (filters.style.display === 'none') {
            filters.style.display = 'block';
        } else {
            filters.style.display = 'none';
        }
    }
</script>

@section('content')
<div class="search-page-container">
    <h1>Search Page</h1>
    <form action="{{ url('homepage/search') }}" method="get">
        <input type="text" id="search" name="search" placeholder="Search..." style="color: black;" pattern="[a-zA-Z0-9\s]+">
        <div id="filters" style="display: none;">
            <input type="date" id="date" name="date">

        </div>
        <button type="button" onclick="toggleFilters()">Filters</button>
        <button type="submit">Search</button>
    </form>
    @if(isset($users))
        @foreach($users as $user)
            <h2><a href="/profile/{{$user->id}}">{{ $user->username }}</a></h2>
        @endforeach
    @endif
    @if(isset($spaces))
        @foreach($spaces as $space)
            <h2><a href="/space/{{$space->id}}">{{ $space->content }}</a></h2>
        @endforeach
    @endif
    @if(isset($groups))
        @foreach($groups as $group)
            <h2><a href="/group/{{$group->id}}">{{ $group->name }}</a></h2>
        @endforeach
    @endif
    @if(isset($comments))
        @foreach($comments as $comment)
            <h2><a href="/space/{{$comment->space_id}}">{{ $comment->content }}</a></h2>
        @endforeach
    @endif
</div>
@include('partials.footer')
@endsection


