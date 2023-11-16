@forelse ($users as $user)
    <article class="search-page-card" id="user{{$user->id}}">
        <a href="../profile/{{$user->id}}"><h2 class="user-username search-page-card-user"> {{ $user->name }}</h2></a>
        </div>
    </article>
@empty
<h2 class="no_results">No results found</h2>
@endforelse