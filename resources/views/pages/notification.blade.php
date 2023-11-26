@extends('layouts.app')

@section('content')
@foreach($notifications as $notification)
<div class="content">{{ $notification->received_user }}</div>
@if($notification->groupNotification && $notification->groupNotification->notification_type == 'invite')
<button id="acceptInvite{{ $notification->id }}" onclick="acceptInvite({{ $notification->groupNotification->group_id }}, {{ $notification->id }})">Accept</button>
<button id="declineInvite{{ $notification->id }}" onclick="deleteNotification({{ $notification->id }})">Decline</button>
@endif
<button id="deleteNotification{{ $notification->id }}" onclick="deleteNotification({{ $notification->id }})"
                        class="button-space-comment">&#10761;
                        <div><i class="cross"></i></div>
                    </button>
@endforeach
@endsection