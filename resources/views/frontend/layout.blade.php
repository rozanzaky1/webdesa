<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Resmi Desa Badran Sari">
    <title>@yield('title', 'Beranda') - Desa Badran Sari</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Navbar Styling */
        .navbar-custom {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            padding: 0.5rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            color: #fff !important;
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
        }
        
        .navbar-brand img {
            height: 50px;
            width: 50px;
            margin-right: 15px;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: rotate(10deg) scale(1.05);
        }
        
        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .brand-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
        }
        
        .brand-location {
            font-size: 0.75rem;
            font-weight: 400;
            color: rgba(255,255,255,0.85);
            margin-top: -2px;
        }
        
        .navbar-nav {
            align-items: center;
        }
        
        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 5px;
            padding: 8px 16px !important;
            transition: all 0.3s ease;
            border-radius: 8px;
            position: relative;
        }
        
        .navbar-nav .nav-link i {
            margin-right: 6px;
            font-size: 0.9rem;
        }
        
        .navbar-nav .nav-link:hover {
            background: rgba(255,255,255,0.2);
            color: #fff !important;
            transform: translateY(-1px);
        }
        
        .navbar-nav .nav-link.active {
            background: rgba(255,255,255,0.25);
            color: #fff !important;
            font-weight: 600;
        }
        
        .navbar-nav .dropdown-toggle::after {
            margin-left: 8px;
        }
        
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border: none;
            margin-top: 10px;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        
        .dropdown-item:hover {
            background: rgba(45, 80, 22, 0.1);
            padding-left: 25px;
        }
        
        .dropdown-item i {
            margin-right: 10px;
            width: 20px;
        }
        
        .btn-login {
            background: #fff;
            color: #2d5016;
            font-weight: 600;
            padding: 8px 24px;
            border-radius: 25px;
            transition: all 0.3s ease;
            border: 2px solid #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .btn-login:hover {
            background: transparent;
            color: #fff;
            border-color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255,255,255,0.3);
        }
        
        /* Responsive Navbar */
        @media (max-width: 991px) {
            .navbar-nav .nav-link {
                margin: 5px 0;
            }
            .btn-login {
                margin-top: 10px;
                display: inline-block;
            }
            .brand-name {
                font-size: 1.1rem;
            }
            .brand-location {
                font-size: 0.7rem;
            }
        }
        
        /* Footer Styling */
        .footer {
            background: linear-gradient(135deg, #1a3d0f 0%, #2d5016 100%);
            color: #fff;
            padding: 50px 0 20px;
            margin-top: 60px;
        }
        
        .footer h5 {
            font-weight: 700;
            margin-bottom: 20px;
            color: #fff;
        }
        
        .footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .footer a:hover {
            color: #fff;
            padding-left: 5px;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
            color: rgba(255,255,255,0.7);
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: #fff;
            color: #2d5016 !important;
            transform: translateY(-3px);
        }
        
        /* Content Spacing */
        .content-wrapper {
            min-height: calc(100vh - 400px);
        }
        
        /* Utility Classes */
        .text-green {
            color: #2d5016;
        }
        
        .bg-green {
            background: #2d5016;
        }
        
        .btn-green {
            background: #2d5016;
            color: #fff;
            border: none;
            padding: 10px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-green:hover {
            background: #4a7c2c;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 80, 22, 0.3);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-desa.png') }}" alt="Logo Desa" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%232d5016%22/%3E%3Ctext x=%2250%22 y=%2260%22 font-size=%2240%22 fill=%22white%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-weight=%22bold%22%3EDS%3C/text%3E%3C/svg%3E'">
                <div class="brand-text">
                    <span class="brand-name">Desa Badran Sari</span>
                    <span class="brand-location">Kec. Punggur, Kab. Lampung Tengah</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"><i class="fas fa-bars text-white"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('profil-desa') ? 'active' : '' }}" href="{{ route('profil-desa') }}">
                            <i class="fas fa-info-circle"></i> Profil Desa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('lembaga-desa') ? 'active' : '' }}" href="{{ route('lembaga-desa') }}">
                            <i class="fas fa-building"></i> Lembaga
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('berita*') ? 'active' : '' }}" href="{{ route('berita.index') }}">
                            <i class="fas fa-newspaper"></i> Berita
                        </a>
                    </li>
                    
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('layanan*') ? 'active' : '' }}" href="{{ route('layanan.index') }}">
                                <i class="fas fa-file-alt"></i> Layanan
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                @if(Auth::user()->role === 'admin')
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                                    </a>
                                    <div class="dropdown-divider"></div>
                                @endif
                                <a class="dropdown-item" href="{{ route('layanan.history') }}">
                                    <i class="fas fa-history"></i> Riwayat Pengajuan
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item ml-2">
                            <a href="{{ route('login') }}" class="btn btn-login">
                                <i class="fas fa-sign-in-alt"></i> Masuk
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-map-marker-alt"></i> Desa Badran Sari</h5>
                    <p class="mb-3">Website resmi Pemerintah Desa Badran Sari sebagai media informasi dan pelayanan kepada masyarakat.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-link"></i> Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}"><i class="fas fa-angle-right"></i> Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('profil-desa') }}"><i class="fas fa-angle-right"></i> Profil Desa</a></li>
                        <li class="mb-2"><a href="{{ route('berita.index') }}"><i class="fas fa-angle-right"></i> Berita</a></li>
                        <li class="mb-2"><a href="{{ route('lembaga-desa') }}"><i class="fas fa-angle-right"></i> Lembaga Desa</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-phone"></i> Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt"></i> Desa Badran Sari, Kecamatan XXX</li>
                        <li class="mb-2"><i class="fas fa-phone"></i> (0274) 123-4567</li>
                        <li class="mb-2"><i class="fas fa-envelope"></i> info@badransari.desa.id</li>
                        <li class="mb-2"><i class="fas fa-clock"></i> Senin - Jumat: 08.00 - 16.00 WIB</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} Desa Badran Sari. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
