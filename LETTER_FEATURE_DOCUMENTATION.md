# Dokumentasi Fitur Buat Surat

## Deskripsi
Fitur "Buat Surat" memungkinkan admin untuk membuat berbagai jenis surat keterangan dengan data yang otomatis terisi dari database penduduk.

## Fitur Utama

### 1. Template Surat
Sistem menyediakan 8 template surat:
- **Surat Keterangan Domisili** - Untuk keperluan keterangan tempat tinggal
- **Surat Keterangan Usaha** - Untuk keterangan menjalankan usaha
- **Surat Pengantar SKCK** - Pengantar membuat SKCK
- **Surat Keterangan Tidak Mampu** - Keterangan kondisi ekonomi
- **Surat Pengantar Nikah** - Pengantar untuk menikah
- **Surat Keterangan Kematian** - Keterangan kematian
- **Surat Keterangan Kelahiran** - Keterangan kelahiran
- **Surat Keterangan Pindah** - Keterangan pindah domisili

### 2. Auto-Fill Data Penduduk
Setelah memilih penduduk dari dropdown, data berikut otomatis terisi:
- NIK
- Nama Lengkap
- Tempat, Tanggal Lahir
- Jenis Kelamin
- Agama
- Pekerjaan
- Status Perkawinan
- Alamat Lengkap

### 3. Nomor Surat Otomatis
Sistem akan generate nomor surat otomatis dengan format:
```
PREFIX/NOMOR/TAHUN/BULAN
Contoh: SKD/001/2026/01
```

Prefix berdasarkan jenis surat:
- SKD = Surat Keterangan Domisili
- SKU = Surat Keterangan Usaha
- SKCK = Surat Pengantar SKCK
- SKTM = Surat Keterangan Tidak Mampu
- SPN = Surat Pengantar Nikah
- SKM = Surat Keterangan Kematian
- SKL = Surat Keterangan Kelahiran
- SKP = Surat Keterangan Pindah

### 4. Data Tambahan
Beberapa jenis surat memiliki field tambahan:
- **Surat Usaha**: Nama Usaha, Jenis Usaha
- **Surat Kematian**: Tanggal Meninggal, Tempat Meninggal, Penyebab
- **Surat Nikah**: Nama Calon Pasangan
- **Surat Kelahiran**: Nama Bayi, Tanggal Lahir, Tempat Lahir

### 5. Preview & Cetak
Setelah surat dibuat, sistem akan menampilkan preview surat yang dapat langsung dicetak dengan format resmi kop surat Kampung Badran Sari.

## Cara Penggunaan

### Membuat Surat Baru
1. Login sebagai admin
2. Buka menu **Surat & Dokumen** > **Buat Surat**
3. Pilih template surat yang ingin dibuat
4. Pilih penduduk dari dropdown (data akan otomatis terisi)
5. Isi keperluan/tujuan surat
6. Isi data tambahan jika ada
7. Tentukan tanggal surat
8. Klik **Buat Surat**
9. Surat akan ditampilkan dalam mode preview
10. Klik **Cetak Surat** untuk mencetak

## Struktur Database

### Table: letters
```sql
- id (primary key)
- letter_number (unique) - Nomor surat otomatis
- letter_type - Jenis surat (domisili, usaha, skck, dll)
- resident_id (foreign key) - ID penduduk
- purpose - Keperluan/tujuan surat
- additional_data (json) - Data tambahan sesuai jenis surat
- letter_date - Tanggal surat
- status - Status surat (draft/completed/printed)
- created_by (foreign key) - ID user yang membuat
- created_at
- updated_at
```

## File Yang Dibuat/Dimodifikasi

### Migration
- `database/migrations/2026_01_26_005938_create_letters_table.php`

### Model
- `app/Models/Letter.php`

### Controller
- `app/Http/Controllers/LetterController.php`

### Views
- `resources/views/pages/letters/index.blade.php` - Pilih template
- `resources/views/pages/letters/create.blade.php` - Form input surat
- `resources/views/pages/letters/show.blade.php` - Preview & cetak
- `resources/views/pages/letters/templates/domisili.blade.php`
- `resources/views/pages/letters/templates/usaha.blade.php`
- `resources/views/pages/letters/templates/skck.blade.php`
- `resources/views/pages/letters/templates/tidak_mampu.blade.php`
- `resources/views/pages/letters/templates/nikah.blade.php`
- `resources/views/pages/letters/templates/kematian.blade.php`
- `resources/views/pages/letters/templates/kelahiran.blade.php`
- `resources/views/pages/letters/templates/pindah.blade.php`

### Routes
Routes yang ditambahkan di `routes/web.php`:
```php
Route::get('/letters', [LetterController::class, 'index'])->name('letters.index');
Route::get('/letters/create', [LetterController::class, 'create'])->name('letters.create');
Route::post('/letters', [LetterController::class, 'store'])->name('letters.store');
Route::get('/letters/{id}', [LetterController::class, 'show'])->name('letters.show');
Route::get('/letters/list', [LetterController::class, 'list'])->name('letters.list');
Route::get('/letters/resident/{id}', [LetterController::class, 'getResidentData'])->name('letters.resident-data');
```

### Menu Sidebar
Menu "Buat Surat" ditambahkan di `resources/views/layouts/sidebar.blade.php` pada collapse menu "Surat & Dokumen".

## Teknologi yang Digunakan
- Laravel 11
- MySQL
- Blade Template
- jQuery untuk auto-fill
- Bootstrap untuk styling
- Print CSS untuk format cetak

## Catatan
- Data penduduk harus sudah ada sebelum membuat surat
- Pastikan data penduduk lengkap dan valid
- Surat yang sudah dibuat tersimpan di database
- Format cetak menggunakan kop surat resmi Kampung Badran Sari
- Semua surat memiliki nomor unik otomatis

## Future Enhancement
Fitur yang bisa ditambahkan di masa depan:
- Export surat ke PDF
- Riwayat surat per penduduk
- Filter dan pencarian surat
- Edit surat yang sudah dibuat
- Tanda tangan digital
- QR Code verifikasi
- Template surat custom
