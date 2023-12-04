@extends('layouts.app')
@section('content')

    <div class="message-container">
        @include('partials.sidebar')
        <div class="message-card">
            @if (!$all->isEmpty())
                <div class="message-content">
                    @foreach ($all as $message)
                        <div class="profile">{{ $message->emits_id }}</div>
                        <div class="message">{{ $message->content }}</div>
                    @endforeach
                    @php
                        $user = Auth::user();
                        $other_r = App\Models\User::find(optional($message)->emits_id);
                        $other = App\Models\User::find(optional($message)->received_id);
                    @endphp
                </div>


                <form method="POST" action="{{ url('/messages/send') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="message-input-container">
                        <input id="content" type="text" name="content" placeholder="Write message..."
                            style="color: white;" required autofocus>
                        @if (Auth::check() && Auth::user()->id == $other->id)
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
                            Send <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            @else
                <form method="POST" action="{{ url('/messages/send') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="message-input-container">
                        <input id="content" type="text" name="content" placeholder="Write message..."
                            style="color: white;" required autofocus>
                        <input id="received_id" type="hidden" name="received_id" value="{{ request()->route('id') }}">


                        <button type="submit">
                            Send <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
            @endif
        </div>
    </div>

    @include('partials.footer')
@endsection
