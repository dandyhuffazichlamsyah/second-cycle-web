<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'SecondCycle')</title>

    <!-- CSRF Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- CSS Libraries -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vanilla-tilt.css') }}">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/modern.css') }}" rel="stylesheet">
    
    <!-- Splide CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  </head>

  <body>
    <!-- Preloader -->
    <div id="preloader">
      <div class="spinner-minimal"></div>
    </div>

    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
          </button>

          <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Second Cycle logo" style="width: 250px; height: 50px;">
          </a>

          <div class="d-lg-none">
            @guest
              <a href="{{ route('login') }}" class="bi-person custom-icon me-3"></a>
            @else
              <div class="dropdown">
                <a class="me-3 dropdown-toggle d-inline-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                  @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar_url }}" alt="Profile" class="rounded-circle border border-2 border-white shadow-sm" style="width: 35px; height: 35px; object-fit: cover;">
                  @else
                    <i class="bi-person custom-icon"></i>
                  @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><h6 class="dropdown-header">{{ auth()->user()->name }}</h6></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                      <i class="fas fa-user me-2"></i> Profil Saya
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                      <i class="fas fa-shopping-bag me-2"></i> Pesanan Saya
                    </a>
                  </li>
                  @if(auth()->user()->hasAdminAccess())
                  <li>
                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                      <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
                    </a>
                  </li>
                  @endif
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Keluar
                      </button>
                    </form>
                  </li>
                </ul>
              </div>
            @endguest
          </div>

          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Utama</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Kisah Kami</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk Kami</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('workshops') ? 'active' : '' }}" href="{{ route('workshops') }}">Diler & WorkShop Kami</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}" href="{{ route('faq') }}">Pusat Bantuan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.show') }}">Kontak</a>
              </li>
            </ul>

            <div class="d-none d-lg-block">
              @guest
                <a href="{{ route('login') }}" class="bi-person custom-icon me-3"></a>
              @else
                <div class="dropdown">
                  <a class="me-3 dropdown-toggle d-inline-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                    @if(auth()->user()->avatar)
                      <img src="{{ auth()->user()->avatar_url }}" alt="Profile" class="rounded-circle border border-2 border-white shadow-sm" style="width: 35px; height: 35px; object-fit: cover;">
                    @else
                      <i class="bi-person custom-icon"></i>
                    @endif
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">{{ auth()->user()->name }}</h6></li>
                    <li><span class="dropdown-item-text small text-muted">{{ auth()->user()->email }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user me-2"></i> Profil Saya
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('orders.index') }}">
                        <i class="fas fa-shopping-bag me-2"></i> Pesanan Saya
                      </a>
                    </li>
                    @if(auth()->user()->hasAdminAccess())
                    <li>
                      <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
                      </a>
                    </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                          <i class="fas fa-sign-out-alt me-2"></i> Keluar
                        </button>
                      </form>
                    </li>
                  </ul>
                </div>
              @endguest
            </div>
          </div>
        </div>
      </nav>

    <main>
      @yield('content')
    </main>

    <footer class="site-footer">
      <div class="container">
        <div class="row g-4 mb-5">
          <div class="col-lg-5 col-md-6">
            <h5 class="fw-bold mb-3">SecondCycle</h5>
            <p class="text-muted pe-lg-5">Platform terpercaya untuk menemukan motor bekas berkualitas dengan garansi dan inspeksi mendalam. Berkendara aman, nyaman, dan penuh gaya.</p>
          </div>
          <div class="col-lg-3 col-md-6">
            <h5 class="fw-bold mb-3">Tautan Cepat</h5>
            <ul class="list-unstyled">
              <li class="mb-2"><a href="{{ route('home') }}" class="site-footer-link">Utama</a></li>
              <li class="mb-2"><a href="{{ route('about') }}" class="site-footer-link">Kisah Kami</a></li>
              <li class="mb-2"><a href="{{ route('products.index') }}" class="site-footer-link">Produk Kami</a></li>
              <li class="mb-2"><a href="{{ route('workshops') }}" class="site-footer-link">Bengkel & Diler</a></li>
            </ul>
          </div>
          <div class="col-lg-4 col-md-12">
            <h5 class="fw-bold mb-3">Kontak & Lokasi</h5>
            <ul class="list-unstyled text-muted">
              <li class="mb-2"><i class="ri-map-pin-line me-2 text-primary"></i> Jl. Raya Otomotif No. 45, Jakarta Selatan</li>
              <li class="mb-2"><i class="ri-phone-line me-2 text-primary"></i> +62 812-3456-7890</li>
              <li class="mb-2"><i class="ri-mail-line me-2 text-primary"></i> support@secondcycle.com</li>
            </ul>
          </div>
        </div>
        <hr class="opacity-10 my-4">
        <div class="row">
          <div class="col-md-6 text-center text-md-start">
            <p class="mb-0 text-muted">© {{ date('Y') }} SecondCycle. All rights reserved.</p>
          </div>
          <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
            <a href="#" class="site-footer-link me-3"><i class="ri-instagram-line"></i></a>
            <a href="#" class="site-footer-link me-3"><i class="ri-facebook-line"></i></a>
            <a href="#" class="site-footer-link"><i class="ri-twitter-line"></i></a>
          </div>
        </div>
      </div>
    </footer>

    @yield('modals')

    <!-- JavaScript Libraries -->
    <!-- jQuery (required by Slick and some custom scripts) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-K+ctZQ+YdBVn0r12gKx6Nq35p3xNmPR9U1FVLtZLkKU=" crossorigin="anonymous"></script>

    <!-- Core libraries -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.1/dist/vanilla-tilt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16/dist/smooth-scroll.polyfills.min.js"></script>
    
    <!-- Custom JS -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const preloader = document.getElementById('preloader');
        const content = document.querySelector('main');
        
        // Hide preloader when everything is loaded
        window.addEventListener('load', function() {
          if (preloader) {
            preloader.style.opacity = '0';
            preloader.style.transition = 'opacity 0.4s ease';
            setTimeout(() => {
              preloader.style.display = 'none';
            }, 400);
          }
          
          if (content) {
            content.classList.add('loaded');
          }

          // Initialize AOS after page load
          if (typeof AOS !== 'undefined') {
            AOS.init({
              duration: 800,
              once: true,
              easing: 'ease-in-out',
              offset: 100
            });
          }
        });
        
        // Navbar scrolled state
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', function() {
          if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
          } else {
            navbar.classList.remove('scrolled');
          }
        });
      });
    </script>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  </body>
</html>
