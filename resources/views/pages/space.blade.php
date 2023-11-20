@extends('layouts.app')

@section('content')
    @php
        $user = \App\Models\User::findOrFail($space->user_id);
    @endphp
    <div id="space{{ $space->id }}" data-space-id="{{ $space->id }}" class="space-card">
        <span class="dot"></span>
        <div class="spaceauthor"><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></div>

        <main>
            <div class="spacecontent">{{ $space->content }}</div>
        </main>
        @if ((Auth::check() && $space->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->isAdmin(Auth::user())))
            <button id="deleteSpace{{ $space->id }}" onclick="deleteSpace({{ $space->id }})"
                class="button-space-comment">&#10761;
                <div><i class="cross"></i></div>
            </button>
        @endif
        @if ((Auth::check() && $space->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->isAdmin(Auth::user())))
            <button id="editSpace{{ $space->id }}" onclick="editSpace({{ $space->id }})"
                class="button-space-comment">&#9998;
                <div id="text-config"><i id="text-icon" class="pencil"></i></div>
            </button>
            <button id="cancelEditSpace{{ $space->id }}" onclick="cancelEditSpace({{ $space->id }})"
                style="visibility:hidden;" class="button-space-comment">&#10761;
                <div><i class="cross"></i> </div>
            </button>
        @endif
    </div>

    <div class="comment-card">
        <h3><a href="javascript:void(0);" onclick="editSpace({{ $space->id }})"></a></h3>
        <h4>Comments</h4>

        {{-- Add a form for submitting comments --}}
        @if (Auth::check())
            <form method="POST" action="/comment/create">
                @csrf
                <input type="hidden" name="space_id" value="{{ $space->id }}">
                <textarea name="content" required></textarea>
                <button type="submit">Submit</button>
            </form>
        @endif

        {{-- Display existing comments --}}
        @if ($space->comments)
            @foreach ($space->comments as $comment)
                <div id="comment{{ $comment->id }}" class="comment">
                    <div class="comment-user">
                        <p><a href="/profile/{{ $comment->author_id }}">{{ $comment->username }}</a></p>
                    </div>
                    <div class="content">{{ $comment->content }}</div>

                    {{-- Add delete and edit options for comments if needed --}}
                    @if (
                        (Auth::check() && $comment->author_id == Auth::user()->id) ||
                            (Auth::check() && Auth::user()->isAdmin(Auth::user())))
                        <button id="editComment{{ $comment->id }}" onclick="editComment({{ $comment->id }})"
                            class="button-comment">&#9998;
                            <div id="text-config"><i id="text-icon" class="pencil"></i></div>
                        </button>
                        <button id="deleteComment{{ $comment->id }}" onclick="deleteComment({{ $comment->id }})"
                            class="button-comment">&#10761;
                            <div><i class="cross"></i></div>
                        </button>
                        <button id="cancelEditComment{{ $comment->id }}" onclick="cancelEditComment({{ $comment->id }})"
                            style="visibility:hidden;" class="button-comment">&#10761;
                            <div><i class="cross"></i>Edit</div>
                        </button>
                    @endif
                </div>
            @endforeach
        @endif
    </div>


@endsection
