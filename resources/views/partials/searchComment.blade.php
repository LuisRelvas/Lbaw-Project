@forelse ($comments as $comment)
@php 
$user = App\Models\User::find($comment->author_id);
$space = App\Models\Space::find($comment->space_id);
@endphp
    <article class="search-page-card" id="comment{{ $comment->id }}">
        <a href="../space/{{ $space->id }}">
            <h2 class="comment-content search-page-card-comment">{{ $user->username }}</h2>
        </a>
        <h3 class="search-comment-card-content">{{ $comment->content }}</h3>
    </article>
@empty
    <h2 class="no_results">No results found</h2>
@endforelse
