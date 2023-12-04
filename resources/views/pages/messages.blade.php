@extends('layouts.app')

@section('content')
    <div class="messages-container">
        @include('partials.sidebar')
        <div class="messages-card">
            <h3>Messages <i class="fa-solid fa-message"></i></h3>

            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <th>NEW</th>
                    @foreach ($followings as $following)
                        @php
                            $start = App\Models\User::findOrFail($following->user_id2);
                        @endphp
                        <tr>
                            <td class="username">{{ $start->username }}</td>
                            <td>
                                <a href="/messages/{{ $start->id }}">Start Conversation <i class="fa-solid fa-comment"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    <th>CONTINUE</th>
                    @foreach ($users as $user)
                        @php
                            $real = App\Models\User::findOrFail($user->emits_id);
                        @endphp
                        @if ($real)
                            <tr>
                                <td class="username">{{ $real->username }}</td>
                                <td>
                                    <a href="/messages/{{ $real->id }}">Continue Conversation <i class="fa-solid fa-comments"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('partials.footer')
@endsection
