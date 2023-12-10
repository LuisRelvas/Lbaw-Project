@forelse ($groups as $group)
@php 
$user = App\Models\User::find($group->user_id);
@endphp
    <article class="search-page-card" id="group{{ $group->id }}">
        <a href="../group/{{ $group->id }}">
            <h2 class="group-content search-page-card-group">{{ $user->username }}</h2>
        </a>
        <h3 class="search-group-card-content">{{ $group->name }}</h3>
    </article>
@empty
    <h2 class="no_results">No results found</h2>
@endforelse
