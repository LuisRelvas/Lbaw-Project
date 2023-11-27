@extends('layouts.app')

@section('content')
    <main class="flex-container">
        @include('partials.sidebar')
        <div class="grouplist-container">
            <div class="grouplist-card">
                <div class="grouplist-card-header">{{ __('Groups') }}</div>
                <div class="grouplist-card-body">
                    <ul class="grouplist-card-list">
                        @foreach ($groups as $group)
                            <li><a href="/group/{{ $group->id }}" class="card">{{ $group->name }}</a></li>
                        @endforeach
                        @foreach ($publics as $public)
                            @if (Auth::check() && $public->user_id != Auth::user()->id)
                                <li><a href="/group/{{ $public->id }}" class="card">{{ $public->name }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    
    </main>
    @include('partials.footer')
@endsection
