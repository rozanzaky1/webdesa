# 🔐 Cara Setup GitHub Secrets - Panduan Lengkap

## Error yang Anda Alami
```
Error: Input required and not supplied: server
```
**Artinya:** GitHub Actions tidak bisa menemukan secret `FTP_SERVER` karena belum ditambahkan.

---

## 📋 Langkah-Langkah Setup (IKUTI URUTAN INI)

### STEP 1: Buka Repository GitHub
1. Buka browser, masuk ke https://github.com
2. Buka repository project Anda
3. Pastikan Anda sudah login

### STEP 2: Masuk ke Settings
1. Di halaman repository, lihat menu tab di atas (Code, Issues, Pull requests, Actions, Projects, Wiki, **Settings**)
2. Klik tab **Settings** (paling kanan)
3. Jika tidak ada tab Settings, berarti Anda bukan owner/admin repository

### STEP 3: Buka Menu Secrets
1. Di sidebar KIRI, scroll ke bawah
2. Cari bagian **Security** 
3. Klik **Secrets and variables**
4. Klik **Actions** (akan expand/muncul submenu)
5. Anda akan melihat halaman "Actions secrets and variables"

### STEP 4: Tambah Secret FTP_SERVER (PERTAMA)
1. Klik tombol hijau **New repository secret**
2. Di field **Name**, ketik: `FTP_SERVER`
3. Di field **Secret**, ketik FTP server Anda dari Domainesia (contoh: `ftp.yourdomain.com` atau IP server)
4. Klik **Add secret**

### STEP 5: Tambah Secret FTP_USERNAME
1. Klik lagi **New repository secret**
2. **Name**: `FTP_USERNAME`
3. **Secret**: Username FTP Anda dari Domainesia
4. Klik **Add secret**

### STEP 6: Tambah Secret FTP_PASSWORD
1. Klik lagi **New repository secret**
2. **Name**: `FTP_PASSWORD`
3. **Secret**: Password FTP Anda
4. Klik **Add secret**

### STEP 7: Tambah Secret FTP_SERVER_DIR
1. Klik lagi **New repository secret**
2. **Name**: `FTP_SERVER_DIR`
3. **Secret**: Path folder di server, contoh: `/public_html/` atau `/domains/yourdomain.com/public_html/`
4. Klik **Add secret**

---

## 🔑 Generate APP_KEY

### Di Terminal/PowerShell (Local):
```powershell
php artisan key:generate --show
```

Hasilnya seperti ini:
```
base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

**COPY** seluruh hasil (termasuk `base64:`)

### STEP 8: Tambah Secret APP_KEY
1. Klik **New repository secret**
2. **Name**: `APP_KEY`
3. **Secret**: Paste hasil dari command di atas
4. Klik **Add secret**

---

## 📝 Secret Lainnya (WAJIB)

### STEP 9: APP_NAME
- **Name**: `APP_NAME`
- **Secret**: `WebDesa` (atau nama aplikasi Anda)

### STEP 10: APP_URL
- **Name**: `APP_URL`
- **Secret**: `https://yourdomain.com` (ganti dengan domain Anda, JANGAN ada slash di akhir)

### STEP 11: DB_HOST
- **Name**: `DB_HOST`
- **Secret**: `localhost` (atau host dari cPanel Domainesia)

### STEP 12: DB_PORT
- **Name**: `DB_PORT`
- **Secret**: `3306`

### STEP 13: DB_DATABASE
- **Name**: `DB_DATABASE`
- **Secret**: Nama database Anda di Domainesia (cek di cPanel → MySQL Databases)

### STEP 14: DB_USERNAME
- **Name**: `DB_USERNAME`
- **Secret**: Username database Anda

### STEP 15: DB_PASSWORD
- **Name**: `DB_PASSWORD`
- **Secret**: Password database Anda

---

## 📧 Secret Email (OPSIONAL - Bisa Diisi Nanti)

