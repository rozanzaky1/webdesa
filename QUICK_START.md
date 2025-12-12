# 🚀 QUICK START GUIDE

## Langkah Cepat Menjalankan Website

### 1️⃣ Start Laravel Server
```bash
php artisan serve
```

### 2️⃣ Buka Browser
```
http://localhost:8000
```

### 3️⃣ Login untuk Testing

**User Biasa:**
- Email: `user@webdesa.com`
- Password: `user123`
- Akses: Frontend + Layanan Pengajuan Surat

**Admin:**
- Email: `admin@webdesa.com`
- Password: `admin123`
- Akses: Dashboard Admin + Semua Menu

---

## 🎯 Testing Scenario

### Scenario 1: Pengunjung (Tanpa Login)
1. Buka homepage → Lihat hero, stats, berita
2. Klik menu "Profil Desa" → Info lengkap desa
3. Klik menu "Berita" → List berita
4. Klik salah satu berita → Detail + sharing
5. Klik menu "Lembaga" → 6 lembaga desa
6. Klik menu "Peta Desa" → Maps + info lokasi
7. Coba akses "Layanan" → Redirect ke login ✅

### Scenario 2: User Login
1. Login dengan user@webdesa.com / user123
2. Akses menu "Layanan" → Lihat 6 layanan ✅
3. Klik "Ajukan Sekarang" → Form pengajuan
4. Isi data:
   - Nama: Auto-fill
   - NIK: 1234567890123456 (16 digit)
   - Jenis: Pilih "Surat Domisili"
   - Keperluan: "Untuk keperluan pembuatan KTP baru"
5. Submit → Success message
6. Redirect ke "Riwayat Pengajuan"
7. Lihat card pengajuan dengan status "Menunggu"
8. Klik "Detail" → Timeline + info lengkap
9. Logout → Kembali ke homepage

### Scenario 3: Admin (Approval)
1. Login sebagai admin
2. Masuk dashboard admin
3. Menu "Pengajuan Online"
4. Approve/Reject pengajuan user
5. Isi nomor surat & catatan admin
6. Simpan
7. User bisa cetak surat ✅

---

## 📱 Menu Navigation

### Public Menu (Semua Orang)
```
🏠 Beranda
📋 Profil Desa
🏛️ Lembaga
📰 Berita
🗺️ Peta Desa
```

### Authenticated Menu (Setelah Login)
```
✚ Layanan (tambahan)
   ├── Daftar Layanan
   ├── Form Pengajuan
   └── Riwayat Pengajuan

👤 User Dropdown
   ├── Dashboard Admin (jika admin)
   ├── Riwayat Pengajuan
   └── Logout
```

---

## 🎨 Fitur Highlight

### Homepage
✅ Hero section dengan gradient green
✅ 4 Statistik cards (Penduduk, Keluarga, Dusun, Lembaga)
✅ Sambutan Kepala Desa dengan foto
✅ 6 Berita terbaru dalam grid
✅ Google Maps embed
✅ Call-to-action layanan

### Berita
✅ Filter search & kategori
✅ Pagination
✅ Detail dengan social sharing
✅ Related news sidebar
✅ View counter

### Layanan (Auth Required)
✅ 6 Jenis layanan dengan icon
✅ Form pengajuan dengan validasi
✅ Riwayat dengan status badge
✅ Timeline tracking status
✅ Print letter (jika approved)

### Profil & Info
✅ Visi & Misi desa
✅ Sejarah desa
✅ Struktur organisasi
✅ 6 Lembaga desa detail
✅ Peta dengan batas wilayah
✅ Info lokasi lengkap

---

## 🐛 Troubleshooting

### Error: "Target class [Frontend\HomeController] does not exist"
```bash
composer dump-autoload
php artisan config:clear
```

### Error: "File not found" untuk JSON
```bash
# Cek apakah file ada
ls storage/app/*.json

# Jika tidak ada, buat manual atau copy dari backup
```

### Gambar tidak muncul
```bash
php artisan storage:link
```

### Routes tidak berfungsi
```bash
php artisan route:clear
php artisan route:cache
```

### View error
```bash
php artisan view:clear
```

### Clear all cache
```bash
php artisan optimize:clear
```

---

## 📊 Data Sample

### JSON Files Location
```
storage/app/
├── news.json                    # Berita
├── village_profile.json         # Profil desa ✅ Created
├── village_institutions.json    # Lembaga ✅ Created
├── village_greetings.json       # Sambutan ✅ Created
├── hamlets.json                 # Dusun
└── online_submissions.json      # Pengajuan (auto-created)
```

### Database Tables
```sql
users           # User auth (admin & user)
residents       # Data penduduk
```

---

## 🎯 Development Tips

### Edit Theme Color
Cari dan replace di semua views:
- `#2d5016` → Your primary color
- `#4a7c2c` → Your secondary color

### Add New Service
Edit: `app/Http/Controllers/Frontend/ServiceController.php`
Method: `getServiceList()`

### Add New Letter Type
Edit: `app/Http/Controllers/Frontend/ServiceController.php`
Method: `getLetterTypes()`

### Change Logo
Edit: `resources/views/frontend/layout.blade.php`
Section: Navbar (line ~20)

### Change Footer Info
Edit: `resources/views/frontend/layout.blade.php`
Section: Footer (line ~100+)

---

## 📞 Support & Documentation

📄 **Full Documentation:** `FRONTEND_DOCUMENTATION.md`
📋 **Implementation Details:** `IMPLEMENTATION_SUMMARY.md`
📖 **Project README:** `README_PROJECT.md`

---

## ✅ Checklist Sebelum Go Live

### Pre-Launch
- [ ] Update `.env` dengan domain production
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Update database credentials
- [ ] Run migrations di production
- [ ] Upload semua gambar
- [ ] Update village_profile.json dengan data real
- [ ] Update village_institutions.json
- [ ] Update news.json dengan berita real
- [ ] Test semua menu di production
- [ ] Test form submission
- [ ] Test email notification (jika ada)

### Post-Launch
- [ ] Monitor error logs
- [ ] Setup backup otomatis
- [ ] Setup SSL certificate (HTTPS)
- [ ] Configure CDN (optional)
- [ ] Setup Google Analytics
- [ ] Submit to Google Search Console
- [ ] Create sitemap.xml
- [ ] Test mobile responsiveness
- [ ] User training untuk admin

---

## 🎉 Selamat!

Website Desa Badran Sari sudah siap digunakan!

**Happy Coding!** 🚀
