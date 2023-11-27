@foreach($users as $user)
    @php
        $real = App\Models\User::findOrFail($user->emits_id);
    @endphp

    @if($real)
        <h2>
            <a href="/messages/{{$real->id}}">{{ $real->username }}</a>
        </h2>
    @endif
@endforeach