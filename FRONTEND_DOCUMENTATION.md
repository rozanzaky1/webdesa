# DOKUMENTASI WEBSITE FRONTEND DESA BADRAN SARI

## 📁 Struktur File yang Sudah Dibuat

### 1. Layout & Views
```
resources/views/frontend/
├── layout.blade.php              ✅ Template utama (navbar, footer)
├── home.blade.php                ✅ Beranda (hero, sambutan, berita, peta)
├── profile.blade.php             ✅ Profil desa
├── institutions.blade.php        ✅ Lembaga desa
├── map.blade.php                 ✅ Peta desa dengan info lokasi
├── news/
│   ├── index.blade.php           ✅ Daftar berita
│   └── show.blade.php            ✅ Detail berita
└── services/
    ├── index.blade.php           ✅ Daftar layanan
    ├── form.blade.php            ✅ Form pengajuan dengan validasi
    ├── history.blade.php         ✅ Riwayat pengajuan
    └── show.blade.php            ✅ Detail pengajuan dengan timeline
```

### 2. Controllers
```
app/Http/Controllers/Frontend/
├── HomeController.php            ✅ Handle beranda, profil, lembaga, peta
├── NewsController.php            ✅ Handle berita (index, show)
└── ServiceController.php         ✅ Handle layanan (CRUD pengajuan)
```

### 3. Routes
```php
// File: routes/web.php
Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profil-desa', [HomeController::class, 'profile'])->name('profile');
    Route::get('/lembaga-desa', [HomeController::class, 'institutions'])->name('institutions');
    Route::get('/peta-desa', [HomeController::class, 'map'])->name('map');
    
    // News (Public)
    Route::prefix('berita')->name('news.')->group(function () {
        Route::get('/', [FrontendNewsController::class, 'index'])->name('index');
        Route::get('/{slug}', [FrontendNewsController::class, 'show'])->name('show');
    });
    
    // Services (Auth Required)
    Route::middleware('auth')->prefix('layanan')->name('services.')->group(function () {
        Route::get('/', [FrontendServiceController::class, 'index'])->name('index');
        Route::get('/form', [FrontendServiceController::class, 'create'])->name('create');
        Route::post('/form', [FrontendServiceController::class, 'store'])->name('store');
        Route::get('/riwayat', [FrontendServiceController::class, 'history'])->name('history');
        Route::get('/riwayat/{id}', [FrontendServiceController::class, 'show'])->name('show');
    });
});
```

## 🔐 Hak Akses

### User Belum Login
✅ Beranda (`/`)
✅ Profil Desa (`/profil-desa`)
✅ Lembaga Desa (`/lembaga-desa`)
✅ Berita (`/berita`)
✅ Peta Desa (`/peta-desa`)
❌ Layanan (`/layanan`) - Akan redirect ke login

### User Sudah Login
✅ Semua halaman public
✅ Layanan Administrasi (`/layanan`)
✅ Form Pengajuan Surat (`/layanan/form`)
✅ Riwayat Pengajuan (`/layanan/riwayat`)
✅ Detail Pengajuan (`/layanan/riwayat/{id}`)

## 📝 File yang Perlu Dibuat Manual

### Fitur yang Sudah Diimplementasi

✅ **Form Pengajuan** (`services/form.blade.php`):
- Field: Nama, NIK (16 digit), Jenis Surat, Keperluan, Catatan
- Validasi: Required fields, NIK format, min 10 karakter untuk keperluan
- Auto-fill nama dari user yang login
- Alert informasi waktu proses
- Button: Kembali dan Kirim Pengajuan

✅ **Riwayat Pengajuan** (`services/history.blade.php`):
- List semua pengajuan user dengan status badge (Menunggu/Disetujui/Ditolak)
- Card design dengan hover effect
- Show: Jenis surat, keperluan (excerpt), tanggal pengajuan, catatan admin
- Button: Detail dan Cetak (jika disetujui)
- Empty state untuk user tanpa pengajuan

✅ **Detail Pengajuan** (`services/show.blade.php`):
- Timeline status visual (Dikirim → Disetujui/Ditolak)
- Tabel informasi lengkap (ID, Nama, NIK, Jenis, Keperluan, Status)
- Catatan admin (jika ada)
- Nomor surat (jika disetujui)
- Button: Cetak dan Download PDF (jika disetujui)

✅ **Halaman Lembaga** (`institutions.blade.php`):
- Hero section dengan gradient background
- Struktur organisasi pemerintah desa (gambar)
- Grid card lembaga dengan icon, nama, ketua, sekretaris, bendahara
- Jumlah anggota dan tanggal dibentuk
- Program-program lembaga
- Info tambahan tentang lembaga desa

✅ **Halaman Peta** (`map.blade.php`):
- Hero section dengan gradient
- Google Maps embed (500px height)
- Sidebar info: Alamat, Kode Pos, Telepon, Email, Koordinat GPS
- Link "Buka di Google Maps"
- Statistik wilayah: Luas, Ketinggian, Jumlah Dusun, Penduduk
- Batas wilayah (Utara, Timur, Selatan, Barat) dalam card
- Panduan akses (Mobil, Transportasi Umum, Ojek Online)

## 🎨 Fitur Design

1. **Modern & Responsif**: Bootstrap 4 responsive design
2. **Green Theme**: Warna hijau (#2d5016, #4a7c2c) untuk identitas desa
3. **Smooth Animations**: Hover effects, transitions
4. **Font**: Poppins (Google Fonts)
5. **Icons**: Font Awesome 5
6. **Card Design**: Shadow, rounded corners, hover effects

## 🚀 Cara Testing

1. Akses halaman public tanpa login:
   - `http://localhost/` - Beranda
   - `http://localhost/berita` - Daftar berita
   - `http://localhost/profil-desa` - Profil

2. Login sebagai user:
   - Email: user@webdesa.com
   - Password: user123

3. Akses layanan setelah login:
   - `http://localhost/layanan` - Daftar layanan
   - `http://localhost/layanan/form` - Form pengajuan
   - `http://localhost/layanan/riwayat` - Riwayat

## ✅ Checklist Implementasi

- [x] Layout frontend (navbar, footer)
- [x] Halaman beranda dengan hero, stats, sambutan, berita
- [x] Halaman berita (index & detail)
- [x] Halaman profil desa
- [x] Controller frontend (Home, News, Service)
- [x] Routes dengan middleware auth untuk layanan
- [x] Form pengajuan surat dengan validasi
- [x] Riwayat pengajuan dengan status badge
- [x] Detail pengajuan dengan timeline status
- [x] Halaman lembaga desa dengan struktur organisasi
- [x] Halaman peta desa dengan Google Maps & info lokasi

## 📌 Catatan Penting

1. **Middleware**: Layanan otomatis terproteksi oleh `auth` middleware
2. **Data Source**: Semua data dari JSON files (news.json, village_profile.json, dll)
3. **Status Berita**: Hanya berita dengan status='published' yang ditampilkan
4. **Pagination**: Berita menggunakan Laravel pagination
5. **Slug**: Berita diakses via slug untuk SEO friendly

Semua file sudah siap dan terintegrasi dengan sistem admin yang ada! 🎉
