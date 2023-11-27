@extends('layouts.app')
@section('content')


@foreach($all as $message)
<div class="content">
    <h2><div class="profile">{{ $message->emits_id }}</div></h2>
    <h3><div class="message">{{ $message->content }}</div></h3>
</div>
@endforeach

@php
$user = Auth::user();
$other_r = App\Models\User::find($message->emits_id);
$other = App\Models\User::find($message->received_id);
@endphp

<form method="POST" action="{{ url('/messages/send') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="content" class="label-color">Create a new Message</label>
    <input id="content" type="text" name="content" placeholder="Write message..." style="color: white;" required autofocus>
    @if(Auth::check() && Auth::user()->id == $other->id)
    <input id="received_id" type="hidden" name="received_id" value="{{ $other_r->id }}">
    @else
    <input id="received_id" type="hidden" name="received_id" value="{{ $other->id }}">
    @endif
    @if ($errors->has('content'))
        <span class="error">
            {{ $errors->first('content') }}
        </span>
    @endif
    <button type="submit">
        Create Message
    </button>
</form>



@endsection
