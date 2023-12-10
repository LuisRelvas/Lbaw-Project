@extends('layouts.app')
@section('content')
<script type="text/javascript" src={{ url('js/message.js') }} defer></script>
    <div class="message-container">
        @include('partials.sidebar')
        <div class="message-card">
            @if (!$all->isEmpty())
                <div id="message-identifier" data-message-id="{{ $all->first()->emits_id }}"></div>
                <div class="message-content">
                    @foreach ($all as $message)
                        <div class="message" data-message-id="{{ $message->emits_id }}">
                            @php 
                                $show = App\Models\User::find($message->emits_id);
                            @endphp
                            <div class="profile">{{ $show->username }}</div>
                            <div class="body">{{ $message->content }}</div>
                            <div class="timestamp">{{$message->date}}</div>
                        </div>
                    @endforeach
                    @php
                        $user = Auth::user();
                        $other_r = App\Models\User::find(optional($message)->emits_id);
                        $other = App\Models\User::find(optional($message)->received_id);
                    @endphp
                </div>
                <div id="user-identifier" data-user-id="{{ $other->id }}"></div>

                <form method="POST" action="{{ url('/messages/send') }}" enctype="multipart/form-data" class="message-form">
                    {{ csrf_field() }}
                    <div class="message-input-container">
                        <input id="content" type="text" name="content" placeholder="Write message..."
                            style="color: white;" required autofocus>
                        @if (Auth::check() && Auth::user()->id == $other->id)
                            <input id="received_id" type="hidden" name="received_id" value="{{ $other_r->id }}">
                            <input id="emits_id" type="hidden" name="emits_id" value="{{ $other->id }}">
                        @else
                            <input id="received_id" type="hidden" name="received_id" value="{{ $other->id }}">
                            <input id="emits_id" type="hidden" name="emits_id" value="{{ $other_r->id }}">
                        @endif
                        @if ($errors->has('content'))
                            <span class="error">
                                {{ $errors->first('content') }}
                            </span>
                        @endif
                        <button type="submit">
                            Send <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            @else
                <form method="POST" action="{{ url('/messages/send') }}" enctype="multipart/form-data" class="message-form">
                    {{ csrf_field() }}
                    <div class="message-input-container">
                        <input id="content" type="text" name="content" placeholder="Write message..."
                            style="color: white;" required autofocus>
                        <input id="received_id" type="hidden" name="received_id" value="{{ request()->route('id') }}">
                        <input id="emits_id" type="hidden" name="emits_id" value="{{ Auth::user()->id }}">
                        <div id="message-identifier" data-message-id="{{ Auth::user()->id }}"></div>
                        <div id="user-identifier" data-user-id="{{ request()->route('id') }}"></div>

                        <button type="submit">
                            Send <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
            @endif
        </div>
    </div>

    @include('partials.footer')
@endsection