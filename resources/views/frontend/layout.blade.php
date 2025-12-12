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
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff !important;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand img {
            height: 45px;
            margin-right: 12px;
        }
        
        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            margin: 0 8px;
            padding: 8px 16px !important;
            transition: all 0.3s;
            border-radius: 5px;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff !important;
        }
        
        .btn-login {
            background: #fff;
            color: #2d5016;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 25px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
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
                <img src="{{ asset('images/logo-desa.png') }}" alt="Logo" onerror="this.src='https://via.placeholder.com/45x45/2d5016/ffffff?text=DS'">
                Desa Badran Sari
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"><i class="fas fa-bars text-white"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto align-items-center">
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
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('peta-desa') ? 'active' : '' }}" href="{{ route('peta-desa') }}">
                            <i class="fas fa-map-marked-alt"></i> Peta
                        </a>
                    </li>
                    
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('layanan*') ? 'active' : '' }}" href="{{ route('layanan.index') }}">
                                <i class="fas fa-file-alt"></i> Layanan
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
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
                                <form action="{{ route('logout') }}" method="POST">
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
