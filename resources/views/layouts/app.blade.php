<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.png') }}"/>

        <!-- Fonts -->

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/22dad4dcbd.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark">
        {{-- @include('layouts.navigation') --}}

        <!-- Page Heading -->
        <div class="container">
            <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
                <span class="d-flex align-items-center col-md-1 mb-2 mb-md-0">
                    <a href="{{ route('app.index') }}">
                        <img src="{{ asset('img/favicon.png') }}" alt="logo">
                    </a>
                </span>

                <div class="col-12 col-md-8 mb-2 mb-md-0 row">
                    <form class="col-10 col-md-5 mb-2 justify-content-center mb-md-0">
                        <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
                    </form>

                    <div class="col-2 col-md-1 my-auto dropdown text-end">
                        <a href="#" class="d-block text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('img/down_arrow.png') }}" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small">
                            <li><a class="dropdown-item" href="#">Random</a></li>
                            <li><a class="dropdown-item" href="#">Genres</a></li>
                            <li><a class="dropdown-item" href="#">Authors</a></li>
                            <li><hr class="dropdown-divider"></li>
                            @auth
                                <li><a class="dropdown-item" href="{{ route('manga.create') }}">Upload</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endauth
                            <li><a class="dropdown-item" href="#">Info</a></li>
                        </ul>
                    </div>
            
                </div>

                @auth
                    <div class="col-md-3 dropdown text-end">
                        <a href="#" class="d-block text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (isset($user))
                                {{ $user->name }}
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end text-small">
                            <li><a class="dropdown-item" href="{{ route('user.profile', Auth::id()) }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                @else
                    <div class="col-md-3 text-end">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Sign-up</a>
                    </div>
                @endauth
        
            </header>
          </div>

        <!-- Page Content -->
        <main class="container text-white">
            @yield('content')
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
