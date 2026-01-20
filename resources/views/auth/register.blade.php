<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Informasi Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f7b2a 0%, #1a5f3a 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px 0;
        }
        .register-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .register-header {
            background: #0f7b2a;
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        .register-logo {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-logo i {
            font-size: 35px;
            color: #0f7b2a;
        }
        .register-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .register-subtitle {
            font-size: 14px;
            opacity: 0.9;
        }
        .register-body {
            padding: 35px 30px;
            max-height: 75vh;
            overflow-y: auto;
        }
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f7b2a;
            margin: 25px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #0f7b2a;
        }
        .section-title:first-child {
            margin-top: 0;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-label .required {
            color: #dc3545;
        }
        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0f7b2a;
            box-shadow: 0 0 0 0.2rem rgba(15, 123, 42, 0.1);
        }
        .btn-register {
            background: #0f7b2a;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            font-size: 16px;
            position: sticky;
            bottom: 0;
        }
        .btn-register:hover {
            background: #0d6524;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(15, 123, 42, 0.3);
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .invalid-feedback {
            font-size: 13px;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }
        .login-link a {
            color: #0f7b2a;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="register-logo">
                    <i class="fas fa-landmark"></i>
                </div>
                <div class="register-title">PENDAFTARAN AKUN WARGA</div>
                <div class="register-subtitle">Desa Badran Sari - Kec. Punggur - Kab. Lampung Tengah</div>
            </div>
            
            <div class="register-body">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Perhatian:</strong> Isi data dengan lengkap dan benar. Akun Anda akan diverifikasi oleh administrator sebelum dapat digunakan.
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    
                    <!-- Data Identitas -->
                    <div class="section-title">
                        <i class="fas fa-id-card me-2"></i>Data Identitas
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">
                                NIK <span class="required">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('nik') is-invalid @enderror" 
                                   id="nik" 
                                   name="nik" 
                                   value="{{ old('nik') }}" 
                                   placeholder="Masukkan NIK 16 digit"
                                   minlength="16"
                                   maxlength="16"
                                   required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="family_card_number" class="form-label">
                                Nomor KK <span class="required">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('family_card_number') is-invalid @enderror" 
                                   id="family_card_number" 
                                   name="family_card_number" 
                                   value="{{ old('family_card_number') }}" 
                                   placeholder="Masukkan Nomor KK 16 digit"
                                   minlength="16"
                                   maxlength="16"
                                   required>
                            @error('family_card_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Nama Lengkap <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Masukkan nama lengkap sesuai KTP"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">
                                Jenis Kelamin <span class="required">*</span>
                            </label>
                            <select class="form-select @error('gender') is-invalid @enderror" 
                                    id="gender" 
                                    name="gender" 
                                    required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="birth_place" class="form-label">
                                Tempat Lahir <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('birth_place') is-invalid @enderror" 
                                   id="birth_place" 
                                   name="birth_place" 
                                   value="{{ old('birth_place') }}" 
                                   placeholder="Contoh: Lampung Tengah"
                                   required>
                            @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="birth_date" class="form-label">
                            Tanggal Lahir <span class="required">*</span>
                        </label>
                        <input type="date" 
                               class="form-control @error('birth_date') is-invalid @enderror" 
                               id="birth_date" 
                               name="birth_date" 
                               value="{{ old('birth_date') }}" 
                               required>
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Data Domisili -->
                    <div class="section-title">
                        <i class="fas fa-home me-2"></i>Data Domisili
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">
                            Alamat Lengkap <span class="required">*</span>
                        </label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" 
                                  name="address" 
                                  rows="3" 
                                  placeholder="Contoh: Jl. Raya Desa No. 123, RT 02/RW 05"
                                  required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="hamlet" class="form-label">
                            Dusun <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('hamlet') is-invalid @enderror" 
                               id="hamlet" 
                               name="hamlet" 
                               value="{{ old('hamlet') }}" 
                               placeholder="Masukkan nama dusun"
                               required>
                        @error('hamlet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Data Pribadi -->
                    <div class="section-title">
                        <i class="fas fa-user me-2"></i>Data Pribadi
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="religion" class="form-label">
                                Agama <span class="required">*</span>
                            </label>
                            <select class="form-select @error('religion') is-invalid @enderror" 
                                    id="religion" 
                                    name="religion" 
                                    required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="marital_status" class="form-label">
                                Status Perkawinan <span class="required">*</span>
                            </label>
                            <select class="form-select @error('marital_status') is-invalid @enderror" 
                                    id="marital_status" 
                                    name="marital_status" 
                                    required>
                                <option value="">Pilih Status</option>
                                <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Kawin</option>
                                <option value="Divorced" {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                            @error('marital_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="occupation" class="form-label">
                                Pekerjaan <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('occupation') is-invalid @enderror" 
                                   id="occupation" 
                                   name="occupation" 
                                   value="{{ old('occupation') }}" 
                                   placeholder="Contoh: Petani, Wiraswasta, PNS"
                                   required>
                            @error('occupation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">
                                No. Telepon/HP <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="Contoh: 081234567890"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">
                            Status Penduduk <span class="required">*</span>
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="">Pilih Status</option>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="moved" {{ old('status') == 'moved' ? 'selected' : '' }}>Pindah</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Data Akun -->
                    <div class="section-title">
                        <i class="fas fa-lock me-2"></i>Data Akun Login
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email <span class="required">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Masukkan alamat email"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Email akan digunakan untuk login dan menerima notifikasi</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                Password <span class="required">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Minimal 6 karakter"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">
                                Konfirmasi Password <span class="required">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Ulangi password"
                                   required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register">
                        <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                    </button>

                    <div class="login-link">
                        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
