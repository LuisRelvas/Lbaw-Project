@extends('layouts.app')

@section('content')
@foreach($notifications as $notification)
<div class="content">{{ $notification->received_user }}</div>
<button id="deleteNotification{{ $notification->id }}" onclick="deleteNotification({{ $notification->id }})"
                        class="button-space-comment">&#10761;
                        <div><i class="cross"></i></div>
                    </button>
@endforeach
@endsection
