@extends('layouts.app')
@section('content')
<div class="search-page-container">
    @include('partials.sidebar');
    <div class="search-card">
        <h1><i class="fa-solid fa-magnifying-glass"></i> Explore</h1>
        <form action="{{ url('homepage/search') }}" method="get">           
            <div class="searchbar">
            <input type="text" id="search" name="search" placeholder="Search..." style="color: white;" pattern="[a-zA-Z0-9\s]+" oninput="performFTS()">                <div id="results-users"></div>
                    <div id="results-users"></div>
                    <div id="results-spaces"></div>
                    <div id="results-groups"></div>
                    <div id="results-comments"></div>
            </div>
            <div id="filters" style="display: none;">
                <input type="date" id="date" name="date">
                <input type="radio" id="publicRadio" name="profileType" value="public">Only Public Profiles
                <input type="radio" id="privateRadio" name="profileType" value="private">Only Private Profiles
                <input type="radio" id="publicRadioSpace" name="spaceType" value="public">Only Public Spaces
                <input type="radio" id="privateRadioSpace" name="spaceType" value="private">Only Private Spaces
                <input type="radio" id="publicRadioGroup" name="groupType" value="public">Only Public Groups
                <input type="radio" id="privateRadioGroup" name="groupType" value="private">Only Private Groups
            </div>  
            <button type="button" onclick="toggleFilters()">Filters <i class="fa-solid fa-filter"></i></button>
            <button type="submit">Search <i class="fa-solid fa-magnifying-glass"></i></button>        
        </form>
        <div id="users" class="search-page-results">
            @if (isset($users) && !$users->isEmpty())
                @foreach ($users as $user)
                    <h2><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></h2>
                @endforeach
            @else
                <p>No results found for your search</p>
            @endif
        </div>

        <div id="spaces" class="search-page-results">
            @if (isset($spaces) && !$spaces->isEmpty())
                @foreach ($spaces as $space)
                    <h2><a href="/space/{{ $space->id }}">{{ $space->content }}</a></h2>
                @endforeach
            @else
                <p>No results found for your search</p>
            @endif
        </div>

        <div id="comments" class="search-page-results">
            @if (isset($comments) && !$comments->isEmpty())
                @foreach ($comments as $comment)
                    <h2><a href="/space/{{ $comment->space_id }}">{{ $comment->content }}</a></h2>
                @endforeach
            @else
                <p>No results found for your search</p>
            @endif
        </div>

        <div id="groups" class="search-page-results">
            @if (isset($groups) && !$groups->isEmpty())
                @foreach ($groups as $group)
                    <h2><a href="/group/{{ $group->id }}">{{ $group->name }}</a></h2>
                @endforeach
            @else
                <p>No results found for your search</p>
            @endif
        </div>

    </div>
</div>
@include('partials.footer')
@endsection