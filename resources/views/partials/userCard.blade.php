<div class="userinfo" data-id="{{ $user->id }}">

    <div class="profile-container">
        <img src="{{ asset($user->media()) }}" class="profile-img" width="20%" style="border-radius: 50%; padding: 1em"
            alt="profile media">

        <div class="user-card-container" style="display: flex; justify-content: space-between;">
            <div class="user-card" style="flex: 1;">
                <div class="user" id="user{{$user->id}}">
                    <div class="name">
                        <div class="name">{{ $user->name }}</div>
                    </div>
                    <p><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></p>
                    <p>
                        <div class="email">{{ $user->email }}</div>
                    </p>
                </div>
            </div>
                @if(Auth::check())    
                <div class="user-card" style="flex: 1; margin-right: 20px;">
                    <div class="user-header">
                        <div style="display: flex; justify-content: space-between;">
                            <div style="display: flex; flex-direction: column; text-align: center; color: white; font-size: larger; margin-right: 20px;">
                                <span>Following</span>
                                <a href="/profile/{{$user->id}}/following" style="color: white;">{{ $countFollows }}</a>
                            </div>
                            <div style="display: flex; flex-direction: column; text-align: center; color: white; font-size: larger; margin-right: 20px;">
                                <span>Followers</span>
                                <a href="/profile/{{$user->id}}/followers" style="color: white;">{{ $countFollowers }}</a>
                            </div>
                            <div style="display: flex; flex-direction: column; text-align: center; color: white; font-size: larger;">
                                <span>Spaces</span>
                                <span>{{ count($spaces) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @if (Auth::check() && ($user->id == Auth::user()->id || Auth::user()->isAdmin(Auth::user())))
            <div class="button-container-user">
                <button id="editUser{{ $user->id }}" onclick="editUser({{ $user->id }},{{$user->is_public}})" class="button-user-comment">
                    &#9998;
                    <div id="text-config"><i id="text-icon" class="pencil"></i></div>
                </button>

                <button id="cancelEditUser{{ $user->id }}" style="visibility: hidden;"
                    onclick="cancelEditUser({{ $user->id }})">Cancel</button>
                @include ('partials.editUser')
                <button id="deleteProfile{{ $user->id }}" onclick="deleteProfile({{ $user->id }})" class="button-user">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @if (Auth::user()->isAdmin(Auth::user()))
            @if(!$isBlocked)
                <form method="POST" action="/profile/block/{{ $user->id }}">
                    @csrf
                    <button type="submit">Block</button>
                </form>
            @else
                <form method="POST" action="/profile/unblock/{{ $user->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Unblock</button>
                </form>
            @endif
            @endif
        @elseif (Auth::check() && Auth::user()->id != $user->id && $user->id != 1)
            <button id="profileState{{ $user->id }}" class="profile-interaction-button"
                onclick="changeProfileState({{ $user->id }},{{ Auth::user()->id }},{{ $user->is_public }})">
                @if (Auth::user()->isFollowing($user))
                    <i id="text-icon" aria-hidden="true"></i> Unfollow
                @elseif(Auth::user()->hasSentFollowRequest($user))
                    <i id="text-icon" aria-hidden="true"></i> Pending
                @else
                    <i id="text-icon" aria-hidden="true"></i> Follow
                @endif
            </button>
        @endif
    </div>
    <div class="card-body">
        <ul class="card-list">
            @if ((Auth::check() && (Auth::user()->isFollowing($user) || $user->is_public == 0 || Auth::user()->id ==
            $user->id)) || Auth::check() && Auth::user()->isAdmin(Auth::user()))
            @foreach ($spaces as $space)
            <li>
                <div class="card">
                    <ul>
                        @php
                        $user = App\Models\User::find($space->user_id);
                        @endphp
                        <li><img src="{{ asset($user->media()) }}" class="profile-img" width="10%"
                                style="border-radius: 50%; padding: 1em" alt="profile media">
                            <a href="/profile/{{ $space->user_id }}">{{ $user->username }}</a>
                        </li>
                        <div id="space-home-content">
                            <li><a href="/space/{{ $space->id }}">{{ $space->content }}</a></li>
                        </div>
                        <li>
                            @if ($space->media())
                            <img src="{{ asset($space->media()) }}" class="space-img" width=20% style=padding: 1em
                                alt="space media">
                            @endif
                        </li>
                        @include('partials.likeSpace')

                    </ul>
                </div>
            </li>
            @endforeach
            @endif

        </ul>
    </div>
</div>