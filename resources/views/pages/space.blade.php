@extends('layouts.app')

@section('content')
    <div id="space{{$space->id}}">
        <main>
            <h1 class="spacecontent">{{ $space->content }}</h1>
            <a href="#" class="delete" onclick="deleteSpace({{$space->id}})">&#10761;</a>
        </main>
    </div>

    <div>
        <h3><a href="javascript:void(0);" onclick="editSpace({{$space->id}})">Edit Space</a></h3>
        <h4>Comments</h4>
    </div>

    @if(Auth::check() && $space->user_id == Auth::user()->id)
        <button id="editSpace{{$space->id}}" onclick="editSpace({{$space->id}})" class="button-space-comment">
            <h4 id="text-config"><i id="text-icon" class="fa fa-pencil"></i></h4>
        </button>
        <button id="cancelEditSpace{{$space->id}}" onclick="cancelEditSpace({{$space->id}})" style="visibility:hidden;" class="button-space-comment">
            <h4><i class="fa fa-times"></i> </h4>
        </button>
    @endif
@endsection