### STEP 16-23: Mail Settings
Jika Anda sudah setup email, tambahkan:

- `MAIL_MAILER` = `smtp`
- `MAIL_HOST` = `mail.yourdomain.com` (dari Domainesia)
- `MAIL_PORT` = `587` atau `465`
- `MAIL_USERNAME` = `noreply@yourdomain.com`
- `MAIL_PASSWORD` = password email Anda
- `MAIL_ENCRYPTION` = `tls` atau `ssl`
- `MAIL_FROM_ADDRESS` = `noreply@yourdomain.com`
- `MAIL_FROM_NAME` = `WebDesa`

**Jika belum setup email, SKIP dulu bagian ini!**

---

## ✅ Cara Cek Secrets Sudah Benar

Setelah menambahkan semua secrets:
1. Kembali ke halaman **Actions secrets**
2. Anda akan melihat daftar secrets (passwordnya tidak terlihat)
3. Minimal harus ada **15 secrets** (tanpa mail) atau **23 secrets** (dengan mail)

### Checklist Secrets Minimal:
- ✅ FTP_SERVER
- ✅ FTP_USERNAME
- ✅ FTP_PASSWORD
- ✅ FTP_SERVER_DIR
- ✅ APP_KEY
- ✅ APP_NAME
- ✅ APP_URL
- ✅ DB_HOST
- ✅ DB_PORT
- ✅ DB_DATABASE
- ✅ DB_USERNAME
- ✅ DB_PASSWORD

---

## 🚀 Test Deployment

Setelah semua secrets ditambahkan:

### Cara 1: Re-run Workflow
1. Klik tab **Actions**
2. Klik workflow yang failed (Deploy to Domainesia)
3. Klik tombol **Re-run all jobs** (kanan atas)

### Cara 2: Push Baru
```powershell
git commit --allow-empty -m "Test deployment with secrets"
git push origin main
```

---

## 📍 Cara Dapat Info FTP dari Domainesia

1. Login ke **Client Area Domainesia**: https://my.domainesia.com
2. Klik menu **Hosting** di sidebar
3. Pilih paket hosting Anda
4. Klik tombol **Masuk ke cPanel**
5. Di cPanel, cari **FTP Accounts** atau **File Manager**
6. Untuk FTP info:
   - **FTP Server**: Biasanya `ftp.yourdomain.com` atau lihat di "FTP Configuration"
   - **Username**: Ada di daftar FTP accounts
   - **Password**: Yang Anda buat saat setup FTP
   - **Server Dir**: Biasanya `/public_html/` untuk domain utama

### Alternative: Setup FTP Baru di Domainesia
1. Di cPanel, masuk ke **FTP Accounts**
2. Klik **Add FTP Account**
3. Isi:
   - Log In: `deploy` (atau nama lain)
   - Password: Buat password strong
   - Directory: Pilih `/public_html/` atau sesuai kebutuhan
4. Klik **Create FTP Account**
5. Copy semua info yang muncul

---

## ❓ FAQ Troubleshooting

**Q: Tidak ada tab Settings di repository**
A: Anda bukan owner repository. Minta owner untuk menambahkan Anda sebagai admin atau owner yang menambahkan secrets.

**Q: Secrets sudah ditambah tapi masih error**
A: 
1. Pastikan nama secret PERSIS seperti panduan (huruf besar/kecil harus sama)
2. Pastikan tidak ada spasi di awal/akhir value
3. Re-run workflow dari tab Actions

**Q: Lupa password FTP**
A: Reset di cPanel Domainesia → FTP Accounts → Change Password

**Q: APP_KEY generate error**
A: Pastikan di folder project dan sudah `composer install`

---

## 📞 Butuh Bantuan?

Jika masih error:
1. Screenshot halaman error di GitHub Actions
2. Screenshot daftar secrets Anda (list nama saja, JANGAN value)
3. Screenshot FTP info dari Domainesia (sensor password)
