<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BDIC Device Management and Tracking System</title>
     
    <!-- ======= Google Font =======-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- End Google Font-->
    
    <!-- ======= Styles =======-->
    <link href="{{ asset('assets/vendors/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/glightbox/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/aos/aos.css') }}" rel="stylesheet">
    <!-- End Styles-->
    
    <!-- ======= Theme Style =======-->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- End Theme Style-->
    
    <!-- ======= Apply theme =======-->
    <script>
      // Apply the theme as early as possible to avoid flicker
      (function() {
      const storedTheme = localStorage.getItem('theme') || 'light';
      document.documentElement.setAttribute('data-bs-theme', storedTheme);
      })();
    </script>
  </head>
  <body>
    
    <!-- ======= Site Wrap =======-->
    <div class="site-wrap">
      
      <!-- ======= Header =======-->
      <header class="fbs__net-navbar navbar navbar-expand-lg dark" aria-label="freebootstrap.net navbar">
        <div class="container d-flex align-items-center justify-content-between">
          
          <!-- Start Logo-->
          <a class="navbar-brand w-auto" href="/" style="font-size: 16px;">
            BDIC-DMS
          </a>
          <!-- End Logo-->
          
          <!-- Start offcanvas-->
          <div class="offcanvas offcanvas-start w-75" id="fbs__net-navbars" tabindex="-1" aria-labelledby="fbs__net-navbarsLabel">
            <div class="offcanvas-header">
              <div class="offcanvas-header-logo">
                <a class="logo-link" id="fbs__net-navbarsLabel" href="/">
                  BDIC-DMS
                </a>
              </div>
              <button class="btn-close btn-close-black" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            
            <div class="offcanvas-body align-items-lg-center">
              <ul class="navbar-nav nav me-auto ps-lg-5 mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link scroll-link active" aria-current="page" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#how-it-works">How It Works</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#services">Services</a></li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Stakeholders <i class="bi bi-chevron-down"></i></a>
                  <ul class="dropdown-menu">
                    <li><a class="nav-link scroll-link dropdown-item" href="#">BDIC Support Team</a></li>
                    <li><a class="nav-link scroll-link dropdown-item" href="#">Distributors & Marketers</a></li>
                    <li><a class="nav-link scroll-link dropdown-item" href="#">Vendors and Retailers</a></li>
                    <li><a class="nav-link scroll-link dropdown-item" href="#">End Users / Buyers</a></li>
                  </ul>
                </li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#contact">Contact</a></li>
              </ul>
            </div>
          </div>
          <!-- End offcanvas-->
          
          <div class="ms-auto w-auto">
            <div class="header-social d-flex align-items-center gap-1">
              @if (Route::has('login'))
                @auth
                  @php
                    $user = auth()->user();
                    $dashboardRoute = '';
                    switch ($user->role) {
                        case 'admin':
                            $dashboardRoute = route('admin.dashboard');
                            break;
                        case 'vendor':
                            $dashboardRoute = route('vendor.dashboard');
                            break;
                        case 'buyer':
                            $dashboardRoute = route('buyer.dashboard');
                            break;
                        case 'manufacturer':
                            $dashboardRoute = route('manufacturer.dashboard');
                            break;
                        default:
                            $dashboardRoute = '/';
                    }
                  @endphp
                  <a class="btn btn-primary py-2" href="{{ $dashboardRoute }}">Dashboard</a>
                @else
                  <a class="btn btn-primary py-2" href="{{ route('login') }}">Login</a>
                @endauth
              @endif
              
              <button class="fbs__net-navbar-toggler justify-content-center align-items-center ms-auto" data-bs-toggle="offcanvas" data-bs-target="#fbs__net-navbars" aria-controls="fbs__net-navbars" aria-label="Toggle navigation" aria-expanded="false">
                <svg class="fbs__net-icon-menu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="21" x2="3" y1="6" y2="6"></line>
                  <line x1="15" x2="3" y1="12" y2="12"></line>
                  <line x1="17" x2="3" y1="18" y2="18"></line>
                </svg>
                <svg class="fbs__net-icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </header>
      <!-- End Header-->
      
      <!-- ======= Main =======-->
      <main>
        
        <!-- ======= Hero =======-->
        <section class="hero__v6 section" id="home">
          <div class="container">
            <div class="row">
              <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="row">
                  <div class="col-lg-11"><span class="hero-subtitle text-uppercase" data-aos="fade-up" data-aos-delay="0">Benue Digital Infrastructural Company</span>
                    <h1 class="hero-title mb-3" data-aos="fade-up" data-aos-delay="100">Device Management and Tracking System with Cloud Storage</h1>
                    <p class="hero-description mb-4 mb-lg-5" data-aos="fade-up" data-aos-delay="200">A comprehensive cloud-integrated platform for managing the lifecycle of all BDIC hardware products with accountability, transparency, and data-driven decision-making.</p>
                    <div class="cta d-flex gap-2 mb-4 mb-lg-5" data-aos="fade-up" data-aos-delay="300">
                      @auth
                        @php
                          $user = auth()->user();
                          $dashboardRoute = '';
                          switch ($user->role) {
                              case 'admin':
                                  $dashboardRoute = route('admin.dashboard');
                                  break;
                              case 'vendor':
                                  $dashboardRoute = route('vendor.dashboard');
                                  break;
                              case 'buyer':
                                  $dashboardRoute = route('buyer.dashboard');
                                  break;
                              case 'manufacturer':
                                  $dashboardRoute = route('manufacturer.dashboard');
                                  break;
                              default:
                                  $dashboardRoute = '/';
                          }
                        @endphp
                        <a href="{{ $dashboardRoute }}" class="btn">Go to Dashboard</a>
                      @else
                        <a href="{{ route('login') }}" class="btn">Login</a>
                      @endauth
                      <a class="btn btn-white-outline" href="#about">Learn More 
                        <svg class="lucide lucide-arrow-up-right" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M7 7h10v10"></path>
                          <path d="M7 17 17 7"></path>
                        </svg>
                      </a>
                    </div>
                    <div class="logos mb-4" data-aos="fade-up" data-aos-delay="400">
                      <span class="logos-title text-uppercase mb-4 d-block">Trusted by businesses across Nigeria</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="hero-img">
                  <img class="img-card img-fluid" src="{{ asset('assets/images/card_exp.jpg') }}" alt="" data-aos="fade-down" data-aos-delay="600">
                  <img class="img-main img-fluid rounded-4" src="{{ asset('assets/images/hero-img.jpg') }}" alt="Hero Image" data-aos="fade-in" data-aos-delay="500">
                </div>
              </div>
            </div>
          </div>
          <!-- End Hero-->
        </section>
        <!-- End Hero-->
        
        <!-- ======= About =======-->
        <section class="about__v4 section" id="about">
          <div class="container">
            <div class="row">
              <div class="col-md-6 order-md-2">
                <div class="row justify-content-end">
                  <div class="col-md-11 mb-4 mb-md-0"><span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">About the system</span>
                    <h2 class="mb-4" data-aos="fade-up" data-aos-delay="100">Centralized Device Lifecycle Management Platform</h2>
                    <div data-aos="fade-up" data-aos-delay="200">
                      <p>The BDIC Device Management and Tracking System ensures complete oversight of hardware products from sale through after-sales support. Our platform integrates with BDIC Cloud Storage for centralized data management and real-time reporting.</p>
                      <p>By combining vendor oversight, buyer identity verification, after-sales support, and real-time reporting with cloud integration, the system empowers BDIC to efficiently manage its growing hardware ecosystem.</p>
                    </div>
                    <h4 class="small fw-bold mt-4 mb-3" data-aos="fade-up" data-aos-delay="300">Key Features</h4>
                    <ul class="d-flex flex-row flex-wrap list-unstyled gap-3 features" data-aos="fade-up" data-aos-delay="400">
                      <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i class="bi bi-check"></i></span><span class="text">Device Registration</span></li>
                      <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i class="bi bi-check"></i></span><span class="text">Distributor Management</span></li>
                      <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i class="bi bi-check"></i></span><span class="text">Buyer Tracking</span></li>
                      <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i class="bi bi-check"></i></span><span class="text">After-Sales Support</span></li>
                      <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i class="bi bi-check"></i></span><span class="text">Cloud Integration</span></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6"> 
                <div class="img-wrap position-relative">
                  <img class="img-fluid rounded-4" src="{{ asset('assets/images/about_1.jpg') }}" alt="About BDIC DMS" data-aos="fade-up" data-aos-delay="0">
                  <div class="mission-statement p-4 rounded-4 d-flex gap-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="mission-icon text-center rounded-circle"><i class="bi bi-lightbulb fs-4"></i></div>
                    <div>
                      <h3 class="text-uppercase fw-bold">Our Mission</h3>
                      <p class="fs-5 mb-0">To empower BDIC and its partners with transparent, accountable and data-driven device management throughout the product lifecycle.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End About-->
        
        <!-- ======= Features =======-->
        <section class="section features__v2" id="features">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="d-lg-flex p-5 rounded-4 content" data-aos="fade-in" data-aos-delay="0">
                  <div class="row">
                    <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="0">
                      <div class="row"> 
                        <div class="col-lg-11">
                          <div class="h-100 flex-column justify-content-between d-flex">
                            <div>
                              <h2 class="mb-4">Why Choose Our System</h2>
                              <p class="mb-5">The BDIC Device Management System represents a forward-thinking solution that ensures transparency and enhanced customer engagement throughout the product lifecycle.</p>
                            </div>
                            <div class="align-self-start"><a class="glightbox btn btn-play d-inline-flex align-items-center gap-2" href="https://www.youtube.com/watch?v=DQx96G4yHd8" data-gallery="video"><i class="bi bi-play-fill"></i> Watch Demo</a></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-7">
                      <div class="row justify-content-end">
                        <div class="col-lg-11">
                          <div class="row">
                            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="0">
                              <div class="icon text-center mb-4"><i class="bi bi-qr-code fs-4"></i></div>
                              <h3 class="fs-6 fw-bold mb-3">Unique Device Identification</h3>
                              <p>Each product registered with a unique identifier (PG or serial number) for complete traceability.</p>
                            </div>
                            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="100">
                              <div class="icon text-center mb-4"><i class="bi bi-shield-lock fs-4"></i></div>
                              <h3 class="fs-6 fw-bold mb-3">Theft Protection</h3>
                              <p>Buyers can flag stolen devices enabling tracking or remote shutdown (Android/Windows devices).</p>
                            </div>
                            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="200">
                              <div class="icon text-center mb-4"><i class="bi bi-headset fs-4"></i></div>
                              <h3 class="fs-6 fw-bold mb-3">After-Sales Support</h3>
                              <p>End users can report faults via the portal with optional image upload and real-time tracking.</p>
                            </div>
                            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="300">
                              <div class="icon text-center mb-4"><i class="bi bi-cloud-arrow-up fs-4"></i></div>
                              <h3 class="fs-6 fw-bold mb-3">Cloud Integration</h3>
                              <p>All device data, buyer records and reports backed up in BDIC Cloud Storage for analytics.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End Features-->
        
        <!-- ======= Pricing =======-->
        <section class="section pricing__v2" id="pricing">
          <div class="container">
            <div class="row mb-5">
              <div class="col-md-5 mx-auto text-center"><span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">Access Levels</span>
                <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">Role-Based System Access</h2>
                <p data-aos="fade-up" data-aos-delay="200">Multi-user environment with controlled access for different stakeholders</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="300">
                <div class="p-5 rounded-4 price-table h-100">
                  <h3>Vendors</h3>
                  <p>For device vendors and retailers to register products and manage inventory.</p>
                  <div class="price mb-4"><strong>Free</strong><span>/ registration</span></div>
                  <div>
                    @auth
                      <a class="btn" href="{{ route('vendor.dashboard') }}">Vendor Portal</a>
                    @else
                      <a class="btn" href="{{ route('login') }}">Login</a>
                    @endauth
                  </div>
                </div>
              </div>
              <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">
                <div class="p-5 rounded-4 price-table popular h-100">
                  <div class="row">
                    <div class="col-md-6">
                      <h3 class="mb-3">Distributors</h3>
                      <p>For distributors and marketers to track sales and manage vendor relationships.</p>
                      <div class="price mb-4"><strong class="me-1">Premium</strong><span>/ account</span></div>
                      <div>
                        @auth
                          <a class="btn btn-white hover-outline" href="{{ route('admin.dashboard') }}">Admin Portal</a>
                        @else
                          <a class="btn btn-white hover-outline" href="{{ route('login') }}">Login</a>
                        @endauth
                      </div>
                    </div>
                    <div class="col-md-6 pricing-features">
                      <h4 class="text-uppercase fw-bold mb-3">Features</h4>
                      <ul class="list-unstyled d-flex flex-column gap-3">
                        <li class="d-flex gap-2 align-items-start mb-0"><span class="icon rounded-circle position-relative mt-1"><i class="bi bi-check"></i></span><span>Track devices sold by each vendor</span></li>
                        <li class="d-flex gap-2 align-items-start mb-0"><span class="icon rounded-circle position-relative mt-1"><i class="bi bi-check"></i></span><span>View device distribution by location</span></li>
                        <li class="d-flex gap-2 align-items-start mb-0"><span class="icon rounded-circle position-relative mt-1"><i class="bi bi-check"></i></span><span>Access analytics on vendor performance</span></li>
                        <li class="d-flex gap-2 align-items-start mb-0"><span class="icon rounded-circle position-relative mt-1"><i class="bi bi-check"></i></span><span>Monitor market demand and product issues</span></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End Pricing-->
        
        <!-- ======= How it works =======-->
        <section class="section howitworks__v1" id="how-it-works">
          <div class="container">
            <div class="row mb-5">
              <div class="col-md-6 text-center mx-auto"><span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">How it works</span>
                <h2 data-aos="fade-up" data-aos-delay="100">Device Lifecycle Management</h2>
                <p data-aos="fade-up" data-aos-delay="200">Our platform is designed to manage hardware products from sale through after-sales support</p>
              </div>
            </div>
            <div class="row g-md-5">
              <div class="col-md-6 col-lg-3">
                <div class="step-card text-center h-100 d-flex flex-column justify-content-start position-relative" data-aos="fade-up" data-aos-delay="0">
                  <div data-aos="fade-right" data-aos-delay="500"><img class="arch-line" src="{{ asset('assets/images/arch-line.svg') }}" alt="Step 1" data-aos="fade-right" data-aos-delay="500"></div>
                  <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">1</span>
                  <div>
                    <h3 class="fs-5 mb-4">Device Registration</h3>
                    <p>Vendors register each product with unique identifier and buyer information.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
                <div class="step-card reverse text-center h-100 d-flex flex-column justify-content-start position-relative">
                  <div data-aos="fade-right" data-aos-delay="1100"><img class="arch-line reverse" src="{{ asset('assets/images/arch-line-reverse.svg') }}" alt="Step 2"></div>
                  <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">2</span>
                  <h3 class="fs-5 mb-4">Purchase Tracking</h3>
                  <p>System tracks buyer details, purchase history and device allocation.</p>
                </div>
              </div>
              <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="1200">
                <div class="step-card text-center h-100 d-flex flex-column justify-content-start position-relative">
                  <div data-aos="fade-right" data-aos-delay="1700"><img class="arch-line" src="{{ asset('assets/images/arch-line.svg') }}" alt="Step 3"></div>
                  <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">3</span>
                  <h3 class="fs-5 mb-4">After-Sales Support</h3>
                  <p>Buyers report issues via portal with real-time tracking and resolution.</p>
                </div>
              </div>
              <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="1800">
                <div class="step-card last text-center h-100 d-flex flex-column justify-content-start position-relative">
                  <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">4</span>
                  <div>
                    <h3 class="fs-5 mb-4">Analytics & Reporting</h3>
                    <p>Cloud-based analytics provide insights on sales, issues and regional trends.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End How it works-->
        
        <!-- ======= Stats =======-->
        <section class="stats__v3 section">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="d-flex flex-wrap content rounded-4" data-aos="fade-up" data-aos-delay="0">
                  <div class="rounded-borders">
                    <div class="rounded-border-1"></div>
                    <div class="rounded-border-2"></div>
                    <div class="rounded-border-3"></div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                      <h3 class="fs-1 fw-bold"><span class="purecounter" data-purecounter-start="0" data-purecounter-end="10" data-purecounter-duration="2">0</span><span>K+</span></h3>
                      <p class="mb-0">Devices Managed</p>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                      <h3 class="fs-1 fw-bold"> <span class="purecounter" data-purecounter-start="0" data-purecounter-end="200" data-purecounter-duration="2">0</span><span>%+</span></h3>
                      <p class="mb-0">Faster Issue Resolution</p>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                      <h3 class="fs-1 fw-bold"><span class="purecounter" data-purecounter-start="0" data-purecounter-end="20" data-purecounter-duration="2">0</span><span>x</span></h3>
                      <p class="mb-0">Improved Accountability</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End Stats-->
        
        <!-- ======= Services =======-->
        <section class="section services__v3" id="services">
          <div class="container">
            <div class="row mb-5">
              <div class="col-md-8 mx-auto text-center"><span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">System Features</span>
                <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">Comprehensive Device Management Solutions</h2>
              </div>
            </div>
            <div class="row g-4">
              <!-- Service cards remain the same as original -->
              <!-- Only showing one example here for brevity -->
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                <div class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                  <div><span class="icon mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewbox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                          <path d="M50.327 4H25.168a6.007 6.007 0 0 0-6 6v5.11h-8.375a3.154 3.154 0 0 0-3.12 3.18v5.47a1 1 0 0 0 .724.961 3.204 3.204 0 0 1 0 6.097 1 1 0 0 0-.724.962v5.49a3.154 3.154 0 0 0 3.12 3.18H34.5c-2.147 8.057 9.408 12.135 12.77 4.441a1 1 0 0 0-1.841-.779 4.778 4.778 0 1 1-4.403-6.636c1.039-.159 2.453 1.082 3.063-.225.449-1.37-1.383-1.598-2.336-1.734V31.8a1 1 0 0 0-.72-.96 3.21 3.21 0 0 1 0-6.11 1 1 0 0 0 .72-.96v-5.48a3.154 3.154 0 0 0-3.12-3.18H21.168V10a4.004 4.004 0 0 1 4-4h3.21l1.24 3.066a3.982 3.982 0 0 0 3.708 2.503h8.826a3.984 3.984 0 0 0 3.71-2.503L47.1 6h3.228a4.004 4.004 0 0 1 4 4v1.6a1 1 0 0 0 2 0V10a6.007 6.007 0 0 0-6-6ZM38.633 17.11a1.153 1.153 0 0 1 1.12 1.18v4.792a5.234 5.234 0 0 0 0 9.405V35.6a6.789 6.789 0 0 0-4.333 2.85H10.793a1.153 1.153 0 0 1-1.12-1.18v-4.8a5.232 5.232 0 0 0 0-9.401V18.29a1.153 1.153 0 0 1 1.12-1.18Zm5.375-8.793a1.994 1.994 0 0 1-1.856 1.252h-8.826a1.991 1.991 0 0 1-1.854-1.252l-.934-2.312H44.94Z" fill="currentColor" opacity="1" data-original="#000000"></path>
                          <path d="M55.327 14.6a1 1 0 0 0-1 1V54a4.004 4.004 0 0 1-4 4H25.168a4.004 4.004 0 0 1-4-4V43.45a1 1 0 0 0-2 0V54a6.007 6.007 0 0 0 6 6h25.16a6.007 6.007 0 0 0 6-6V15.6a1 1 0 0 0-1-1Z" fill="currentColor" opacity="1" data-original="#000000"></path>
                          <path d="M41.185 54.52a1 1 0 0 0 0-2h-6.891a1 1 0 0 0 0 2ZM24.713 28.383a.853.853 0 1 1-.835 1.028.998.998 0 0 0-1.184-.775c-1.765.61-.18 2.94 1.017 3.265-.271 1.919 2.27 1.926 2-.003a2.852 2.852 0 0 0-.998-5.515.851.851 0 1 1 .821-1.084 1 1 0 0 0 1.926-.54 2.857 2.857 0 0 0-1.749-1.893v-.518a1 1 0 0 0-2 0v.521a2.852 2.852 0 0 0 1.002 5.514Z" fill="currentColor" opacity="1" data-original="#000000"></path>
                          <path d="M24.713 36.43a9.092 9.092 0 0 0 9.082-9.082c-.499-12.047-17.666-12.045-18.163 0a9.092 9.092 0 0 0 9.08 9.082Zm0-16.163a7.09 7.09 0 0 1 7.082 7.081c-.371 9.388-13.793 9.387-14.163 0a7.09 7.09 0 0 1 7.08-7.081ZM46.413 37.53l-4.757 4.757-1.68-1.68a1 1 0 0 0-1.413 1.415l2.386 2.386a1 1 0 0 0 1.414 0l5.464-5.464a1 1 0 0 0-1.414-1.414Z" fill="currentColor" opacity="1" data-original="#000000"></path>
                        </g>
                      </svg></span>
                    <h3 class="fs-5 mb-3">Device Registration</h3>
                    <p class="mb-4">Each product sold is registered with a unique identifier (e.g., PG or serial number). Vendors must enter device details and buyer information into the system.</p>
                  </div>
                  <a class="special-link d-inline-flex gap-2 align-items-center text-decoration-none" href="#">
                    <span class="icons">
                      <i class="icon-1 bi bi-arrow-right-short"></i>
                      <i class="icon-2 bi bi-arrow-right-short"></i>
                    </span>
                    <span>Read more</span>
                  </a>
                </div>
              </div>
              <!-- Other service cards would go here -->
            </div>
          </div>
        </section>
        <!-- Services-->
        
        <!-- ======= FAQ =======-->
        <section class="section faq__v2" id="faq">
          <div class="container">
            <div class="row mb-4">
              <div class="col-md-6 col-lg-7 mx-auto text-center">
                <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">FAQ</span>
                <h2 class="h2 fw-bold mb-3" data-aos="fade-up" data-aos-delay="0">Frequently Asked Questions</h2>
                <p data-aos="fade-up" data-aos-delay="100">Find answers to common questions about the BDIC Device Management System</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8 mx-auto" data-aos="fade-up" data-aos-delay="200">
                <div class="faq-content">
                  <div class="accordion custom-accordion" id="accordionPanelsStayOpenExample">
                    <!-- FAQ items remain the same as original -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End FAQ-->
        
        <!-- ======= Contact =======-->
        <section class="section contact__v2" id="contact">
          <div class="container">
            <div class="row mb-5">
              <div class="col-md-6 col-lg-7 mx-auto text-center">
                <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">Contact</span>
                <h2 class="h2 fw-bold mb-3" data-aos="fade-up" data-aos-delay="0">Contact BDIC Support</h2>
                <p data-aos="fade-up" data-aos-delay="100">Get in touch with our support team for assistance with the Device Management System</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="d-flex gap-5 flex-column">
                  <div class="d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="icon d-block"><i class="bi bi-telephone"></i></div>
                    <span> 
                      <span class="d-block">Support Hotline</span>
                      <strong>+(234) 700-BDIC-SUPPORT</strong>
                    </span>
                  </div>
                  <div class="d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon d-block"><i class="bi bi-send"></i></div>
                    <span> 
                      <span class="d-block">Email</span>
                      <strong>support@bdic-devices.com</strong>
                    </span>
                  </div>
                  <div class="d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon d-block"><i class="bi bi-geo-alt"></i></div>
                    <span> 
                      <span class="d-block">Headquarters</span>
                      <address class="fw-bold">
                        Benue Digital Infrastructural Company<br> 
                        Makurdi, Benue State<br> 
                        Nigeria
                      </address>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-wrapper" data-aos="fade-up" data-aos-delay="300">
                  <form id="contactForm">
                    <div class="row gap-3 mb-3">
                      <div class="col-md-12">
                        <label class="mb-2" for="name">Name</label>
                        <input class="form-control" id="name" type="text" name="name" required>
                      </div>
                      <div class="col-md-12">
                        <label class="mb-2" for="email">Email</label>
                        <input class="form-control" id="email" type="email" name="email" required>
                      </div>
                    </div>
                    <div class="row gap-3 mb-3">
                      <div class="col-md-12">
                        <label class="mb-2" for="subject">Subject</label>
                        <input class="form-control" id="subject" type="text" name="subject">
                      </div>
                    </div>
                    <div class="row gap-3 gap-md-0 mb-3">
                      <div class="col-md-12">
                        <label class="mb-2" for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                      </div>
                    </div>
                    <button class="btn btn-primary fw-semibold" type="submit">Send Message</button>
                  </form>
                  <div class="mt-3 d-none alert alert-success" id="successMessage">Message sent successfully!</div>
                  <div class="mt-3 d-none alert alert-danger" id="errorMessage">Message sending failed. Please try again later.</div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End Contact-->
        
        <!-- ======= Footer =======-->
        <footer class="footer pt-5 pb-5">
          <div class="container">
            <div class="row mb-5 pb-4">
              <div class="col-md-7">
                <h2 class="fs-5">Join our newsletter</h2>
                <p>Stay updated with BDIC product updates and system enhancements</p>
              </div>
              <div class="col-md-5">
                <form class="d-flex gap-2">
                  <input class="form-control" type="email" placeholder="Email your email" required>
                  <button class="btn btn-primary fs-6" type="submit">Subscribe</button>
                </form>
              </div>
            </div>
            <div class="row justify-content-between mb-5 g-xl-5">
              <div class="col-md-4 mb-5 mb-lg-0">
                <h3 class="mb-3">About BDIC</h3>
                <p class="mb-4">Benue Digital Infrastructural Company is committed to digital infrastructure leadership through innovative solutions like the Device Management and Tracking System.</p>
              </div>
              <div class="col-md-7">
                <div class="row g-2">
                  <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <h3 class="mb-3">System</h3>
                    <ul class="list-unstyled">
                      <li><a href="#features">Features</a></li>
                      <li><a href="#how-it-works">How It Works</a></li>
                      <li><a href="#pricing">Pricing</a></li>
                      <li><a href="#">Terms &amp; Conditions</a></li>
                      <li><a href="#">Privacy Policy</a></li>
                    </ul>
                  </div>
                  <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <h3 class="mb-3">Resources</h3>
                    <ul class="list-unstyled">
                      <li><a href="#">Documentation</a></li>
                      <li><a href="#">API Access</a></li>
                      <li><a href="#">System Status</a></li>
                      <li><a href="#">Training Materials</a></li>
                    </ul>
                  </div>
                  <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 quick-contact">
                    <h3 class="mb-3">Contact</h3>
                    <p class="d-flex mb-3"><i class="bi bi-geo-alt-fill me-3"></i><span>Benue Digital Infrastructural Company<br> Makurdi, Benue State<br> Nigeria</span></p>
                    <a class="d-flex mb-3" href="mailto:info@bdic-devices.com"><i class="bi bi-envelope-fill me-3"></i><span>info@bdic-devices.com</span></a>
                    <a class="d-flex mb-3" href="tel://+234700BDICSUPPORT"><i class="bi bi-telephone-fill me-3"></i><span>+(234) 700-BDIC-SUPPORT</span></a>
                    <a class="d-flex mb-3" href="https://bdic.com"><i class="bi bi-globe me-3"></i><span>bdic.com</span></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row credits pt-3">
              <div class="col-xl-8 text-center text-xl-start mb-3 mb-xl-0">
                &copy;
                <script>document.write(new Date().getFullYear());</script> BDIC Device Management System. 
                All rights reserved. <a href="/">bdic-dms</a>
              </div>
              <div class="col-xl-4 justify-content-start justify-content-xl-end quick-links d-flex flex-column flex-xl-row text-center text-xl-start gap-1">
                Powered by <a href="https://bdic.com" target="_blank">BDIC</a>
              </div>
            </div>
          </div>
        </footer>
        <!-- End Footer-->
        
      </main>
    </div>
    
    <!-- ======= Back to Top =======-->
    <button id="back-to-top"><i class="bi bi-arrow-up-short"></i></button>
    <!-- End Back to top-->
    
    <!-- ======= Javascripts =======-->
    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/gsap/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/glightbox/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendors/purecounter/purecounter.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/send_email.js') }}"></script>
    <!-- End JavaScripts-->
  </body>
</html>