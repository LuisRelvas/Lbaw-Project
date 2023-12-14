@extends('layouts.app')

@section('content')
    <main class="flex-container">
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
                    </ul>
                </div>
            </div>
        </div>
    @include('partials.sideSearchbar')
    </main>
    @include('partials.footer')
@endsection
