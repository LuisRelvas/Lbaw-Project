@forelse ($users as $user)
    <article class="search-page-card" id="user{{ $user->id }}">
        <a href="../profile/{{ $user->id }}">
            <h2 class="user-username search-page-card-user"> {{ $user->name }}</h2>
        </a>
        <h3 class="search-user-card-username">&#64;{{ $user->username }}</h3>
        </div>
    </article>
@empty
    <h2 class="no_results"></h2>
@endforelse
