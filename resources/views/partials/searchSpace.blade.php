@forelse ($spaces as $space)
    <article class="search-page-card" id="space{{ $space->id }}">
        <a href="../space/{{ $space->id }}">
            <h2 class="space-content search-page-card-space">{{ $space->user_id }}</h2>
        </a>
        <h3 class="search-space-card-content">{{ $space->content }}</h3>
    </article>
@empty
    <h2 class="no_results">No results found</h2>
@endforelse
