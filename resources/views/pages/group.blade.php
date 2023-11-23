@extends('layouts.app')

@section('content')
    @php
        $user = \App\Models\User::findOrFail($group->user_id);
    @endphp
    <div id="group{{ $group->id }}" data-group-id="{{ $group->id }}" class="group-card">
        <span class="dot"></span>
        <div class="groupauthor"><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></div>

        <main>
            <div class="groupname" data-name="{{$group->name}}">{{ $group->name }} </div>
            <div class="groupcontent">{{ $group->description }}</div>
        </main>
       
        @if ((Auth::check() && $group->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->isAdmin(Auth::user())))
            <button id="deleteGroup{{ $group->id }}" onclick="deleteGroup({{ $group->id }})"
                class="button-group-comment">&#10761;
                <div><i class="cross"></i></div>
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
    @if (session('success'))
            <p class="success">
                {{ session('success') }}
            </p>
        @endif 
    </div>
    <h3><a href="javascript:void(0);" onclick="editGroup({{$group->id }})"></a></h3>

@endsection