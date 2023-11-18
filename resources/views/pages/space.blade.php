@extends('layouts.app')

@section('content')
    <div id="space{{$space->id}}">
        <main>
            <h1 class="spacecontent">{{ $space->content }}</h1>
        </main>
    </div>

    <div>
        <a href="#" class="delete" onclick="deleteSpace({{$space->id}})">&#10761;</a>
        <h3><a href="javascript:void(0);" onclick="editSpace({{$space->id}})">Edit Space</a></h3>
        <h4>Comments</h4>
        {{-- Add a form for submitting comments --}}
        @if(Auth::check())
        <form method="POST" action="/comment/create">
                    @csrf
                    <input type="hidden" name="post_id" value="{{$space->id}}">
                    <textarea name="content" required></textarea>
                    <button type="submit">Submit</button>
        </form>
        @endif

        {{-- Display existing comments --}}
        @if ($space->comments)
            @foreach($space->comments as $comment)
                <div>
                    <h3><p>{{ $comment->username}}</p></h3>
                    <p>{{ $comment->content }}</p>
                    
                    {{-- Add delete and edit options for comments if needed --}}
                </div>
            @endforeach
        @endif
    </div>

    @if(Auth::check() && $space->user_id == Auth::user()->id)
        <button id="editSpace{{$space->id}}" onclick="editSpace({{$space->id}})" class="button-space-comment">
            <h4 id="text-config"><i id="text-icon" class="fa fa-pencil"></i></h4>
        </button>
        <button id="cancelEditSpace{{$space->id}}" onclick="cancelEditSpace({{$space->id}})" style="visibility:hidden;" class="button-space-comment">
            <h4><i class="fa fa-times"></i> </h4>
        </button>
    @endif
