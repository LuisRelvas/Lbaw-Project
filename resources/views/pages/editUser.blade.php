@extends('layouts.app')

@section('content')
<form method="POST" action="{{ url('profile/edit') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" >
    @if ($errors->has('name'))
      <span class="error">
          {{ $errors->first('name') }}
      </span>
    @endif

    <label for="email">E-Mail Address</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" >
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <label for="is_public">Private Profile</label>
<input id="is_public" type="hidden" name="is_public" value="0">
<input id="is_public" type="checkbox" name="is_public" value="1" {{ old('is_public') !== null ? 'checked' : '' }}>
@if ($errors->has('is_public'))
  <span class="error">
      {{ $errors->first('is_public') }}
  </span>
@endif

    <div>
    <button type="submit">
      Edit
    </button>
    </div>
</form>

@endsection