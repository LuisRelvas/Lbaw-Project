@extends('layouts.app')

@section('content')
@foreach($notifications as $notification)
@php 
$associated = App\Models\Notification::find($notification->id);
$user = App\Models\User::find($associated->emits_user);
@endphp 
@if($associated->viewed == false)
<div class="user">{{ $user->username }}</div>
<div class="content">{{ $notification->notification_type }}</div>
@if($notification->groupNotification && $notification->groupNotification->notification_type == 'invite')
<button id="acceptInvite{{ $notification->id }}" onclick="acceptInvite({{ $notification->groupNotification->group_id }}, {{ $notification->id }})">Accept</button>
<button id="declineInvite{{ $notification->id }}" onclick="deleteNotification({{ $notification->id }})">Decline</button>
@endif
<button id="updateNotification{{ $notification->id }}" onclick="updateNotification({{ $notification->id }})"
                        class="button-space-comment">&#10761;
                        <div><i class="cross"></i></div>
                    </button>
@elseif($associated->viewed == true)
<div class="user">{{ $user->username }}</div>
<div class="content">{{ $notification->notification_type }}</div>
@endif
@endforeach
@endsection