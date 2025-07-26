<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | BDIC Device Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/vendors/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="site-wrap">
        <main>
            <section class="section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="@yield('auth-width', 'col-md-8 col-lg-6')">
                            <div class="card p-5 rounded-4 shadow-sm new-bg">
                                <div class="text-center mb-5">
                                    <h2 class="h2 fw-bold mb-3">@yield('auth-title')</h2>
                                    <p class="text-muted">@yield('auth-subtitle')</p>
                                </div>

                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>