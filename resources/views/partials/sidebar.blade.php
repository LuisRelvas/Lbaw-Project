@if (Auth::check())
    <div class="sidebar">
        <!-- Sidebar content -->
        <a href="{{ url('/homepage') }}" class="{{ Request::is('homepage') ? 'active' : '' }}">Home</a>
        <a href="{{ url('/homepage/search') }}" class="{{ Request::is('search') ? 'active' : '' }}">Explore</a>
        <a href="{{ url('/profile/' . Auth::user()->id) }}"
            class="{{ Request::is('profile/*') ? 'active' : '' }}">Profile</a>
        <a href="{{ url('/group') }}" class="{{ Request::is('group') ? 'active' : '' }}">Groups</a>
        <a href="{{ url('/about') }}" class="{{ Request::is('about') ? 'active' : '' }}">About Us</a>
        <a href="{{ url('/notification') }}" class="{{ Request::is('notification') ? 'active' : '' }}">Notifications</a>
        <a href="#" class="{{ Request::is('settings') ? 'active' : '' }}">Settings</a>
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
