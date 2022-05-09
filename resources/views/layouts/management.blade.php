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
            @include('layouts._partials.heading')
        </div>

        <div class="container">
			<div class="row">
				<aside class="col-md-2">
					<ul class="list-group">
						<li class="list-group-item list-group-item-dark-1"><a class="d-block text-decoration-none text-white text-capitalize" href="">Scans</a></li>
						{{-- <li class="list-group-item list-group-item-dark-1"><a class="d-block text-decoration-none text-white text-capitalize" href="">Scan</a></li> --}}
						<li class="list-group-item list-group-item-dark-1"><a class="d-block text-decoration-none text-white text-capitalize" href="{{ route('scan.create') }}">Create Scan</a></li>
						<li class="list-group-item list-group-item-dark-1"><a class="d-block text-decoration-none text-white text-capitalize" href="{{ route('manga.create') }}">Create Manga</a></li>
						<li class="list-group-item list-group-item-dark-1"><a class="d-block text-decoration-none text-white text-capitalize" href="">Requesting</a></li>
					</ul>
				</aside>
                <!-- Page Content -->
                <main class="col-md-10 text-white border p-4">
                    @yield('content')
                </main>
            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
