<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
?>
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/vendor/theme.min.css') }}" rel="stylesheet">


    <style>
        #sortable-1 { list-style-type: none; margin: 0;
            padding: 0; width: 25%; }
        #sortable-1 li { margin: 0 3px 3px 3px; padding: 0.4em;
            padding-left: 1.5em; font-size: 17px; height: 16px; }
        .default {
            background: #cedc98;
            border: 1px solid #DDDDDD;
            color: #333333;
        }
    </style>



    <!-- drabable head end -->




</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm">
        <div class="container">
            <a class="text-light navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'The List') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="text-light nav-item">
                    </li>
                    <li class="text-light nav-item">
                        <a class="text-light nav-link {{ Request::is('admin/user*') ? 'active' : '' }}"  href="/admin/user">User</a>
                    </li>
                    <li><a class="text-light nav-link {{Request::is('admin/recipe*') ? 'active' : ''}}" href="/admin/recipes">Rezepte</a></li>

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <a class="text-light nav-link {{Request::is('admin/shoppinglist*')  ? 'active' : '' }}"  href="/admin/shoppinglist">Shoppinglists</a>

                @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="text-light nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
        @include('inc.messages')

        @yield('content')
    </main>
</div>
<script src="{{ asset('admin/js/app.js') }}"></script>
@livewireScripts
@yield('after_script')
</body>
</html>
