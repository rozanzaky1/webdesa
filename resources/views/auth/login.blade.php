<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f7b2a 0%, #1a5f3a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            max-width: 450px;
            width: 100%;
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .login-header {
            background: #0f7b2a;
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        .btn-close-floating {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #0f7b2a;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s;
            padding: 12px 16px;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            text-decoration: none;
        }
        .btn-close-floating:hover {
            background: white;
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            color: #0d6524;
        }
        .login-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
        }
        .login-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .login-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .login-subtitle {
            font-size: 13px;
            opacity: 0.9;
        }
        .login-body {
            padding: 35px 30px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #0f7b2a;
            box-shadow: 0 0 0 0.2rem rgba(15, 123, 42, 0.1);
        }
        .btn-login {
            background: #0f7b2a;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #0d6524;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(15, 123, 42, 0.3);
        }
        .form-check-input:checked {
            background-color: #0f7b2a;
            border-color: #0f7b2a;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .invalid-feedback {
            font-size: 13px;
        }
    </style>
</head>
<body>
    <a href="{{ route('home') }}" class="btn-close-floating" title="Kembali ke Beranda">
        <i class="fas fa-times"></i>
    </a>
    
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <img src="{{ asset('images/logo-lampung-tengah.png') }}" alt="Logo Lampung Tengah">
                </div>
                <div class="login-title">Sistem Informasi</div>
                <div class="login-subtitle">Kampung Badran Sari - Kec. Punggur - Kab. Lampung Tengah</div>
            </div>
            <div class="login-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Masukkan email"
                               required 
                               autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Masukkan password"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #0f7b2a;">
                            Daftar disini
                        </a>
                    </small>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <small class="text-white">
                © 2025 Kampung Badran Sari. All rights reserved.
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
