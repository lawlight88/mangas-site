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
                <li><a class="dropdown-item" href="{{ route('app.scans') }}">Scans</a></li>
                <li><hr class="dropdown-divider"></li>
                @auth
                    @can('adminAllScans', \App\Models\Scanlator::class)
                        <li><a class="dropdown-item" href="{{ route('scan.all') }}">Admin - Scans</a></li>
                    @endcan
                    @can('create', \App\Models\Scanlator::class)
                        <li><a class="dropdown-item" href="{{ route('scan.create') }}">Create Scan</a></li>
                    @elsecan('view', App\Models\Scanlator::class)
                        <li><a class="dropdown-item" href="{{ route('scan.view', Auth::user()->scanlator) }}">Scan</a></li>
                    @endcan
                    <li><hr class="dropdown-divider"></li>
                @endauth
                <li><a class="dropdown-item" href="#">Info</a></li>
            </ul>
        </div>

    </div>

    @auth
        <div class="col-md-3 dropdown text-end">
            <a href="#" class="d-block text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                @if (Auth::check())
                    {{ Auth::user()->name }}
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