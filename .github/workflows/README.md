# GitHub Actions CI/CD Deployment Guide

## Panduan Setup Deployment Otomatis ke Domainesia

Workflow ini akan otomatis deploy aplikasi Laravel Anda ke hosting Domainesia setiap kali ada push ke branch `main`.

## Setup GitHub Secrets

Untuk keamanan, Anda perlu menambahkan secrets di repository GitHub Anda. Ikuti langkah berikut:

### 1. Buka Repository Settings
1. Buka repository Anda di GitHub
2. Klik **Settings** (tab di atas)
3. Klik **Secrets and variables** → **Actions** (di sidebar kiri)
4. Klik **New repository secret**

### 2. Tambahkan Secrets Berikut

#### FTP Credentials (Domainesia)
- **FTP_SERVER**: Alamat FTP server Anda (contoh: `ftp.yourdomain.com` atau IP hosting)
- **FTP_USERNAME**: Username FTP Anda
- **FTP_PASSWORD**: Password FTP Anda
- **FTP_SERVER_DIR**: Direktori tujuan di server (contoh: `/public_html/` atau `/domains/yourdomain.com/public_html/`)

#### Database Configuration
- **DB_HOST**: Host database (biasanya `localhost` atau IP dari panel hosting)
- **DB_PORT**: Port database (default: `3306`)
- **DB_DATABASE**: Nama database Anda
- **DB_USERNAME**: Username database
- **DB_PASSWORD**: Password database

#### Application Settings
- **APP_NAME**: Nama aplikasi Anda (contoh: `WebDesa`)
- **APP_KEY**: Laravel APP_KEY Anda (generate dengan: `php artisan key:generate --show`)
- **APP_URL**: URL aplikasi Anda (contoh: `https://yourdomain.com`)

#### Mail Configuration
- **MAIL_MAILER**: `smtp`
- **MAIL_HOST**: SMTP host (contoh: `mail.yourdomain.com` atau dari Domainesia)
- **MAIL_PORT**: Port SMTP (biasanya `587` atau `465`)
- **MAIL_USERNAME**: Email username
- **MAIL_PASSWORD**: Email password
- **MAIL_ENCRYPTION**: `tls` atau `ssl`
- **MAIL_FROM_ADDRESS**: Email pengirim (contoh: `noreply@yourdomain.com`)
- **MAIL_FROM_NAME**: Nama pengirim (contoh: `WebDesa`)

## Cara Mendapatkan FTP Credentials dari Domainesia

1. Login ke **Client Area Domainesia** (https://my.domainesia.com)
2. Pilih layanan hosting Anda
3. Masuk ke **cPanel**
4. Cari menu **FTP Accounts**
5. Gunakan credentials FTP yang ada atau buat akun FTP baru
6. Catat informasi:
   - FTP Server (biasanya nama domain atau IP)
   - FTP Username
   - FTP Password
   - Server Directory (path ke public_html)

## Cara Trigger Deployment

### Otomatis
- Setiap push ke branch `main` akan otomatis trigger deployment

### Manual
1. Buka tab **Actions** di repository GitHub
2. Pilih workflow **Deploy to Domainesia via FTP**
3. Klik **Run workflow**
4. Pilih branch yang ingin di-deploy
5. Klik **Run workflow**

## Monitoring Deployment

1. Buka tab **Actions** di repository GitHub
2. Klik pada workflow run yang sedang berjalan
3. Anda bisa melihat progress setiap step
4. Jika ada error, akan muncul di log

## Troubleshooting

### FTP Connection Failed
- Pastikan FTP_SERVER, FTP_USERNAME, dan FTP_PASSWORD benar
- Cek apakah IP GitHub Actions perlu di-whitelist di Domainesia
- Pastikan FTP service aktif di hosting

### Build Failed
- Cek log error di GitHub Actions
- Pastikan semua dependencies ada di composer.json dan package.json
- Pastikan APP_KEY sudah di-set

### Database Connection Error
- Pastikan DB credentials benar
- Cek apakah database sudah dibuat di cPanel
- Pastikan remote MySQL access diizinkan (jika perlu)

## Post-Deployment Manual Steps

Setelah deployment pertama kali, Anda mungkin perlu:

1. **Set Permissions** (via SSH atau File Manager):
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

2. **Run Migrations** (jika ada perubahan database):
   - Login via SSH atau gunakan Terminal di cPanel
   ```bash
   cd /path/to/your/app
   php artisan migrate --force
   ```

3. **Clear Cache**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Catatan Penting

- File `.env` akan dibuat otomatis dari secrets saat deployment
- Folder `storage` dan `bootstrap/cache` harus writable
- Pastikan symbolic link untuk storage sudah dibuat: `php artisan storage:link`
- Backup database sebelum menjalankan migration di production

## Customize Workflow

Anda bisa edit file `.github/workflows/deploy.yml` untuk:
- Mengubah branch yang di-deploy
- Menambahkan testing sebelum deploy
- Menambahkan notifikasi (Slack, Discord, Email)
- Mengubah exclude files
