@if (Auth::check())
    <div class="sidebar">
        <!-- Sidebar content -->
        <a href="{{ url('/homepage') }}" class="{{ Request::is('homepage') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Home</a>
        <a href="{{ url('/homepage/search') }}" class="{{ Request::is('homepage/search') ? 'active' : '' }}"><i class="fa-solid fa-magnifying-glass"></i> Explore</a>        <a href="{{ url('/profile/' . Auth::user()->id) }}"class="{{ Request::is('profile/*') ? 'active' : '' }}"><i class="fa-solid fa-user"></i> Profile</a>
        <a href="{{ url('/messages') }}" class="{{ Request::is('messages') ? 'active' : '' }}"><i class="fa-solid fa-envelope"></i> Messages</a>
        <a href="{{ url('/group') }}" class="{{ Request::is('group') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Groups</a>
        <a href="{{ url('/notification') }}" class="{{ Request::is('notification') ? 'active' : '' }}"><i class="fa-solid fa-bell"></i> Notifications</a>
        <a href="{{ url('/about') }}" class="{{ Request::is('about') ? 'active' : '' }}"><i class="fa-solid fa-circle-info"></i> About Us</a>
        <a href="#" class="{{ Request::is('settings') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i> Settings</a>
    </div>
@else
    <div class="sidebar">
        <!-- Sidebar content -->
        <a href="{{ url('/login') }}"><i class="fa-solid fa-house"></i> Home</a>
        <a href="{{ url('/login') }}"><i class="fa-solid fa-compass"></i> Explore</a>
        <a href="{{ url('/login') }}"><i class="fa-solid fa-user"></i> Profile</a>
        <a href="{{ url('/login') }}"><i class="fa-solid fa-envelope"></i> Messages</a>
        <a href="{{ url('/login') }}"><i class="fa-solid fa-users"></i> Groups</a>
        <a href="{{ url('/about') }}" class="{{ Request::is('about') ? 'active' : '' }}"><i class="fa-solid fa-info-circle"></i> About Us</a>
        <a href="{{ url('/login') }}"><i class="fa-solid fa-bell"></i> Notifications</a>
        <a href="{{ url('/login') }}"><i class="fa-solid fa-cog"></i> Settings</a>
    </div>
@endif
