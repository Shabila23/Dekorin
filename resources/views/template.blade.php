<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') Web</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        #sidebarMenu {
            height: 100vh;
            overflow-y: auto;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            position: sticky;
            top: 0;
            width: 250px;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .custom-nav .nav-link {
            color: #495057;
            font-weight: 500;
            margin-bottom: 10px;
            padding: 12px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .custom-nav .nav-link:hover {
            background-color: #0d6efd;
            color: white;
            text-decoration: none;
        }

        .custom-nav .nav-link.active {
            background-color: #0d6efd;
            color: white;
            font-weight: 700;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.5);
        }

        .custom-nav .nav-link span[data-feather] {
            stroke-width: 2.5;
            width: 20px;
            height: 20px;
            color: inherit;
        }

        body.collapsed-sidebar #sidebarMenu {
            transform: translateX(-100%);
            position: absolute;
        }

        body.collapsed-sidebar #sidebarIcon {
            transform: rotate(180deg);
        }

        #toggleSidebarBtn {
            border-radius: 20px;
            border: slategray 1px solid;
        }

        #toggleSidebarBtn span {
            transition: transform 0.3s ease;
            border-radius: 8px;
        }

        body.collapsed-sidebar #toggleSidebarBtn span {
            transform: rotate(180deg);
        }

        main {
            transition: margin-left 0.3s ease;
        }
    </style>

    @stack('css')
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-5" href="#">Dekorin Web</a>
        <button id="toggleSidebarBtn" class="btn btn-sm btn-light position-fixed" style="top: 50px; left: 100px; z-index: 1050;">
            <span id="sidebarIcon" data-feather="chevron-left"></span>
        </button>

        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" id="sidebarToggle" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span data-feather="menu"></span>
        </button>

        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="#">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-5 mt-2">
                    <ul class="nav flex-column custom-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        @if (auth()->user()->is_admin ?? false)
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/create') ? 'active' : '' }}" href="{{ route('admin.create') }}">
        <span data-feather="user-plus"></span>
        Tambah Admin
    </a>
    {{-- Tambah Admin --}}
@auth('admin')
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/create') ? 'active' : '' }}" href="{{ route('admin.create') }}">
        <span data-feather="user-plus"></span>
        Tambah Admin
    </a>
</li>
@endauth

</li>
@endif
@if (Auth::guard('admin')->check())
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/create') ? 'active' : '' }}" href="{{ route('admin.create') }}">
        <span data-feather="user-plus"></span>
        Tambah Admin
    </a>
</li><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') - Dekorin Web</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        #sidebarMenu {
            height: 100vh;
            overflow-y: auto;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            position: sticky;
            top: 0;
            width: 250px;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .custom-nav .nav-link {
            color: #495057;
            font-weight: 500;
            margin-bottom: 10px;
            padding: 12px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.3s ease;
        }

        .custom-nav .nav-link:hover,
        .custom-nav .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }

        .custom-nav .nav-link span[data-feather] {
            width: 20px;
            height: 20px;
        }

        body.collapsed-sidebar #sidebarMenu {
            transform: translateX(-100%);
            position: absolute;
        }

        body.collapsed-sidebar #sidebarIcon {
            transform: rotate(180deg);
        }

        #toggleSidebarBtn {
            border-radius: 20px;
            border: slategray 1px solid;
        }

        main {
            transition: margin-left 0.3s ease;
        }
    </style>

    @stack('css')
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-5" href="#">Dekorin Web</a>
        <button id="toggleSidebarBtn" class="btn btn-sm btn-light position-fixed" style="top: 50px; left: 100px;">
            <span id="sidebarIcon" data-feather="chevron-left"></span>
        </button>

        <div class="navbar-nav ms-auto pe-4">
            @auth('admin')
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="nav-link btn btn-link text-white" type="submit">
                    <span data-feather="log-out"></span> Logout
                </button>
            </form>
            @endauth
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            @auth('admin')
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-5 mt-2">
                    <ul class="nav flex-column custom-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                                <span data-feather="home"></span> Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/create') ? 'active' : '' }}" href="{{ route('admin.create') }}">
                                <span data-feather="user-plus"></span> Tambah Admin
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <span data-feather="users"></span> Users
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                <span data-feather="list"></span> Category
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dekorins*') ? 'active' : '' }}" href="{{ route('dekorins.index') }}">
                                <span data-feather="grid"></span> Dekorin
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                                <span data-feather="shopping-cart"></span> Transactions
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('saldo*') ? 'active' : '' }}" href="{{ route('transactions.approval') }}">
                                <span data-feather="dollar-sign"></span> Top Up Requests
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            @endauth

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            feather.replace();

            document.getElementById('toggleSidebarBtn')?.addEventListener('click', function () {
                document.body.classList.toggle('collapsed-sidebar');
            });

            document.getElementById('sidebarToggle')?.addEventListener('click', function () {
                document.getElementById('sidebarMenu').classList.toggle('show');
            });
        });
    </script>

    @stack('js')
</body>
</html>

@endif
@if (Auth::guard('admin')->check())
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/create') ? 'active' : '' }}" href="{{ route('admin.create') }}">
        <span data-feather="user-plus"></span>
        Tambah Admin
    </a>
</li>
@endif
@if (Auth::guard('admin')->check())
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/create') ? 'active' : '' }}" href="{{ route('admin.create') }}">
        <span data-feather="user-plus"></span>
        Tambah Admin
    </a>
</li>
@endif


                        @if (Route::has('users.index'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <span data-feather="file"></span>
                                Users
                            </a>
                        </li>
                        @endif
                        @if (Route::has('categories.index'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                <span data-feather="list"></span>
                                Category
                            </a>
                        </li>
                    
           @if (Route::has('dekorins.index'))
<li class="nav-item">
    <a class="nav-link {{ request()->is('dekorins*') ? 'active' : '' }}" href="{{ route('dekorins.index') }}">
        <span data-feather="grid"></span>
        Dekorin
    </a>
</li>
@endif


                        @endif
                        @if (Route::has('transactions.index'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                                <span data-feather="shopping-cart"></span>
                                Transactions
                            </a>
                        </li>
                        @endif
                        @if (Route::has('transactions.approval'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('saldo*') ? 'active' : '' }}" href="{{ route('transactions.approval') }}">
                                <span data-feather="dollar-sign"></span>
                                Top Up Requests
                            </a>
                        </li>
                        <form method="POST" action="{{ route('admin.logout') }}">
    @csrf
    <button class="nav-link btn btn-link" type="submit">
        <span data-feather="log-out"></span> Logout
    </button>
</form>

                        @endif
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            feather.replace();

            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebarMenu');
            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('show');
            });

            const toggleBtn = document.getElementById('toggleSidebarBtn');
            toggleBtn.addEventListener('click', function () {
                document.body.classList.toggle('collapsed-sidebar');
            });
        });
    </script>

    @stack('js')
</body>
</html>
