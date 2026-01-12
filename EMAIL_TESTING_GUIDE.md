# 🧪 CARA TEST EMAIL NOTIFIKASI

## Quick Test via Tinker

Jalankan command ini untuk test kirim email:

```bash
php artisan tinker
```

Kemudian jalankan salah satu command berikut:

### Test 1: Kirim ke User Tertentu

```php
$user = App\Models\User::where('email', 'user@example.com')->first();
$user->notify(new App\Notifications\AccountApprovedNotification());
exit
```

### Test 2: Kirim ke User ID Tertentu

```php
$user = App\Models\User::find(1);
$user->notify(new App\Notifications\AccountApprovedNotification());
exit
```

### Test 3: Kirim ke User Pertama yang Belum Approved

```php
$user = App\Models\User::where('is_approved', false)->first();
if($user) {
    $user->notify(new App\Notifications\AccountApprovedNotification());
    echo "Email sent to: " . $user->email;
}
exit
```

---

## Cara Lihat Email yang Terkirim

### Jika menggunakan MAIL_MAILER=log

Email akan tersimpan di:
```
storage/logs/laravel.log
```

Buka file tersebut dan cari:
```
Subject: Akun Anda Telah Diverifikasi
```

### Jika menggunakan Mailtrap

1. Login ke https://mailtrap.io
2. Buka inbox Anda
3. Lihat email yang masuk

### Jika menggunakan Gmail SMTP

Email akan terkirim ke inbox user yang sebenarnya.

---

## Test Lengkap Flow

### 1. Register User Baru

```bash
# Buka browser dan register user baru
http://localhost/register

# Atau via tinker:
php artisan tinker
```

```php
$user = App\Models\User::create([
    'name' => 'Test User',
    'email' => 'testuser@example.com',
    'password' => bcrypt('password123'),
    'role' => 'user',
    'is_approved' => false
]);
echo "User created with ID: " . $user->id;
exit
```

### 2. Login Admin & Approve

1. Login sebagai admin di browser
2. Buka menu **"VERIFIKASI USER"**
3. Klik tombol **"Setujui"** pada user test
4. Email otomatis terkirim!

### 3. Cek Email Diterima

- Cek inbox email user (jika pakai Gmail)
- Atau cek Mailtrap inbox
- Atau cek `storage/logs/laravel.log` (jika pakai log driver)

---

## Command Berguna

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Lihat Log Real-time
```bash
tail -f storage/logs/laravel.log
```

### Test SMTP Connection
```bash
php artisan tinker
```

```php
use Illuminate\Support\Facades\Mail;
Mail::raw('Test connection', function($msg) {
    $msg->to('test@example.com')->subject('Test SMTP');
});
exit
```

---

## Expected Result

Setelah admin klik **"Setujui"**:

✅ Database updated: `is_approved = 1`
✅ Email sent to user
✅ Flash message: "User [nama] berhasil disetujui dan email notifikasi telah dikirim!"

Jika email gagal:
⚠️ Flash message: "User [nama] berhasil disetujui! (Email notifikasi gagal dikirim: [error])"

---

## Tips

1. **Test dengan Mailtrap dulu** sebelum pakai Gmail
2. **Gunakan log driver** untuk development awal
3. **Monitor laravel.log** untuk lihat error
4. **Pastikan .env sudah di-clear** setelah edit config

Happy Testing! 🎉
