<div id="space{{ $space->id }}" data-space-id="{{ $space->id }}" class="space-card">
                <img src="{{ asset($user->media()) }}" class="profile-img" width=10% style="border-radius: 50%; padding: 1em" alt="profile media">
                @if($user->id != 1)
                <div class="spaceauthor"><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></div>
                @else
                <div class="spaceauthordeleted">Anonymous</div>
                @endif
                <div class="spacecontent">{{ $space->content }}</div>
                <div class="space-img">
                @if($space->media())
                <img src="{{ asset($space->media()) }}" class="space-img" width=20% style=padding: 1em alt="profile media">
                @endif
                </div>
                @if(Auth::check())
                <button id="likeButton{{ $space->id }}"
                    onclick="changeLikeState({{ $space->id }}, {{ Auth::check() && Auth::user()->likesSpace(Auth::user(), $space) ? 'true' : 'false' }}, {{Auth::user()->id}},{{$space->user_id}})">
                    <i id="likeIcon{{ $space->id }}"
                        class="fa {{ Auth::check() && Auth::user()->likesSpace(Auth::user(), $space) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                    <span id="countSpaceLikes{{ $space->id }}" class="like-count"> {{ $space->likes() }}</span>
                </button>
                @endif
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
                @if (session('success'))
                    <p class="success">
                        {{ session('success') }}
                    </p>
                @endif
            </div>