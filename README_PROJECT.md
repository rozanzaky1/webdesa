# 🌾 Website Desa Badran Sari

Website resmi untuk pengelolaan administrasi dan informasi Desa Badran Sari. Dibangun dengan Laravel 11 dan Bootstrap 4.

## 🚀 Fitur Utama

### 👥 Area Publik (Tanpa Login)
- **Beranda**: Hero section, statistik desa, sambutan kepala desa, berita terkini, peta lokasi
- **Profil Desa**: Informasi umum, visi & misi, sejarah, struktur organisasi
- **Berita**: Daftar berita dengan filter kategori & pencarian, detail berita dengan sharing
- **Lembaga Desa**: Informasi lembaga dan organisasi desa
- **Peta Desa**: Google Maps, info lokasi, batas wilayah, panduan akses

### 🔐 Area User (Perlu Login)
- **Layanan Administrasi**: 6 jenis layanan surat (Domisili, Usaha, Tidak Mampu, KTP, KK, Kelahiran)
- **Form Pengajuan**: Pengajuan surat online dengan validasi
- **Riwayat Pengajuan**: Status tracking (Pending/Approved/Rejected)
- **Detail Pengajuan**: Timeline status, nomor surat, cetak PDF (jika disetujui)

### 👨‍💼 Area Admin
- Manajemen Penduduk & Dusun
- Manajemen Berita & Profil Desa
- Manajemen Lembaga Desa
- Persetujuan Pengajuan Surat Online
- User Management

## 📋 Teknologi

- **Framework**: Laravel 11
- **Frontend**: Blade Templates, Bootstrap 4.6.2, Font Awesome 5.15.4
- **Database**: MySQL (via Eloquent ORM)
- **Storage**: JSON Files untuk konten (news, profile, institutions, submissions)
- **Authentication**: Laravel Breeze
- **Design**: Responsive, Mobile-First, Green Theme (#2d5016)

## 🛠️ Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk asset compilation)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/username/webdesa.git
cd webdesa
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webdesa
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run Migrasi & Seeder**
```bash
php artisan migrate --seed
```

6. **Compile Assets**
```bash
npm run dev
# atau untuk production:
npm run build
```

7. **Storage Link**
```bash
php artisan storage:link
```

8. **Jalankan Server**
```bash
php artisan serve
```

Buka browser: `http://localhost:8000`

## 👤 Default Users

### Admin
- Email: `admin@webdesa.com`
- Password: `admin123`
- Akses: Dashboard admin, semua fitur manajemen

### User
- Email: `user@webdesa.com`
- Password: `user123`
- Akses: Frontend, pengajuan surat, riwayat

## 📁 Struktur Direktori

```
webdesa/
├── app/
│   ├── Http/Controllers/
│   │   ├── Frontend/           # Controllers untuk frontend
│   │   │   ├── HomeController.php
│   │   │   ├── NewsController.php
│   │   │   └── ServiceController.php
│   │   └── ...                 # Controllers admin
│   └── Models/
├── resources/views/
│   ├── frontend/               # Views frontend
│   │   ├── layout.blade.php
│   │   ├── home.blade.php
│   │   ├── profile.blade.php
│   │   ├── institutions.blade.php
│   │   ├── map.blade.php
│   │   ├── news/
│   │   └── services/
│   ├── pages/                  # Views admin
│   └── layouts/
├── routes/
│   └── web.php                 # Frontend & admin routes
├── storage/
│   └── app/
│       ├── news.json           # Data berita
│       ├── village_profile.json
│       ├── village_institutions.json
│       ├── online_submissions.json
│       └── ...
└── public/
    └── storage/                # Symlink untuk assets
```

## 🔗 Routes

### Public Routes
- `/` - Beranda
- `/profil-desa` - Profil Desa
- `/berita` - Daftar Berita
- `/berita/{slug}` - Detail Berita
- `/lembaga-desa` - Lembaga Desa
- `/peta-desa` - Peta Desa

### Authenticated Routes
- `/layanan` - Daftar Layanan
- `/layanan/form` - Form Pengajuan
- `/layanan/riwayat` - Riwayat Pengajuan
- `/layanan/riwayat/{id}` - Detail Pengajuan

### Admin Routes
- `/admin/dashboard` - Dashboard Admin
- `/admin/residents` - Data Penduduk
- `/admin/hamlets` - Data Dusun
- `/admin/news` - Manajemen Berita
- `/admin/village-profile` - Profil Desa
- `/admin/village-institutions` - Lembaga Desa
- `/admin/online-submission` - Pengajuan Online

## 🎨 Theme & Design

- **Primary Color**: `#2d5016` (Dark Green)
- **Secondary Color**: `#4a7c2c` (Light Green)
- **Font**: Poppins (Google Fonts)
- **Icons**: Font Awesome 5.15.4
- **Responsive**: Mobile-first approach
- **Effects**: Hover animations, smooth transitions, gradient backgrounds

## 📊 Data Management

Data disimpan dalam JSON files di `storage/app/`:

1. **news.json** - Berita desa
2. **village_profile.json** - Profil desa (visi, misi, sejarah)
3. **village_institutions.json** - Lembaga desa
4. **village_greetings.json** - Sambutan kepala desa
5. **hamlets.json** - Data dusun
6. **online_submissions.json** - Pengajuan surat online

Database MySQL digunakan untuk:
- Users (authentication)
- Residents (data penduduk)

## 🔒 Security

- CSRF Protection (Laravel default)
- Authentication middleware untuk routes protected
- Validasi input (server-side)
- Password hashing (bcrypt)
- XSS protection via Blade templates

## 📝 Development

### Menambah Berita Baru
Edit `storage/app/news.json`, tambahkan:
```json
{
  "id": "news-xxx",
  "title": "Judul Berita",
  "slug": "judul-berita",
  "content": "Konten lengkap...",
  "excerpt": "Ringkasan singkat...",
  "image": "/storage/news/image.jpg",
  "category": "Pengumuman",
  "author": "Admin",
  "views": 0,
  "status": "published",
  "published_at": "2025-11-27 10:00:00",
  "created_at": "2025-11-27 10:00:00"
}
```

### Mengubah Profil Desa
Edit `storage/app/village_profile.json`

### Menambah Layanan Baru
Edit method `getServiceList()` di `ServiceController.php`

## 🐛 Troubleshooting

### Error: Class not found
```bash
composer dump-autoload
```

### Assets tidak muncul
```bash
php artisan storage:link
npm run build
```

### Database connection error
- Pastikan MySQL berjalan
- Periksa kredensial di `.env`
- Jalankan `php artisan config:clear`

## 📄 Lisensi

Proyek ini dibuat untuk keperluan administrasi Desa Badran Sari.

## 👨‍💻 Developer

Dikembangkan dengan ❤️ untuk Desa Badran Sari

---

**Dokumentasi Lengkap**: Lihat `FRONTEND_DOCUMENTATION.md` untuk detail implementasi frontend.
