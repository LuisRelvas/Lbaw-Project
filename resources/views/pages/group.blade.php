@extends('layouts.app')

@section('content')
    <div class="maingroup-container">
        @include('partials.sidebar')
        @php
            $user = \App\Models\User::findOrFail($group->user_id);
        @endphp

        <div id="group{{ $group->id }}" data-group-id="{{ $group->id }}" class="group-card">
            <span class="dot"></span>
            <div class="groupauthor"><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></div>

            <div class="groupcontent-card">
                <div class="groupname" data-name="{{ $group->name }}">{{ $group->name }} </div>
                <div class="groupcontent">{{ $group->description }}</div>
            </div>

            @if ((Auth::check() && $group->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->isAdmin(Auth::user())))
                <button id="deleteGroup{{ $group->id }}" onclick="deleteGroup({{ $group->id }})"
                    class="button-group-comment">&#10761;
                    <div><i class="cross"></i></div>
                </button>
            @endif

            @if ((Auth::check() && $group->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->isAdmin(Auth::user())))
                <button id="editGroup{{ $group->id }}" onclick="editGroup({{ $group->id }})"
                    class="button-group-comment">&#9998;
                    <div id="text-config"><i id="text-icon" class="pencil"></i></div>
                </button>
                <button id="cancelEditGroup{{ $group->id }}" onclick="cancelEditGroup({{ $group->id }})"
                    style="visibility:hidden;" class="button-group-comment">&#10761;
                    <div><i class="cross"></i> </div>
                </button>
            @endif

            <section id="buttons" class="buttons">
                @if (Auth::check() && Auth::user()->id != $group->owner_id)
                    <button id="groupState{{ $group->id }}" class="group-interaction-button"
                        onclick="changeGroupState({{ $group->id }},{{ Auth::user()->id }},{{ $group->is_public }})">
                        @if ($group->hasMember(Auth::user()))
                            <i id="text-icon" aria-hidden="true"></i> Leave Group
                        @else
                            <i id="text-icon" aria-hidden="true"></i> Join Group
                        @endif
                    </button>
                @endif
            </section>

            <div id="members" class="members-card">
                <h3>Members</h3>
                @foreach ($members as $member)
                    @php
                        $user = \App\Models\User::findOrFail($member->user_id);
                    @endphp
                    <p>{{ $user->username }}</p>
                    <!-- Add a cross icon next to each member -->
                    @if ((Auth::check() && Auth::user()->id == $group->user_id) || (Auth::check() && Auth::user()->isAdmin(Auth::user())))
                        <button onclick="deleteMember({{ $member->user_id }})" class="button-member-delete">&#10761;
                            <div><i class="cross"></i></div>
                        </button>
                    @endif
                @endforeach
            </div>

            <div class="joinrequest-card">
                <h3>Join Requests</h3>
                @foreach ($joins as $join)
                    <div class="join">
                        @php
                            $user = \App\Models\User::findOrFail($join->user_id);
                        @endphp
                        <p>{{ $user->username }}</p>
                        <!-- Add a cross icon next to each join request -->
                        @if (Auth::check() && (Auth::user()->id == $group->user_id || Auth::user()->isAdmin(Auth::user())))
                            <button onclick="declineJoin({{ $join->user_id }}, {{ $join->group_id }})"
                                class="button-join-delete">&#10761;
                                <div><i class="cross"></i></div>
                            </button>
                            <button onclick="acceptJoin({{ $join->user_id }}, {{ $join->group_id }})"
                                class="button-join-accept"> &#10003;
                                <div><i class="tick"></i></div>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
            @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
            @endif
        </div>

        <h3><a href="javascript:void(0);" onclick="editGroup({{ $group->id }})"></a></h3>

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
    </div>

    @include('partials.footer')
@endsection
