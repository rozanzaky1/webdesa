# 📧 PANDUAN KONFIGURASI EMAIL UNTUK NOTIFIKASI VERIFIKASI AKUN

## ✅ Fitur yang Sudah Dibuat

Sistem email notifikasi otomatis saat admin menyetujui akun user sudah selesai dibuat:

1. ✅ **AccountApprovedNotification** - Class notifikasi email
2. ✅ **UserVerificationController** - Update method approve untuk kirim email
3. ✅ **Email Template** - Template HTML email yang menarik

---

## 📋 Cara Mengaktifkan Email

### Opsi 1: Menggunakan Gmail SMTP (Gratis & Mudah)

#### Langkah 1: Edit file `.env`

Buka file `.env` di root project dan ubah konfigurasi MAIL:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email-desa@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email-desa@gmail.com
MAIL_FROM_NAME="Desa Badran Sari"
```

#### Langkah 2: Buat App Password Gmail

1. Login ke akun Gmail desa
2. Buka: https://myaccount.google.com/security
3. Aktifkan **"2-Step Verification"**
4. Setelah aktif, buka: https://myaccount.google.com/apppasswords
5. Pilih **"App"** → Select **"Mail"**
6. Pilih **"Device"** → Select **"Other (Custom name)"**
7. Ketik: **"Laravel Desa Badran Sari"**
8. Klik **"Generate"**
9. Copy **16 karakter password** yang muncul
10. Paste ke `MAIL_PASSWORD` di file `.env`

#### Langkah 3: Clear Cache & Test

```bash
php artisan config:clear
php artisan cache:clear
```

---

### Opsi 2: Menggunakan Mailtrap (Testing/Development)

Untuk testing tanpa kirim email ke user asli:

#### Edit file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@desabadransari.id
MAIL_FROM_NAME="Desa Badran Sari"
```

#### Cara Mendapatkan Kredensial Mailtrap:

1. Buka: https://mailtrap.io/
2. Register/Login gratis
3. Buka **"Email Testing"** → **"Inboxes"**
4. Pilih inbox atau buat baru
5. Klik **"Show Credentials"**
6. Copy **Username** dan **Password**
7. Paste ke `.env`

**Keuntungan Mailtrap:**
- Email tidak dikirim ke user asli
- Bisa lihat preview email yang dikirim
- Cocok untuk development/testing

---

### Opsi 3: Menggunakan SMTP Hosting/Domain

Jika desa punya email domain sendiri (misalnya: admin@desabadransari.id):

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.desabadransari.id
MAIL_PORT=587
MAIL_USERNAME=admin@desabadransari.id
MAIL_PASSWORD=password-email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@desabadransari.id
MAIL_FROM_NAME="Desa Badran Sari"
```

**Info SMTP bisa didapat dari:**
- Hosting provider (cPanel → Email Accounts)
- Administrator domain/website desa

---

### Opsi 4: Log Email (Tanpa Kirim)

Untuk development, email hanya disimpan di log file:

```env
MAIL_MAILER=log
```

Email akan tersimpan di: `storage/logs/laravel.log`

---

## 🚀 Cara Testing Email

### 1. Via Tinker (Command Line)

```bash
php artisan tinker
```

Kemudian jalankan:

```php
$user = App\Models\User::where('email', 'test@example.com')->first();
$user->notify(new App\Notifications\AccountApprovedNotification());
```

### 2. Via Approval User di Dashboard

1. Login sebagai admin
2. Buka menu **"VERIFIKASI USER"**
3. Klik **"Setujui"** pada user pending
4. Email akan otomatis terkirim

---

## 📧 Isi Email yang Dikirim

Email berisi:
- ✅ Ucapan selamat akun diverifikasi
- 📧 Email user
- ✅ Status akun aktif
- 📅 Tanggal verifikasi
- 📋 Daftar layanan yang bisa diakses
- 🔐 Tombol "Login Sekarang"
- 📝 Instruksi login

---

## 🔧 Troubleshooting

### Email tidak terkirim?

1. **Cek log error:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Cek konfigurasi:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Test koneksi SMTP:**
   ```bash
   php artisan tinker
   Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });
   ```

4. **Cek firewall:** Pastikan port 587/465 tidak diblokir

5. **Gmail tidak bisa login:**
   - Pastikan 2-Step Verification aktif
   - Gunakan App Password, bukan password Gmail biasa
   - Cek "Less secure app access" (deprecated, gunakan App Password)

---

## 📝 Catatan Penting

1. **Jangan commit file `.env`** ke Git (sudah ada di `.gitignore`)
2. **Gunakan Mailtrap** untuk testing dulu sebelum production
3. **Backup kredensial email** di tempat aman
4. **Ganti MAIL_FROM_ADDRESS** dengan email resmi desa jika ada
5. **Monitor log** saat pertama kali testing email

---

## 🎯 Rekomendasi

**Untuk Production (Live):**
- Gunakan Gmail SMTP atau SMTP hosting domain
- Gunakan email resmi desa
- Aktifkan 2-Step Verification
- Monitor log pengiriman email

**Untuk Development:**
- Gunakan Mailtrap untuk testing
- Atau gunakan `MAIL_MAILER=log` untuk simpan di log

---

## 📚 Referensi Laravel

- Mail Config: https://laravel.com/docs/11.x/mail
- Notifications: https://laravel.com/docs/11.x/notifications
- Queue (untuk email async): https://laravel.com/docs/11.x/queues

---

Jika ada pertanyaan, silakan hubungi developer atau lihat dokumentasi Laravel Mail.
