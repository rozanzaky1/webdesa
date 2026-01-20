# Troubleshooting: Gambar Lembaga Desa Tidak Muncul

## Status Saat Ini

Berdasarkan investigasi, semua komponen sudah benar:
- ✅ File gambar ada di `storage/app/public/institution-structure/`  
- ✅ Symbolic link sudah dibuat (`public/storage` → `storage/app/public`)
- ✅ Data JSON sudah memiliki referensi ke gambar
- ✅ View menggunakan path yang benar

## 3 Langkah Perbaikan

### 1. Clear Cache dan Hard Refresh

```bash
# Jalankan di terminal
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

Kemudian buka browser dan tekan **Ctrl+F5** (hard refresh) untuk clear browser cache.

### 2. Test Akses Gambar Langsung

Buka di browser:
```
http://webdesa.test/test-images.php
```
atau
```
http://localhost/webdesa/test-images.php
```

File test ini akan menampilkan:
- Daftar semua lembaga
- Path gambar yang tersimpan
- Status file exists atau tidak
- Preview gambar jika bisa diakses

### 3. Jika Gambar Tetap Tidak Muncul

Kemungkinan besar masalah pada symlink di Windows/Laragon. Solusi alternatif:

**Opsi A: Recreate Symlink**
```bash
# Hapus symlink lama
Remove-Item "c:\laragon\www\webdesa\public\storage" -Force -Recurse

# Buat symlink baru dengan administrator privileges
# Jalankan PowerShell sebagai Administrator
New-Item -ItemType SymbolicLink -Path "c:\laragon\www\webdesa\public\storage" -Target "c:\laragon\www\webdesa\storage\app\public"
```

**Opsi B: Atau gunakan Laravel command**
```bash
php artisan storage:link
```

### 4. Verifikasi Hasil

Setelah langkah di atas, buka halaman **Lembaga Desa** dan periksa:

1. Apakah ada **Debug Info** box berwarna biru di bawah setiap lembaga?
2. Cek isi Debug Info:
   - `Path`: Harus berisi "institution-structure/xxxxx.jpg"
   - `File exists`: Harus "YES"
   - `Full URL`: Harus seperti "http://webdesa.test/storage/institution-structure/xxxxx.jpg"

3. Jika gambar masih tidak muncul, **klik kanan pada gambar** → **Inspect** → **Console tab** untuk melihat error message

## File yang Sudah Dimodifikasi

1. **VillageInstitutionController.php**
   - Ditambahkan backward compatibility untuk field `structure_image`
   - Semua data akan otomatis memiliki field ini meskipun data lama tidak memilikinya

2. **village-institutions/index.blade.php**  
   - Ditambahkan debug info untuk troubleshooting
   - Ditambahkan onerror handler untuk gambar
   - Ditambahkan alert jika tidak ada gambar

3. **test-images.php**
   - File test untuk verifikasi akses gambar
   - Dapat diakses langsung via browser

## Kontak Jika Masih Bermasalah

Jika setelah semua langkah di atas gambar masih tidak muncul, mohon provide screenshot dari:
1. Halaman Lembaga Desa (dengan debug info visible)
2. Browser Console (F12 → Console tab)
3. Network tab (F12 → Network tab, filter "img")

---
Generated: 2026-01-15
