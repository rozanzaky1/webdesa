<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Resmi Kampung Kedaton Sari">
    <title>@yield('title', 'Beranda') - Kampung Badran Sari</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-lampung-tengah.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-lampung-tengah.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
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
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
            line-height: 1.3;
        }
        
        .brand-location {
            font-size: 0.75rem;
            font-weight: 400;
            color: rgba(255,255,255,0.85);
            margin-top: 2px;
            line-height: 1.2;
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
            display: flex;
            align-items: center;
            white-space: nowrap;
        }
        
        .navbar-nav .nav-link i {
            margin-right: 8px;
            font-size: 0.9rem;
            width: 16px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
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
            margin-left: 6px;
            vertical-align: middle;
        }
        
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border: none;
            margin-top: 10px;
            animation: slideDown 0.3s ease;
            min-width: 200px;
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
            display: flex;
            align-items: center;
        }
        
        .dropdown-item:hover {
            background: rgba(45, 80, 22, 0.1);
            padding-left: 25px;
        }
        
        .dropdown-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-login i {
            font-size: 0.9rem;
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
            .navbar-custom {
                padding: 0.3rem 0;
            }
            .navbar-nav .nav-link {
                margin: 5px 0;
                justify-content: flex-start;
                padding: 10px 16px !important;
            }
            .navbar-collapse {
                margin-top: 15px;
                padding: 15px 0;
                border-top: 1px solid rgba(255,255,255,0.2);
            }
            .btn-login {
                margin-top: 10px;
                display: inline-flex;
                width: 100%;
                justify-content: center;
            }
            .brand-name {
                font-size: 1.1rem;
            }
            .brand-location {
                font-size: 0.7rem;
            }
            .navbar-brand img {
                height: 45px;
                width: 45px;
                margin-right: 12px;
            }
            .dropdown-menu {
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
        }
        
        @media (max-width: 768px) {
            .brand-name {
                font-size: 1rem;
            }
            .brand-location {
                font-size: 0.65rem;
            }
            .navbar-brand img {
                height: 40px;
                width: 40px;
                margin-right: 10px;
            }
        }
        
        @media (max-width: 576px) {
            .navbar-custom {
                padding: 0.25rem 0;
            }
            .brand-name {
                font-size: 0.9rem;
                line-height: 1.2;
            }
            .brand-location {
                font-size: 0.6rem;
            }
            .navbar-brand img {
                height: 35px;
                width: 35px;
                margin-right: 8px;
            }
            .navbar-nav .nav-link {
                font-size: 0.9rem;
                padding: 8px 12px !important;
            }
            .navbar-nav .nav-link i {
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 360px) {
            .brand-name {
                font-size: 0.85rem;
            }
            .brand-location {
                font-size: 0.55rem;
            }
            .navbar-brand img {
                height: 32px;
                width: 32px;
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
            font-size: 1.1rem;
        }
        
        .footer p, .footer ul {
            font-size: 0.95rem;
            line-height: 1.8;
        }
        
        .footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .footer a:hover {
            color: #fff;
            padding-left: 5px;
        }
        
        .footer ul.list-unstyled li {
            margin-bottom: 10px;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
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
            margin-bottom: 10px;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: #fff;
            color: #2d5016 !important;
            transform: translateY(-3px);
        }
        
        /* Footer Responsive */
        @media (max-width: 768px) {
            .footer {
                padding: 40px 0 20px;
                margin-top: 40px;
            }
            .footer h5 {
                font-size: 1rem;
                margin-bottom: 15px;
            }
            .footer p, .footer ul {
                font-size: 0.9rem;
            }
            .footer .col-lg-4 {
                margin-bottom: 30px;
            }
            .footer-bottom {
                font-size: 0.85rem;
                padding-top: 15px;
                margin-top: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .footer {
                padding: 30px 0 15px;
            }
            .footer h5 {
                font-size: 0.95rem;
            }
            .footer p, .footer ul {
                font-size: 0.85rem;
            }
            .social-links a {
                width: 36px;
                height: 36px;
                margin-right: 8px;
            }
        }
        
        /* Content Spacing */
        .content-wrapper {
            min-height: calc(100vh - 400px);
        }
        
        /* Container Responsive */
        @media (max-width: 1200px) {
            .container {
                max-width: 100%;
                padding-left: 20px;
                padding-right: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
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
            display: inline-block;
        }
        
        .btn-green:hover {
            background: #4a7c2c;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 80, 22, 0.3);
        }
        
        /* Button Responsive */
        @media (max-width: 576px) {
            .btn-green {
                padding: 8px 20px;
                font-size: 0.9rem;
            }
        }
        
        /* Image Responsive */
        img {
            max-width: 100%;
            height: auto;
        }
        
        /* Table Responsive */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Card Responsive */
        .card {
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .card {
                margin-bottom: 15px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-lampung-tengah.png') }}" alt="Logo Lampung Tengah" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%232d5016%22/%3E%3Ctext x=%2250%22 y=%2260%22 font-size=%2240%22 fill=%22white%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-weight=%22bold%22%3EDS%3C/text%3E%3C/svg%3E'">
                <div class="brand-text">
                    <span class="brand-name">Kampung Badran Sari</span>
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
                            <i class="fas fa-info-circle"></i> Profil Kampung
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
                        @if(Auth::user()->role !== 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('layanan*') ? 'active' : '' }}" href="{{ route('layanan.index') }}">
                                    <i class="fas fa-file-alt"></i> Layanan
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                @if(Auth::user()->role === 'admin')
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                                    </a>
                                @else
                                    <a class="dropdown-item" href="{{ route('layanan.history') }}">
                                        <i class="fas fa-history"></i> Riwayat Pengajuan
                                    </a>
                                @endif
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
                    <h5><i class="fas fa-map-marker-alt"></i> Kampung Badran Sari</h5>
                    <p class="mb-3">Website resmi Pemerintah Kampung Badran Sari sebagai media informasi dan pelayanan kepada masyarakat.</p>
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
                        <li class="mb-2"><a href="{{ route('profil-desa') }}"><i class="fas fa-angle-right"></i> Profil Kampung</a></li>
                        <li class="mb-2"><a href="{{ route('berita.index') }}"><i class="fas fa-angle-right"></i> Berita</a></li>
                        <li class="mb-2"><a href="{{ route('lembaga-desa') }}"><i class="fas fa-angle-right"></i> Lembaga Kampung</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-phone"></i> Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt"></i> Kampung Badran Sari, Kecamatan Punggur, Kabupaten Lampung Tengah</li>
                        <li class="mb-2"><i class="fas fa-phone"></i> +62 815-4003-4883</li>
                        <li class="mb-2"><i class="fas fa-envelope"></i> kampungbadransari1@gmail.com</li>
                        <li class="mb-2"><i class="fas fa-clock"></i> Senin - Jumat: 08.00 - 14.00 WIB</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} Kampung Badran Sari. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    @stack('scripts')
</body>
</html>
