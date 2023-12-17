@extends('layouts.app')

@section('content')
    <div class="flex-container">
        @include('partials.sidebar')
        <div class="grouplist-container">
            <div class="grouplist-card">
                <div class="grouplist-card-header">{{ __('Groups') }}</div>
                <div class="grouplist-card-body">
                    <ul class="grouplist-card-list">
                    @include('partials.addGroup')   
                        @foreach ($all as $single)
                            @if (Auth::check())
                                <li><a href="/group/{{ $single->id }}" class="card">{{ $single->name }}</a></li>
                            @endif
                        @endforeach
                        <div class="grouplist-card-header">{{ __('New Groups') }}</div>
                        @if(isset($others))
                        @foreach($others as $other)
                            @if (Auth::check())
                                <li><a href="/group/{{ $other->id }}" class="card">{{ $other->name }}</a></li>
                            @endif
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    @include('partials.sideSearchbar')
    </div>
    @include('partials.footer')
@endsection
