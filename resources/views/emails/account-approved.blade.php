<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #0f7b2a 0%, #1a5f3a 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .email-body {
            padding: 30px 25px;
        }
        .email-body h2 {
            color: #0f7b2a;
            margin-top: 0;
        }
        .email-body p {
            margin: 15px 0;
            color: #555;
        }
        .btn-login {
            display: inline-block;
            background: #0f7b2a;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .btn-login:hover {
            background: #0d6523;
        }
        .info-box {
            background: #e8f5e9;
            border-left: 4px solid #0f7b2a;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .email-footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
        }
        .icon {
            font-size: 48px;
            color: #0f7b2a;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🏛️ Kampung Badran Sari</h1>
            <p>Kec. Punggur - Kab. Lampung Tengah</p>
        </div>
        
        <div class="email-body">
            <div style="text-align: center;">
                <div class="icon">✅</div>
                <h2>Akun Anda Telah Diverifikasi!</h2>
            </div>
            
            <p>Halo, <strong>{{ $user->name }}</strong>!</p>
            
            <p>Kami dengan senang hati memberitahukan bahwa akun Anda telah diverifikasi oleh administrator kami.</p>
            
            <div class="info-box">
                <strong>📧 Email:</strong> {{ $user->email }}<br>
                <strong>✅ Status:</strong> Akun Aktif<br>
                <strong>📅 Tanggal Verifikasi:</strong> {{ now()->format('d F Y, H:i') }} WIB
            </div>
            
            <p>Anda sekarang dapat mengakses semua layanan yang tersedia di Sistem Informasi Kampung Badran Sari, termasuk:</p>
            
            <ul>
                <li>Pengajuan Surat Keterangan Online</li>
                <li>Informasi & Berita Kampung</li>
                <li>Layanan Administrasi Kependudukan</li>
                <li>Dan layanan lainnya</li>
            </ul>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/login') }}" class="btn-login">
                    🔐 Login Sekarang
                </a>
            </div>
            
            <p>Silakan login dengan menggunakan:</p>
            <ul>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Password:</strong> Password yang Anda daftarkan</li>
            </ul>
            
            <p>Jika Anda mengalami kendala dalam mengakses akun, silakan hubungi administrator Kampung atau datang langsung ke kantor Kampung.</p>
            
            <p>Terima kasih telah bergabung dengan Sistem Informasi Kampung Badran Sari!</p>
        </div>
        
        <div class="email-footer">
            <p><strong>Kampung Badran Sari</strong></p>
            <p>Kecamatan Punggur, Kabupaten Lampung Tengah</p>
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
