<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BDIC Device Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --secondary-color: #10b981;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --danger-color: #ef4444;
            --text-color: #374151;
            --text-light: #6b7280;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
        }

        .logo a {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            text-decoration: none;
        }

        .nav-links a {
            margin-left: 1.5rem;
            text-decoration: none;
            color: var(--text-light);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 4rem 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
            border-radius: 0.5rem;
            margin-bottom: 3rem;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
        }

        .hero p {
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 2.5rem;
            color: var(--text-light);
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            margin-left: 1rem;
        }

        .btn-secondary:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        /* Features Section */
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .feature-card {
            background: white;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .feature-card p {
            color: var(--text-light);
        }

        /* Footer */
        .footer {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .footer-content {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1rem;
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: var(--text-light);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .footer-text {
            color: var(--text-light);
            font-size: 0.875rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .btn {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
                text-align: center;
            }

            .btn-secondary {
                margin-left: 0;
            }

            .footer-content {
                text-align: center;
            }

            .footer-links {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="logo">
                <a href="/">BDIC DMS</a>
            </div>
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <section class="hero">
            <h1>Welcome to BDIC Device Management System</h1>
            <p>
                Your comprehensive platform for tracking, managing, and supporting devices throughout their entire lifecycle.
                Empowering vendors, protecting buyers, and providing BDIC management with actionable insights.
            </p>
            <div class="cta-buttons">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Already a Member?</a>
                @endauth
            </div>
        </section>

        <section class="features">
            <h2 class="section-title">Key Features at a Glance</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h3>Device Lifecycle Tracking</h3>
                    <p>Vendors can easily register devices with unique identifiers and comprehensive details, ensuring end-to-end traceability from sale to after-sales support.</p>
                </div>

                <div class="feature-card">
                    <h3>Enhanced Security & Support</h3>
                    <p>Buyers can report faults and even flag stolen devices, enabling swift support, remote tracking, and shutdown capabilities for Android/Windows devices.</p>
                </div>

                <div class="feature-card">
                    <h3>Sales Analytics & Vendor Performance</h3>
                    <p>BDIC management gains real-time insights into vendor sales, performance metrics, and geographical market demand, all integrated with BDIC Cloud Storage.</p>
                </div>

                <div class="feature-card">
                    <h3>Seamless E-commerce Integration</h3>
                    <p>Vendors can list devices for direct customer purchases through a secure e-commerce platform, expanding reach and simplifying transactions.</p>
                </div>
            </div>
        </section>

        <footer class="footer">
            <div class="footer-content">
                <div class="footer-links">
                    <a href="mailto:support@bdic.com">Contact Support</a>
                </div>
                <p class="footer-text">Powered by BDIC</p>
            </div>
        </footer>
    </div>
</body>
</html>
