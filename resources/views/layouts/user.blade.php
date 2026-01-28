<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard User')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-lampung-tengah.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-lampung-tengah.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background: #0f7b2a;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 18px;
        }
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
        }
        .nav-link:hover {
            color: white !important;
        }
        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .btn-logout:hover {
            background: rgba(255,255,255,0.3);
            color: white;
        }
        
        /* Responsive User Dashboard */
        @media (max-width: 991px) {
            .navbar-brand {
                font-size: 16px;
            }
            .nav-link {
                padding: 0.5rem 1rem;
            }
            .navbar-collapse {
                margin-top: 1rem;
                padding: 1rem 0;
                border-top: 1px solid rgba(255,255,255,0.2);
            }
        }
        
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 15px;
            }
            .navbar-brand i {
                font-size: 14px;
            }
            main.py-4 {
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }
        }
        
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 14px;
            }
            .nav-link {
                font-size: 0.9rem;
            }
            main.py-4 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                <i class="fas fa-landmark me-2"></i>
                SID - Kampung Badran Sari
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.submission.create') }}">
                            <i class="fas fa-plus-circle me-1"></i>Ajukan Surat
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
