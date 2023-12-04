@extends('layouts.app')

@section('content')
<h3>Start New Conversation</h3>

<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <th>NEW</th>
        @foreach($followings as $following)
            @php 
                $start = App\Models\User::findOrFail($following->user_id2);
            @endphp
            <tr>
                <td>{{ $start->username }}</td>
                <td>
                    <a href="/messages/{{$start->id}}">Start Conversation</a>
                </td>
            </tr>
        @endforeach
        <th>Continue</th>
        @foreach($users as $user)
            @php
                $real = App\Models\User::findOrFail($user->emits_id);
            @endphp
            @if($real)
                <tr>
                    <td>{{ $real->username }}</td>
                    <td>
                        <a href="/messages/{{$real->id}}">Continue Conversation</a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
@endsection