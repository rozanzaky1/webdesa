# FITUR VERIFIKASI USER WARGA + EMAIL NOTIFIKASI

## ✨ Update Terbaru: Email Notifikasi Otomatis

Ketika admin menyetujui akun user, sistem akan **otomatis mengirim email** ke alamat email user yang terdaftar.

### Email berisi:
- ✅ Ucapan selamat akun diverifikasi
- 📧 Email & status akun
- 📅 Tanggal verifikasi
- 📋 Daftar layanan yang bisa diakses
- 🔐 Tombol "Login Sekarang"
- 📝 Instruksi login lengkap

---

## Cara Kerja Sistem Verifikasi

### 1. Registrasi Warga
- Warga mengisi form registrasi di `/register`
- Akun dibuat dengan status `is_approved = false`
- User tidak langsung login, redirect ke halaman login dengan pesan
- Pesan: "Akun Anda menunggu verifikasi dari administrator"

### 2. Login Warga (Sebelum Diverifikasi)
- Jika user belum diverifikasi, tidak bisa login
- Muncul pesan: "Akun Anda masih menunggu verifikasi dari administrator"

### 3. Admin Verifikasi User
- Admin login ke dashboard
- Buka menu **"VERIFIKASI USER"** di sidebar
- Lihat daftar user yang menunggu verifikasi
- Klik **"Setujui"** untuk approve user
- **📧 Email notifikasi otomatis dikirim ke user**
- User bisa langsung login setelah menerima email

## File yang Dibuat/Dimodifikasi

### 1. Migration
- `database/migrations/2026_01_12_175652_add_approval_fields_to_users_table.php`
  - Menambah kolom: `is_approved`, `approved_at`, `approved_by`

### 2. Model
- `app/Models/User.php`
  - Tambah kolom approval ke `$fillable` dan `casts`

### 3. Controllers
- `app/Http/Controllers/AuthController.php`
  - Update `register()`: Set `is_approved = false`
  - Update `login()`: Cek status approval sebelum login
  
- `app/Http/Controllers/UserVerificationController.php` (BARU)
  - `index()`: List user dengan filter & statistik
  - `approve()`: Setujui user + **kirim email notifikasi**
  - `reject()`: Tolak/batalkan user
  - `destroy()`: Hapus user

### 4. Views
- `resources/views/pages/user-verification/index.blade.php` (BARU)
  - Halaman admin untuk verifikasi user
  - Statistik pending/approved
  - Filter & search
  - Tombol approve/reject/delete

- `resources/views/emails/account-approved.blade.php` (BARU)
  - Template email HTML yang menarik
  - Design responsif dengan warna hijau desa
  - Informasi lengkap akun dan layanan

- `resources/views/auth/register.blade.php`
  - Tambah alert informasi tentang verifikasi

### 5. Routes
- `routes/web.php`
  - `GET /user-verification`
  - `POST /user-verification/{id}/approve`
  - `POST /user-verification/{id}/reject`
  - `DELETE /user-verification/{id}`

### 6. Sidebar Menu
- `resources/views/layouts/sidebar.blade.php`
  - Tambah menu "VERIFIKASI USER"

### 7. Email Notification System (BARU) ✨
- `app/Notifications/AccountApprovedNotification.php`
  - Notification class untuk kirim email
  - Subject: "Akun Anda Telah Diverifikasi"
  - Include: greeting, info akun, tombol login, instruksi

---

## 📧 Konfigurasi Email (PENTING!)

Agar email bisa terkirim, Anda perlu setup konfigurasi email di file `.env`:

### Panduan Lengkap Setup Email:
📄 Lihat file: **[EMAIL_SETUP_GUIDE.md](EMAIL_SETUP_GUIDE.md)**

### Quick Setup dengan Gmail:

Edit file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email-desa@gmail.com
MAIL_PASSWORD=your-app-password-16-karakter
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email-desa@gmail.com
MAIL_FROM_NAME="Desa Badran Sari"
```

Kemudian:
```bash
php artisan config:clear
php artisan cache:clear
```

**Catatan:** Gunakan **App Password** Gmail, bukan password biasa!
Tutorial lengkap ada di [EMAIL_SETUP_GUIDE.md](EMAIL_SETUP_GUIDE.md)

---

## 🧪 Testing Email

### Panduan Lengkap Testing:
📄 Lihat file: **[EMAIL_TESTING_GUIDE.md](EMAIL_TESTING_GUIDE.md)**

### Quick Test via Tinker:

```bash
php artisan tinker
```

```php
$user = App\Models\User::find(1);
$user->notify(new App\Notifications\AccountApprovedNotification());
exit
```

Cek email diterima di inbox atau `storage/logs/laravel.log` (jika pakai log driver).

---

## 📋 Testing

### Test 1: Register User Baru
1. Buka `/register`
2. Isi form registrasi
3. Klik "Daftar"
4. Harus redirect ke `/login` dengan pesan sukses
5. User TIDAK langsung login

### Test 2: Login Sebelum Verifikasi
1. Buka `/login`
2. Coba login dengan akun yang belum diverifikasi
3. Harus muncul error: "Akun Anda masih menunggu verifikasi"

### Test 3: Admin Approve User
1. Login sebagai admin
2. Buka menu "VERIFIKASI USER"
3. Klik "Setujui" pada user pending
4. Status berubah menjadi "Disetujui"
5. **Email otomatis terkirim ke user** ✉️
6. Cek inbox email user atau log file

### Test 4: Login Setelah Verifikasi
1. User cek email dan baca notifikasi
2. Klik tombol "Login Sekarang" di email
3. Atau buka `/login` manual
4. Login dengan akun yang sudah diverifikasi
5. Berhasil login dan redirect ke homepage

## Fitur Tambahan

### Statistik
- Total user pending
- Total user approved
- Total semua user warga

### Filter & Search
- Filter berdasarkan status (pending/approved)
- Search berdasarkan nama, email, NIK

### Actions
- **Setujui**: Approve user agar bisa login
- **Batalkan**: Batalkan approval (user tidak bisa login lagi)
- **Hapus**: Hapus user permanen
