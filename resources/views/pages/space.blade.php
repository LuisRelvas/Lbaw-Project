@extends('layouts.app')

@section('content')
    @php
        $user = \App\Models\User::findOrFail($space->user_id);

    @endphp
    <main class="flex-container">
        @include('partials.sidebar')
        <div class="content">
            <script>
                // Declare a global JavaScript variable
                window.spaceUserId = "{{ $space->user_id }}";
            </script>
            <div id="space{{ $space->id }}" data-space-id="{{ $space->id }}" class="space-card">
                <img src="{{ asset($user->media()) }}" class="profile-img" width=10% style="border-radius: 50%; padding: 1em"
                    alt="profile media">
                @if ($user->deleted == false)
                    <div class="spaceauthor"><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></div>
                @else
                    <div class="spaceauthordeleted">Anonymous</div>
                @endif

                <main>
                    <div class="spacecontent">{{ $space->content }}</div>
                </main>
                <div class="space-img">
                    @if ($space->media())
                        <img src="{{ asset($space->media()) }}" class="space-img" width=20% style=padding: 1em
                            alt="profile media">
                    @endif
                </div>
                @if (Auth::check())
                    <button id="likeButton{{ $space->id }}"
                        onclick="changeLikeState({{ $space->id }}, {{ Auth::check() && Auth::user()->likesSpace(Auth::user(), $space) ? 'true' : 'false' }}, {{ Auth::user()->id }},{{ $space->user_id }})">
                        <i id="likeIcon{{ $space->id }}"
                            class="fa {{ Auth::check() && Auth::user()->likesSpace(Auth::user(), $space) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                        <span id="countSpaceLikes{{ $space->id }}" class="like-count"> {{ $space->likes() }}</span>
                    </button>
                @endif
                @if ((Auth::check() && $space->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->isAdmin(Auth::user())))
                    <button id="deleteSpace{{ $space->id }}" onclick="deleteSpace({{ $space->id }})"
                        class="button-space-comment">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                @endif
                @if ((Auth::check() && $space->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->isAdmin(Auth::user())))
                    <button id="editSpace{{ $space->id }}" onclick="editSpace({{ $space->id }})"
                        class="button-space-comment">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button id="cancelEditSpace{{ $space->id }}" onclick="cancelEditSpace({{ $space->id }})"
                        style="visibility:hidden;" class="button-space-comment">
                        <div>Cancel</div>
                    </button>
                @endif
                @if (session('success'))
                    <p class="success">
                        {{ session('success') }}
                    </p>
                @endif
            </div>

            <div class="comment-card">
                <h3><a href="javascript:void(0);" onclick="editSpace({{ $space->id }})"></a></h3>
                <h4>Comments</h4>

                {{-- Add a form for submitting comments --}}
                @if (Auth::check() && !Auth::user()->isAdmin(Auth::user()) && ($user->is_public == false || Auth::user()->isFollowing($user)))
                    <form method="POST" action="/comment/create">
                        @csrf
                        <input type="hidden" name="space_id" value="{{ $space->id }}">
                        <textarea name="content" required></textarea>
                        <button type="submit">Submit</button>
                    </form>
                @endif
                {{-- Display existing comments --}}
                @if ($space->comments)
                    @if ($errors->has('profile'))
                        <span class="error">
                            {{ $errors->first('profile') }}
                        </span>
                    @endif
                    @foreach ($space->comments as $comment)
                        <div id="comment{{ $comment->id }}" class="comment">
                            <div class="comment-user">
                                @php
                                    $real = \App\Models\User::findOrFail($comment->author_id);
                                @endphp
                                @if ($real->deleted == false)
                                    <p><a href="/profile/{{ $comment->author_id }}">{{ $comment->username }}</a></p>
                                @else
                                    <p>Anonymous</p>
                                @endif
                            </div>
                            <div class="content">{{ $comment->content }}</div>
                            @if (Auth::check())
                                <button id="likeButton{{ $comment->id }}"
                                    onclick="changeLikeStateC({{ $comment->id }}, {{ Auth::check() && Auth::user()->likesComment(Auth::user(), $comment) ? 'true' : 'false' }})">
                                    <i id="likeIcon{{ $comment->id }}"
                                        class="fa {{ Auth::check() && Auth::user()->likesComment(Auth::user(), $comment) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                    <span id="countCommentLikes{{ $comment->id }}" class="like-count">
                                        {{ $comment->likes() }}</span>
                                </button>
                            @endif

                            {{-- Add delete and edit options for comments if needed --}}
                            @if (
                                (Auth::check() && $comment->author_id == Auth::user()->id) ||
                                    (Auth::check() && Auth::user()->isAdmin(Auth::user())))
                                <button id="editComment{{ $comment->id }}" onclick="editComment({{ $comment->id }})"
                                    class="button-comment">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button id="deleteComment{{ $comment->id }}" onclick="deleteComment({{ $comment->id }})"
                                    class="button-comment">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <button id="cancelEditComment{{ $comment->id }}"
                                    onclick="cancelEditComment({{ $comment->id }})" style="visibility:hidden;"
                                    class="button-comment">&#10761;
                                    <div><i class="cross"></i></div>
                                </button>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </main>
    @include('partials.footer')
@endsection
