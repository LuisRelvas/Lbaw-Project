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
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection