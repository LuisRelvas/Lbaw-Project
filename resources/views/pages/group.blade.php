@extends('layouts.app')

@section('content')
    <div class="group-container">
        @include('partials.sidebar')

        @php
            $user = \App\Models\User::findOrFail($group->user_id);
        @endphp

        <div id="group{{ $group->id }}" data-group-id="{{ $group->id }}" class="group-card">
            <div class="group-header">
                <img src="{{ asset($user->media()) }}" class="profile-img" width="10%"
                    style="border-radius: 50%; padding: 1em" alt="profile media">
                <div class="groupauthor"><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></div>
            </div>
            <div class="groupcontent-card">
                <div class="groupname" data-original-name="{{ $group->name }}">{{ $group->name }}</div>
                <div class="groupcontent" data-original-description="{{ $group->description }}">
                    {{ $group->description }}</div>
            </div>
            @if ((Auth::check() && $group->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->isAdmin(Auth::user())))
                <button id="deleteGroup{{ $group->id }}" onclick="deleteGroup({{ $group->id }})"
                    class="button-group-comment">
                    <i class="fa-solid fa-trash"></i>
                </button>
            @endif

            @if(Auth::check() && $group->user_id == Auth::user()->id || Auth::check() && Auth::user()->isAdmin(Auth::user()))
        <button id="editGroup{{$group->id}}" onclick="editGroup({{$group->id}})" class="button-group-comment">&#9998;
            <div id="text-config"><i id="text-icon" class="pencil"></i></div>
        </button>
        <button id="cancelEditGroup{{$group->id}}" onclick="cancelEditGroup({{$group->id}})" style="visibility:hidden;" class="button-group-comment">&#10761;
            <div><i class="cross"></i> </div>
        </button>

            @endif

            <section id="buttons" class="buttons">
                @if (Auth::check() && Auth::user()->id != $group->owner_id)
                    <button id="groupState{{ $group->id }}" class="group-interaction-button"
                        onclick="changeGroupState({{ $group->id }},{{ Auth::user()->id }},{{ $group->is_public }})">
                        @if ($group->hasMember(Auth::user()))
                            <i id="text-icon" aria-hidden="true"></i> Leave Group
                            <button id="fav{{$group->id}}" onclick="isFavorite({{Auth::user()->id}}, {{$group->id}})" class="{{Auth::user()->isFavorite(Auth::user(),$group) ? 'group-interaction-button fa fa-star' : 'group-interaction-button fa fa-star-o'}}"></button>                        @else
                            <i id="text-icon" aria-hidden="true"></i> Join Group
                        @endif
                    </button>
                @endif
            </section>

            @if (Auth::check() && $group->hasMember(Auth::user()))


                @if (session('success'))
                    <p class="success">
                        {{ session('success') }}
                    </p>
                @endif

                <div class="group-chat">
                   
                    @if ($spaces)
                        @foreach ($spaces as $space)
                        @php
                            $spaceAuthor = \App\Models\Space::findOrFail($space->id);
                            $username = \App\Models\User::findOrFail($space->user_id);
                        @endphp
                            <div class="space-card">
                                <div class="spaceauthor"><a href="/space/{{ $space->id }}">{{ $username->username }}</a>
                                </div>
                                <main>
                                    <div class="spacecontent">{{ $space->content }}</div>
                                </main>
                            </div>
                        @endforeach
                    @endif
                </div>

                <h3><a href="javascript:void(0);" onclick="editGroup({{ $group->id }})"></a></h3>
                <div class="add-space-group-card">
                    <form method="POST" action="{{ url('space/add') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="group_id" value="{{ $group->id }}">

                        <div class="space-input-container">
                            <input id="content" type="text" name="content" placeholder="Enter space content"
                                style="color: white;" required autofocus>
                            <button type="submit"><i class="fa-solid fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <div class="group-sidebar">
        @if(Auth::check() && Auth::user()->isMember(Auth::user(),$group))

            <div id="members" class="members-card">
                <h2>Members</h2>
                @foreach ($members as $member)
                    <div class="member">
                        @php
                            $user = \App\Models\User::findOrFail($member->user_id);
                        @endphp
                        <p>{{ $user->username }}</p>
                        <!-- Add a cross icon next to each member -->
                        @if ((Auth::check() && Auth::user()->id == $group->user_id) || (Auth::check() && Auth::user()->isAdmin(Auth::user())))
                            @if($member->user_id != $group->user_id)
                            <button onclick="deleteMember({{ $member->user_id }})" class="button-member-delete"><i
                                    class="fa-solid fa-trash"></i>
                            </button>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
            @endif

            @if(Auth::check() && Auth::user()->id == $group->user_id || Auth::check() && Auth::user()->isAdmin(Auth::user()))
            <div class="joinrequest-card">
                <h2>Join Requests</h2>
                @foreach ($joins as $join)
                    <div class="join">
                        @php
                            $user = \App\Models\User::findOrFail($join->user_id);
                        @endphp
                        <p>{{ $user->username }}</p>    
                        <!-- Add a cross icon next to each join request -->
                        @if (Auth::check() && (Auth::user()->id == $group->user_id || Auth::user()->isAdmin(Auth::user())))
                            <button onclick="declineJoin({{ $join->user_id }}, {{ $join->group_id }})"
                                class="button-join-delete"><i class="fa-solid fa-trash"></i>
                            </button>
                            <button onclick="acceptJoin({{ $join->user_id }}, {{ $join->group_id }})"
                                class="button-join-accept"> &#10003;
                                <div><i class="tick"></i></div>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="invitegroup-container">
                <h2>Invite your friends!</h2>
                <form action="{{ url('/group/invite') }}" method="POST">
                    @csrf
                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                    <input type="email" name="email" placeholder="Enter email">
                    <button type="submit">Invite</button>
                </form>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>
    @include('partials.footer')
@endsection
