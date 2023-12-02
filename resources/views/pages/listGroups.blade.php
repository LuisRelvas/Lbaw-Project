@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Groups') }}</div>
                <div class="card-body">
                    <ul class="card-list">
                        @foreach ($groups as $group)
                            <li><a href="/group/{{ $group->id }}" class="card">{{ $group->name }}</a></li>
                        @endforeach
                        @foreach ($publics as $public)
                            @if(Auth::check() && $public->user_id != Auth::user()->id)
                            <li><a href="/group/{{ $public->id }}" class="card">{{ $public->name }}</a></li>
                            @endif
                        @endforeach
                        @foreach ($members as $member)
                        @php 
                            $group = \App\Models\Group::findOrFail($member->group_id);
                        @endphp
                            @if(Auth::check())
                            <li><a href="/group/{{ $member->group_id }}" class="card">{{ $group->name}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection