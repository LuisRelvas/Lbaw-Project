<div class="message-card">
            @if (!$all->isEmpty())
                <div id="message-identifier" data-message-id="{{ $all->first()->emits_id }}"></div>
                <div class="message-content">
                    @foreach ($all as $message)
                    <div class="message {{ $message->emits_id == Auth::user()->id ? 'my-message' : 'other-message' }}" data-message-id="{{ $message->emits_id }}">
                            @php
                                $show = App\Models\User::find($message->emits_id);
                                $minIdElement = collect($all)->min('id');
                            @endphp
                            <div class="profile">{{ $show->username }}</div>
                            <div class="body">{{ $message->content }}</div>
                            <div class="timestamp">{{ $message->date }}</div>
                        </div>
                    @endforeach
                    @php
                        $user = Auth::user();
                        $other_r = App\Models\User::find(optional($message)->emits_id);
                        $other = App\Models\User::find(optional($message)->received_id);
                        $firstMessage = App\Models\Message::where('id',$minIdElement)->get();
                    @endphp
                </div>
                <div id="user-identifier" data-user-id="{{ $firstMessage[0]->emits_id }}"></div>
                <div id="user-identifier-rec" data-user-id-rec="{{ $firstMessage[0]->received_id }}"></div>
                <form method="POST" action="{{ url('/messages/send') }}" enctype="multipart/form-data"
                    class="message-form">
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

                <div id="user-identifier" data-user-id="{{ request()->route('emits_id')}}"></div>
                <div id="user-identifier-rec" data-user-id-rec="{{ request()->route('received_id') }}"></div>
                <form method="POST" action="{{ url('/messages/send') }}" enctype="multipart/form-data"
                    class="message-form">
                    {{ csrf_field() }}
                    <div class="message-input-container">
                        <input id="content" type="text" name="content" placeholder="Write message..."
                            style="color: white;" required autofocus>
                        <input id="received_id" type="hidden" name="received_id" value="{{ request()->route('received_id') }}">
                            <input id="emits_id" type="hidden" name="emits_id" value="{{ request()->route('emits_id')}}">
                        <div id="message-identifier" data-message-id="{{ request()->route('emits_id') }}"></div>
                        <div id="user-identifier" data-user-id="{{ request()->route('received_id') }}"></div>

                        <button type="submit">
                            Send <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
            @endif
        </div>