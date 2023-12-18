@extends('layouts.app')

@section('content')
<script type="text/javascript" src={{ url('js/space.js') }} defer></script>

    <div class="flex-container">
        @include('partials.sidebar')

        <div class="content">
            @if ($errors->has('profile'))
                <span class="error">
                    {{ $errors->first('profile') }}
                </span>
            @endif
            @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
            @endif
            <div class="card-body">
                <ul class="card-list">
                    @if (Auth::check())
                        @php
                            $allSpaces = $publics
                                ->concat($spaces)
                                ->sortByDesc('date')
                                ->reverse();
                            $allSpaces = $allSpaces->unique('id');
                        @endphp
                        @include('partials.addSpace')

                        @foreach ($allSpaces as $space)
                            <li>
                                <div class ="card">
                                <ul>
                                    @php 
                                        $user = App\Models\User::find($space->user_id);
                                    @endphp
                                <li><img src="{{ asset($user->media()) }}" class="profile-img" width="10%"
                                    style="border-radius: 50%; padding: 1em" alt="profile media"></li>
                                <li><a href="/profile/{{ $space->user_id}}">{{ $user->username }}</a></li>
                                <li><a href="/space/{{ $space->id }}" >{{ $space->content }}</a></li>
                                <li>@if($space->media())
                                <img src="{{ asset($space->media()) }}" class="space-img" width=20% style=padding: 1em alt="profile media">
                                @endif</li>
                                @include('partials.likeSpace')

                                </ul>
                                </div>
                            </li>
                        @endforeach
                    @else
                        @foreach ($publics as $space)
                            <li><a href="/space/{{ $space->id }}" class="card">{{ $space->content }}</a></li>
                        @endforeach
                    @endif

                </ul>
            </div>

        </div>
        @include('partials.sideSearchbar')    
    </div>

    @include('partials.footer')
@endsection
