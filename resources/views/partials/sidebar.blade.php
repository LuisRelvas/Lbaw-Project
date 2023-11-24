@if (Auth::check())
    <div class="sidebar">
        <!-- Sidebar content -->
        <a href="{{ url('/homepage') }}">Home</a>
        <a href="{{ url('/search') }}">Explore</a>
        <a href="{{ url('/profile/' . Auth::user()->id) }}">Profile</a>
        <a href="{{ url('/about') }}">About Us</a>
        <a href="#">Notifications</a>
        <a href="#">Settings</a>
    </div>
@else
    <div class="sidebar">
        <!-- Sidebar content -->
        <a href="{{ url('/login') }}">Home</a>
        <a href="{{ url('/login') }}">Explore</a>
        <a href="{{ url('/login') }}">Profile</a>
        <a href="{{ url('/login') }}">About Us</a>
        <a href="{{ url('/login') }}">Notifications</a>
        <a href="{{ url('/login') }}">Settings</a>
    </div>
@endif
