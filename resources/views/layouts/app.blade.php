<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div  id="app">
<header>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @foreach (array_slice($menuPages, 0, 3) as $page)
                        <li><a class="nav-link" href="{{ route('page', page_path($page)) }}">{{ $page->getMenuTitle() }}</a></li>
                    @endforeach
                    @if ($morePages = array_slice($menuPages, 3))
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                More... <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach ($morePages as $page)
                                    <a class="dropdown-item" href="{{ route('page', page_path($page)) }}">{{ $page->getMenuTitle() }}</a>
                                @endforeach
                            </div>
                        </li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                                <a class="dropdown-item" href="{{ route('adverts.index') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('adverts').submit();">
                                    {{ __('Adverts') }}
                                </a>
                                <form id="adverts" action="{{ route('adverts.index') }}" method="GET" style="display: none;">

                                </form>

                                <a class="dropdown-item" href="{{ route('cabinet.home') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('cabinet-form').submit();">
                                    {{ __('Cabinet') }}
                                </a>
                                <form id="cabinet-form" action="{{ route('cabinet.home') }}" method="GET" style="display: none;">

                                </form>
                                @can('access-admin')
                                    <a class="dropdown-item" href="{{ route('admin.home') }}"
                                       onclick="event.preventDefault();
                                                         document.getElementById('admin-form').submit();">
                                        {{ __('Admin') }}
                                    </a>
                                    <form id="admin-form" action="{{ route('admin.home') }}" method="GET" style="display: none;">
                                    </form>
                                @endcan
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @section('search')
        @include('layouts.elements.search', ['category' => null, 'route' => route('adverts.index')])
    @show
</header>

<main class="app-content py-4">
    <div class="container">
        @if(Breadcrumbs::exists())
        @section('breadcrumbs')
            {!! Breadcrumbs::render() !!}
        @show
        @endif
        @include('layouts.elements.flash')
        @include('flash::message')
        @yield('content')
    </div>
</main>

<footer>
    <div class="container">
        <div class="border-top pt-3">
            <p>&copy; {{ date('Y') }} - Adverts</p>
        </div>
    </div>
</footer>
</div>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/broadcast.js') }}"></script>
{{--Scripts--}}
@yield('scripts')

</body>
</html>
