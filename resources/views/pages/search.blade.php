@extends('layouts.app')
@section('content')
<div class="search-page-container">
    @include('partials.sidebar')
    <div class="search-card">
        <h1><i class="fa-solid fa-magnifying-glass"></i> Explore</h1>
        <button onclick="handlePrincipal()">Principal</button>
        <button onclick="handleUsers()">Users</button>
        <button onclick="handleSpaces()">Spaces</button>
        <button onclick="handleComments()">Comments</button>
        <form action="{{ url('homepage/search') }}" method="get">
            <input type="text" id="search" name="search" placeholder="Explore..." style="color: white;"
                pattern="[a-zA-Z0-9\s]+">
            <div id="filters" style="display: none;">
                <input type="date" id="date" name="date">
            </div>
            <button type="button" onclick="toggleFilters()">Filters <i class="fa-solid fa-filter"></i></button>
            <button type="submit">Search <i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <div id="users" class="search-page-results">
            @if (isset($users))
                @foreach ($users as $user)
                    <h2><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></h2>
                @endforeach
            @endif
        </div>
        <div id="spaces" class="search-page-results">
            @if (isset($spaces))
                @foreach ($spaces as $space)
                    <h2><a href="/space/{{ $space->id }}">{{ $space->content }}</a></h2>
                @endforeach
            @endif
        </div>
        <div id="comments" class="search-page-results">
            @if (isset($comments))
                @foreach ($comments as $comment)
                    <h2><a href="/space/{{ $comment->space_id }}">{{ $comment->content }}</a></h2>
                @endforeach
            @endif
        </div>
    </div>
</div>
@include('partials.footer')
@endsection

<script>
    function toggleFilters() {
        var filters = document.getElementById('filters');
        if (filters.style.display === 'none') {
            filters.style.display = 'block';
        } else {
            filters.style.display = 'none';
        }
    }

    function handleButtonClick(buttonType) {
        alert(`Button ${buttonType} clicked`);
    }
</script>