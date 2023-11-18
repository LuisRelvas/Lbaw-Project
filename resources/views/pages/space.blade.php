@extends('layouts.app')

@section('content')
    <div id="space{{$space->id}}">
        <main>
            <h1 class="spacecontent">{{ $space->content }}</h1>
        </main>
    </div>

    <div>
        <a href="#" class="delete" onclick="deleteSpace({{$space->id}})">&#10761;</a>
        <h3><a href="javascript:void(0);" onclick="editSpace({{$space->id}})"></a></h3>
        <h4>Comments</h4>
        {{-- Add a form for submitting comments --}}
        @if(Auth::check())
        <form method="POST" action="/comment/create">
                    @csrf
                    <input type="hidden" name="space_id" value="{{$space->id}}">
                    <textarea name="content" required></textarea>
                    <button type="submit">Submit</button>
        </form>
        @endif

        {{-- Display existing comments --}}
        @if ($space->comments)
            @foreach($space->comments as $comment)
                <div id="comment{{$comment->id}}">
                    <h3><p><a href="/profile/{{ $comment->author_id }}">{{ $comment->username }}</a></p></h3>
                    <div class="content">{{ $comment->content }}</div>
                    
                    {{-- Add delete and edit options for comments if needed --}}
                    @if(Auth::check() && $comment->author_id == Auth::user()->id)
                        <button id="editComment{{$comment->id}}" onclick="editComment({{$comment->id}})" class="button-comment">&#9998;
                            <h4 id="text-config"><i id="text-icon" class="fa fa-pencil"></i></h4>
                        </button>
                        <a href="#" class="delete" onclick="deleteComment({{$comment->id}})">&#10761;</a>

                        <button id="cancelEditComment{{$comment->id}}" onclick="cancelEditComment({{$comment->id}})" style="visibility:hidden;" class="button-comment">&#10761;
                            <h4><i class="fa fa-times"></i> </h4>
                        </button>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    @if(Auth::check() && $space->user_id == Auth::user()->id)
        <button id="editSpace{{$space->id}}" onclick="editSpace({{$space->id}})" class="button-space-comment">&#9998;
            <h4 id="text-config"><i id="text-icon" class="fa fa-pencil"></i></h4>
        </button>
        <button id="cancelEditSpace{{$space->id}}" onclick="cancelEditSpace({{$space->id}})" style="visibility:hidden;" class="button-space-comment">&#10761;
            <h4><i class="fa fa-times"></i> </h4>
        </button>
    @endif
@endsection