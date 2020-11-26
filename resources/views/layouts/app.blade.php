<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="auth_id" content="{{ auth()->id() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery.blockUI.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @if(auth()->user())
                    <a class="navbar-brand" href="{{ route('home') }}" title="redit">
                        <img src="{{ asset('logo/redit-logo.png') }}" alt="redit">
                    </a>
                    <a class="navbar-brand" href="{{ route('popular') }}" title="popular" style="color: #337ab7">
                        <i class="fas fa-fire-alt"></i>
                    </a>
                @else
                    <a class="navbar-brand" href="{{ route('popular') }}" title="redit">
                        <img src="{{ asset('logo/redit-logo.png') }}" alt="redit">
                    </a>
                @endif
                <a href="http://{{ request()->getHost() }}/chatify" title="Messages" class="mr-5 fs-16" style="color: #337ab7"><i class="fab fa-facebook-messenger"></i></a>
                <a href="{{ route('post.create') }}" title="Create Post" class="mr-5 fs-16" style="color: #337ab7"><i class="fas fa-pen"></i></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto float-right">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('user.edit') }}">
                                        <i class="far fa-user"></i> {{ __('My Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('post.my_post') }}">
                                        <i class="far fa-newspaper"></i> {{ __('My Post') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('threads.my') }}">
                                        <i class="fas fa-users-cog"></i> {{ __('My Threads') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('threads.index') }}">
                                        <i class="fas fa-users"></i> {{ __('Top Threads') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('content1')
    @yield('script')
</body>
</html>
