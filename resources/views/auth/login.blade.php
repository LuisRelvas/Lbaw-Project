@extends('layouts.app')

@section('content')
<div id="loginContent">
<div id="welcomePhrase">
    <p id="introText">Welcome to the world of Sports!</p>
    <button id="toggleLoginForm">Join us!</button>
</div>

    <form id="loginForm" method="POST" action="{{ route('login') }}" style="display: none;">
        {{ csrf_field() }}

        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
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

        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
        </label>

        <button type="submit">
            Login
        </button>
        <a class="button" href="{{ route('register') }}">Register</a>
        @if (session('success'))
            <p class="success">
                {{ session('success') }}
            </p>
        @endif
    </form>

    <script>
        document.getElementById('toggleLoginForm').addEventListener('click', function() {
    var form = document.getElementById('loginForm');
    var introText = document.getElementById('introText');
    var button = document.getElementById('toggleLoginForm');
    if (form.style.display === "none") {
        form.style.display = "block";
        introText.style.display = "none";
        button.style.display = "none"; // Hide the button
    } else {
        form.style.display = "none";
        introText.style.display = "block";
        button.style.display = "block"; // Show the button
    }
});
    </script>
    </div>
@endsection