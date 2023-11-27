<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/user.css') }}" rel="stylesheet">
        <link href="{{ url('css/home.css') }}" rel="stylesheet">
        <link href="{{ url('css/space.page.css') }}" rel="stylesheet">
        <link href="{{ url('css/register-login.css') }}" rel="stylesheet">
        <link href="{{ url('css/about.css') }}" rel="stylesheet">
        <link href="{{ url('css/admin.css') }}" rel="stylesheet">
        <link href="{{ url('css/partials.css') }}" rel="stylesheet">
        <link href="{{ url('css/groups.css') }}" rel="stylesheet">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
            
        </script>
    </head>
    <body>
    <main>
        <header>
            <h1>
                <a href="{{ Auth::check() && Auth::user()->isAdmin(Auth::user()) ? url('/admin') : url('/homepage') }}"><mark class="sport">Sport</mark><mark class="hub">HUB</mark></a>
            </h1>
            @if (Auth::check())
                <a class="button" href="{{ url('/logout') }}"> Logout </a> 
                <a class="button" href="{{ url('/profile/'.Auth::user()->id) }}"><span>{{ Auth::user()->name }}</span></a>
            @else 
                <a class="button" href="{{ url('/login') }}"> Login </a> 
                <a class="button" href="{{ url('/register') }}"> Register </a>
            @endif
        </header>
        <section id="content">
            @yield('content')
        </section>
    </main>
</body>
</html>