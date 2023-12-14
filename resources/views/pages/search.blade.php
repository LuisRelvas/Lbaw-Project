@extends('layouts.app')
@section('content')
    <div class="search-page-container">
        @include('partials.sidebar')
        <div class="search-card">
            <h1><i class="fa-solid fa-magnifying-glass"></i> Explore</h1>
            <form action="{{ url('homepage/search') }}" method="get">
                <div class="searchbar">
                    <input type="text" id="search" name="search" placeholder="Search..." style="color: white;"
                        pattern="[a-zA-Z0-9\s]+" onclick="showResultsContainer()" onblur="hideResultsContainer()"
                        autocomplete="off" required>
                    <div class="results-container" id="resultsContainer">
                        <div id="results-users"></div>
                        <div id="results-spaces"></div>
                        <div id="results-groups"></div>
                        <div id="results-comments"></div>
                    </div>
                </div>
                <div id="filters" style="display: none;">
                    <input type="date" id="date" name="date">
                    <input type="radio" id="publicRadio" name="profileType" value="anyone">Anyone
                    <input type="radio" id="privateRadio" name="profileType" value="follow">People that You follow
                </div>
                <button type="button" onclick="toggleFilters()">Filters <i class="fa-solid fa-filter"></i></button>
                <button type="submit">Search <i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <!-- Show results only if the search input is not empty -->
            <div id="users" class="search-page-results" style="overflow-y: auto;">
                @if (isset($users) && !empty($users))
                    @foreach ($users as $user)
                        <h2><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></h2>
                    @endforeach
                @else
                    <p>No results found for your search</p>
                @endif
            </div>
            <div id="spaces" class="search-page-results">
                @if (isset($spaces) && !empty($spaces))
                    @foreach ($spaces as $space)
                        <h2><a href="/space/{{ $space->id }}">{{ $space->content }}</a></h2>
                    @endforeach
                @else
                    <p>No results found for your search</p>
                @endif
            </div>

            <div id="comments" class="search-page-results">
                @if (isset($comments) && !empty($comments))
                    @foreach ($comments as $comment)
                        <h2><a href="/space/{{ $comment->space_id }}">{!! strip_tags($comment->content) !!}</a></h2>
                    @endforeach
                @else
                    <p>No results found for your search</p>
                @endif
            </div>
            <div id="groups" class="search-page-results">
                @if (isset($groups) && !empty($groups))
                    @foreach ($groups as $group)
                        <h2><a href="/group/{{ $group->id }}">{{ $group->name }}</a></h2>
                    @endforeach
                @else
                    <p>No results found for your search</p>
                @endif
            </div>
        </div>
        @include('partials.sideSearchbar')
    </div>
    @include('partials.footer')
@endsection
