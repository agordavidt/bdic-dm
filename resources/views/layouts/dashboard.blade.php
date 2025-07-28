<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'BDSMS') }} - @yield('title', 'Dashboard')</title>


     
    
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('backend/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    
    <!-- Plugin CSS for specific pages -->
    <link rel="stylesheet" href="{{ asset('backend/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/js/select.dataTables.min.css') }}">

     <!-- Custom CSS -->
     <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.png') }}" />

    <style>
        
    </style>
    
  
    
    @stack('styles')
</head>
<body class="with-welcome-text">
    <div class="container-scroller">
        <!-- Promotional Banner (Optional) -->
      
        
        <!-- Navigation Bar -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <div class="me-3">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                </div>
                <div>
                    <a class="navbar-brand brand-logo" href="#">
                        <!-- <img src="{{ asset('backend/images/logo.svg') }}" alt="BDSMS Logo" /> -->
                        <span class="navbar-brand-text ms-2">BDSMS</span>
                    </a>
                    <a class="navbar-brand brand-logo-mini" href="#">
                        <img src="{{ asset('backend/images/logo-mini.svg') }}" alt="BDSMS" />
                    </a>
                </div>
            </div>
            
            <div class="navbar-menu-wrapper d-flex align-items-top">
                <!-- Welcome Message -->
                <ul class="navbar-nav">
                    <li class="nav-item fw-semibold d-none d-lg-block ms-0">
                        <h1 class="welcome-text">
                            @php
                                $hour = date('H');
                                $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
                            @endphp
                            {{ $greeting }}, 
                            <span class="text-black fw-bold">{{ Auth::user()->name ?? 'User' }}</span>
                        </h1>
                        <h3 class="welcome-sub-text">{{ Auth::user()->role ?? 'User' }} Dashboard - @yield('page_description', 'Manage your devices and system')</h3>
                    </li>
                </ul>
                
                <!-- Right Side Navigation -->
                <ul class="navbar-nav ms-auto">
                    <!-- Category Dropdown (Role-based) -->
                  
                    
                    <!-- Date Picker -->
                    <li class="nav-item d-none d-lg-block">
                        <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                            <span class="input-group-addon input-group-prepend border-right">
                                <span class="icon-calendar input-group-text calendar-icon"></span>
                            </span>
                            <input type="text" class="form-control">
                        </div>
                    </li>
                    
                    <!-- Search -->
                    <li class="nav-item">
                        <form class="search-form" action="#" method="GET">
                            <i class="icon-search"></i>
                            <input type="search" name="q" class="form-control" placeholder="Search devices, users..." title="Search here">
                        </form>
                    </li>                   
                   
                </ul>
                
                <!-- Mobile Menu Toggle -->
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        
        <!-- Page Body Wrapper -->
        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="#">
                            <i class="mdi mdi-grid-large menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- Role-based Navigation -->
                    @auth
                        @php
                            $role = auth()->user()->role;
                        @endphp
                        
                        @if($role == 'admin')
                            @include('partials.sidebars.admin')
                        @elseif($role == 'vendor')
                            @include('partials.sidebars.vendor')
                        @elseif($role == 'buyer')
                            @include('partials.sidebars.buyer')
                        @elseif($role == 'manufacturer')
                            @include('partials.sidebars.manufacturer')
                        @else
                            @include('partials.sidebars.common')
                        @endif
                    @endauth                   
                    
                </ul>
            </nav>
            
            <!-- Main Panel -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-alert-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-alert me-2"></i>
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-information me-2"></i>
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Page Content -->
                    <div class="row">
                        <div class="col-sm-12">
                            @hasSection('page_header')
                                <div class="home-tab">
                                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                                        @yield('page_header')
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Main Content -->
                            @yield('content')
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                            © {{ date('Y') }} Benue State Device Management System. All rights reserved.
                        </span>
                        <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">
                            Developed by <a href="#" target="_blank">BDSMS Team</a>
                        </span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('backend/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    
    <!-- Plugin JS for specific pages -->
    <script src="{{ asset('backend/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('backend/vendors/progressbar.js/progressbar.min.js') }}"></script>
    
    <!-- Main JS -->
    <script src="{{ asset('backend/js/off-canvas.js') }}"></script>
    <script src="{{ asset('backend/js/template.js') }}"></script>
    <script src="{{ asset('backend/js/settings.js') }}"></script>
    <script src="{{ asset('backend/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('backend/js/todolist.js') }}"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('backend/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/js/dashboard.js') }}"></script>
    
    @stack('scripts')
</body>
</html>