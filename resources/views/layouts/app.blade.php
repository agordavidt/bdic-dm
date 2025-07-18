<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BDIC DMS') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .main-content {
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .nav-link {
            color: #495057 !important;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-link i {
            width: 20px;
            text-align: center;
        }
        .nav-link:hover, .nav-link.active {
            color: #0d6efd !important;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 5px;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .sidebar .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="position-sticky pt-3">
                        <a class="navbar-brand p-3" href="{{ url('/') }}">
                            <i class="fas fa-microchip"></i>
                            BDIC DMS
                        </a>

                        @auth
                        <ul class="nav flex-column px-3">
                            <!-- Common Dashboard Link -->
                            @php
                                $role = auth()->user()->role;
                                $dashboardRoute = match($role) {
                                    'admin' => 'admin.dashboard',
                                    'vendor' => 'vendor.dashboard',
                                    'buyer' => 'buyer.dashboard',
                                    'manufacturer' => 'manufacturer.dashboard',
                                    default => null
                                };
                            @endphp
                            @if($dashboardRoute)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}" href="{{ route($dashboardRoute) }}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                </a>
                            </li>
                            @endif                        

                            <!-- Role-based Navigation -->
                            @if(auth()->user()->role == 'admin')
                                @include('partials.sidebars.admin')
                            @elseif(auth()->user()->role == 'vendor')
                                @include('partials.sidebars.vendor')
                            @elseif(auth()->user()->role == 'buyer')
                                @include('partials.sidebars.buyer')
                            @elseif(auth()->user()->role == 'manufacturer')
                                @include('partials.sidebars.manufacturer')
                            @endif

                            <!-- Common Profile Link -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="#">
                                    <i class="fas fa-user"></i>
                                    Profile
                                </a>
                            </li>
                        </ul>
                        @endauth
                    </div>
                </nav>

                <!-- Main content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                    <!-- User Toolbar (Top Right) -->
                    <div class="d-flex justify-content-end align-items-center pt-3 pb-2 mb-3 border-bottom">
                        @auth
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-2"></i>
                                    {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-user me-2"></i>
                                            Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-cog me-2"></i>
                                            Settings
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endauth
                    </div>

                    <!-- Content Area -->
                    <div class="content">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>