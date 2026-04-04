# 📋 DOKUMENTASI PENGUJIAN BLACK BOX
## Sistem Informasi Desa Badran Sari

---

## 🎯 Ringkasan Skenario Pengujian Fitur Utama

### Tabel Skenario Pengujian Pengajuan Surat

| No | Proses | Deskripsi |
|----|--------|-----------|
| **1** | **Pengujian** | User mengisi form pengajuan surat dengan data lengkap |
|  | *Test Case* | Semua field wajib diisi dengan benar |
|  | **Hasil yang diharapkan** | Pengajuan berhasil disimpan dengan status pending |
| **2** | **Pengujian** | User mengisi form dengan data tidak lengkap |
|  | *Test Case* | Terdapat field kosong |
|  | **Hasil yang diharapkan** | Sistem menampilkan pesan validasi kesalahan |
| **3** | **Pengujian** | User mengupload dokumen pendukung surat |
|  | *Test Case* | Upload file dengan format yang tidak valid (selain PDF/JPG) |
|  | **Hasil yang diharapkan** | Sistem menampilkan pesan error "Format file tidak didukung" |

---

### Tabel Skenario Pengujian Keseluruhan Sistem

Tabel berikut berisi skenario pengujian blackbox untuk fitur-fitur paling penting dalam sistem.

| No | Pengujian | Aktor | Skenario Pengujian | Output yang Diharapkan |
|----|-----------|-------|-------------------|------------------------|
| 1 | Login | Masyarakat | User memasukkan *email* dan *password* yang valid | Berhasil masuk ke dashboard user |
| 2 | Login | Masyarakat | User memasukkan *email* atau *password* yang salah | Muncul pesan error "Email atau password salah" |
| 3 | Login | Administrator | Admin memasukkan *email* dan *password* yang valid | Berhasil masuk ke halaman admin |
| 4 | Login | Administrator | Admin memasukkan *email* atau *password* yang salah | Muncul pesan error "Email atau password salah" |
| 5 | Pendaftaran | Masyarakat | User mengisi form pendaftaran dengan NIK yang valid dan terdaftar di database penduduk | Data tersimpan, muncul notifikasi "Silakan tunggu verifikasi admin" |
| 6 | Pendaftaran | Masyarakat | User mengisi form pendaftaran dengan NIK yang tidak terdaftar di database penduduk | Muncul pesan error "NIK tidak ditemukan di database penduduk" |
| 7 | Pengajuan Surat | Masyarakat | User mengisi form pengajuan surat dengan lengkap dan data valid | Data tersimpan dengan status "Pending", muncul notifikasi berhasil |
| 8 | Pengajuan Surat | Masyarakat | User mengisi form pengajuan surat dengan data tidak lengkap | Muncul pesan error validasi pada field yang kosong |
| 9 | Verifikasi Surat | Administrator | Admin approve pengajuan surat dengan mengisi nomor surat | Status berubah "Approved", notifikasi WhatsApp terkirim ke user, user dapat cetak PDF |
| 10 | Verifikasi Surat | Administrator | Admin reject pengajuan surat dengan mengisi alasan penolakan | Status berubah "Rejected", notifikasi terkirim dengan alasan penolakan |
| 11 | Manajemen Penduduk | Administrator | Admin menambahkan data penduduk baru dengan lengkap dan NIK 16 digit yang belum ada | Data penduduk tersimpan di database, muncul notifikasi berhasil |
| 12 | Manajemen Penduduk | Administrator | Admin menambahkan data penduduk dengan NIK yang sudah terdaftar | Muncul pesan error "NIK sudah terdaftar" |
| 13 | Cetak Surat | Masyarakat | User mengakses menu cetak pada surat yang sudah disetujui (status Approved) | Generate dan download file PDF surat dengan kop resmi dan nomor surat |
| 14 | Cetak Surat | Masyarakat | User mencoba mengakses cetak pada surat yang masih Pending | Tombol cetak tidak muncul atau menampilkan pesan error |
| 15 | Keamanan | Masyarakat | User yang belum login mencoba mengakses halaman dashboard user | Diarahkan ke halaman login |
| 16 | Keamanan | Administrator | User dengan role "Masyarakat" mencoba mengakses halaman admin | Menampilkan error 403 Forbidden atau redirect |

---

## Daftar Isi Pengujian Terperinci
1. [Pengujian Modul Autentikasi](#1-pengujian-modul-autentikasi)
2. [Pengujian Modul Penduduk](#2-pengujian-modul-penduduk)
3. [Pengujian Modul Pengajuan Surat (User)](#3-pengujian-modul-pengajuan-surat-user)
4. [Pengujian Modul Verifikasi Surat (Admin)](#4-pengujian-modul-verifikasi-surat-admin)
5. [Pengujian Dashboard](#5-pengujian-dashboard)
6. [Pengujian Keamanan](#6-pengujian-keamanan)
7. [Dokumentasi Implementasi Kode](#7-dokumentasi-implementasi-kode)

---

## 1. Pengujian Modul Autentikasi

### Tabel 1.1 Pengujian Fitur Login

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|-------------------|-----------|----------------------|-----------------|------------|
| 1 | Login dengan data valid (Admin) | Email: `admin@desa.com`<br>Password: `password123` | Berhasil login dan diarahkan ke `/dashboard` | | |
| 2 | Login dengan data valid (User) | Email: `user@mail.com`<br>Password: `password123` | Berhasil login dan diarahkan ke `/user/dashboard` | | |
| 3 | Login dengan email/password salah | Email: `admin@desa.com`<br>Password: `salahpassword` | Menampilkan pesan error "Email atau password salah" | | |

### Tabel 1.2 Pengujian Fitur Register

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|-------------------|-----------|----------------------|-----------------|------------|
| 4 | Register dengan data valid | Nama: `Budi Santoso`<br>Email: `budi@mail.com`<br>NIK: `3201010101010001`<br>Password: `password123` | Berhasil register, menampilkan pesan "Silakan tunggu verifikasi admin" | | |
| 5 | Register dengan NIK tidak terdaftar | NIK: `9999999999999999` (tidak ada di database penduduk) | Menampilkan pesan error "NIK tidak ditemukan" | | |
| 6 | Register dengan field kosong | Nama/Email/NIK: `(kosong)` | Menampilkan pesan error validasi | | |

---

## 2. Pengujian Modul Penduduk

### Tabel 2.1 Pengujian CRUD Penduduk (Admin)

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|-------------------|-----------|----------------------|-----------------|------------|
| 7 | Mengakses & mencari data penduduk | Login sebagai admin, akses `/residents`, cari nama "Budi" | Menampilkan daftar penduduk dengan hasil pencarian | | |
| 8 | Tambah penduduk dengan data valid | NIK: `3201010101010002` (16 digit)<br>Nama: `Siti Rahayu`<br>Data lengkap lainnya | Data tersimpan, muncul notifikasi sukses | | |
| 9 | Tambah dengan NIK sudah ada | NIK: `3201010101010001` (duplikat) | Menampilkan pesan error "NIK sudah terdaftar" | | |
| 10 | Edit penduduk dengan data valid | Ubah nama penduduk yang sudah ada | Data berhasil diupdate, muncul notifikasi sukses | | |
| 11 | Hapus penduduk | Klik tombol "Hapus" dan konfirmasi | Data penduduk terhapus, muncul notifikasi sukses | | |
| 12 | Akses halaman tanpa login | Akses `/residents` tanpa login | Diarahkan ke halaman login | | |

---

## 3. Pengujian Modul Pengajuan Surat (User)

### Tabel 3.1 Pengujian Pengajuan Surat User

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|-------------------|-----------|----------------------|-----------------|------------|
| 13 | Mengakses dashboard user | Login sebagai user, akses `/user/dashboard` | Menampilkan dashboard dengan statistik pengajuan | | |
| 14 | Submit pengajuan surat lengkap | Pilih "Surat Domisili", isi data lengkap | Pengajuan tersimpan dengan status "Pending", muncul notifikasi | | |
| 15 | Submit dengan field wajib kosong | Jenis surat dipilih, field wajib kosong | Menampilkan pesan error validasi | | |
| 16 | Lihat detail pengajuan approved | Klik pengajuan status approved | Menampilkan detail dengan nomor surat dan tombol "Cetak PDF" | | |
| 17 | Cetak surat yang disetujui | Klik "Cetak PDF" pada pengajuan approved | Generate dan download PDF surat dengan kop lengkap | | |
| 18 | Akses cetak surat pending | Coba akses URL print untuk surat pending | Tombol cetak tidak muncul atau menampilkan error | | |

---

## 4. Pengujian Modul Verifikasi Surat (Admin)

### Tabel 4.1 Pengujian Verifikasi & Manajemen Pengajuan

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|-------------------|-----------|----------------------|-----------------|------------|
| 19 | Mengakses & filter pengajuan | Login sebagai admin, akses `/online-submission`, filter status "Pending" | Menampilkan daftar pengajuan pending | | |
| 20 | Approve pengajuan dengan nomor surat | Nomor: `001/SKD/III/2026`<br>Status: `Approved` | Status berubah approved, notifikasi WhatsApp terkirim ke user | | |
| 21 | Approve tanpa nomor surat | Status: `Approved`<br>Nomor: `(kosong)` | Menampilkan pesan error "Nomor surat harus diisi" | | |
| 22 | Reject pengajuan dengan alasan | Status: `Rejected`<br>Alasan: `Dokumen tidak lengkap` | Status berubah rejected, notifikasi terkirim dengan alasan | | |
| 23 | Reject tanpa alasan | Status: `Rejected`<br>Alasan: `(kosong)` | Menampilkan pesan error "Alasan harus diisi" | | |
| 24 | Cetak & hapus pengajuan | Cetak PDF approved, lalu hapus pengajuan | PDF ter-generate, data terhapus setelah konfirmasi | | |

---

## 5. Pengujian Dashboard

### Tabel 5.1 Pengujian Dashboard Admin & User

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|-------------------|-----------|----------------------|-----------------|------------|
| 25 | Dashboard admin dengan statistik | Login sebagai admin, akses `/dashboard` | Menampilkan statistik penduduk, pengajuan, dan data terbaru | | |
| 26 | Dashboard user dengan ringkasan | Login sebagai user, akses `/user/dashboard` | Menampilkan ringkasan pengajuan dan quick action | | |

---

## 6. Pengujian Keamanan

### Tabel 6.1 Pengujian Keamanan & Otorisasi

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|-------------------|-----------|----------------------|-----------------|------------|
| 27 | Akses halaman admin tanpa login | Akses `/dashboard` tanpa login | Diarahkan ke halaman login | | |
| 28 | Akses halaman admin sebagai user | Login sebagai user, akses `/dashboard` | Menampilkan error 403 atau redirect ke dashboard user | | |
| 29 | SQL Injection pada form login | Email: `admin@desa.com' OR '1'='1`<br>Password: `anything` | Login gagal, query terproteksi | | |
| 30 | Session setelah logout | Logout lalu akses halaman admin | Session dihapus, diarahkan ke login | | |

---

## Ringkasan Total Test Case

### Total Test Case: 30

| Modul | Jumlah Test Case | Prioritas |
|-------|------------------|-----------|
| 1. Autentikasi | 6 | Tinggi |
| 2. Penduduk | 6 | Tinggi |
| 3. Pengajuan Surat (User) | 6 | Tinggi |
| 4. Verifikasi Surat (Admin) | 6 | Tinggi |
| 5. Dashboard | 2 | Sedang |
| 6. Keamanan | 4 | Tinggi |

---

## Catatan Pengujian

### Panduan Pengisian

1. **Hasil Pengujian**: Diisi dengan "✅ Berhasil" atau "❌ Gagal" setelah melakukan pengujian
2. **Kesimpulan**: Diisi dengan "Valid" atau "Tidak Valid" beserta catatan jika diperlukan
3. **Prioritas**: Tinggi (fitur utama), Sedang (fitur pendukung)

### Informasi Pengujian

```
Nama Sistem: Sistem Informasi Desa Badran Sari
Versi: 1.0
Framework: Laravel 11
Tester: [Nama Tester]
Tanggal Mulai: [DD/MM/YYYY]
Tanggal Selesai: [DD/MM/YYYY]
```

---

## Format Laporan Hasil Pengujian

Setelah melakukan pengujian, dokumentasikan dengan format:

**Template Laporan:**

```markdown
### Laporan Pengujian Test Case

**Modul**: [Nama Modul]
**Test Case ID**: [Tabel X.Y - No. Z]
**Tester**: [Nama Tester]
**Tanggal**: [DD/MM/YYYY]
**Browser/Device**: [Chrome/Firefox/Mobile]

**Hasil**: [Berhasil ✅ / Gagal ❌]

**Screenshot**: 
![Screenshot]([path/to/screenshot.png])

**Keterangan**:
[Catatan tambahan, bug yang ditemukan, atau rekomendasi perbaikan]

**Bug Report (jika gagal)**:
- Severity: [Critical/High/Medium/Low]
- Langkah Reproduksi: [Detail langkah]
- Ekspektasi: [Hasil yang diharapkan]
- Aktual: [Hasil yang terjadi]
```

---

## 7. Dokumentasi Implementasi Kode

### 7.1 Arsitektur Aplikasi

Sistem Informasi Desa Badran Sari dibangun menggunakan arsitektur MVC (Model-View-Controller) dengan Laravel 11 sebagai framework utama.

**Stack Teknologi:**
- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade Templates, Bootstrap 4.6.2, JavaScript
- **Database**: MySQL dengan Eloquent ORM
- **Storage**: JSON Files untuk data dinamis (pengajuan surat, berita, profil desa)
- **Authentication**: Laravel Breeze dengan custom middleware
- **Services**: WhatsApp Notification Service

**Struktur Direktori Utama:**
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php           # Autentikasi & registrasi
│   │   ├── ResidentController.php       # CRUD data penduduk
│   │   ├── OnlineSubmissionController.php  # Admin kelola pengajuan
│   │   ├── UserSubmissionController.php    # User pengajuan surat
│   │   ├── DashboardController.php      # Admin dashboard
│   │   └── Frontend/                    # Controller area publik
│   └── Middleware/
│       └── AdminMiddleware.php          # Proteksi route admin
├── Models/
│   ├── User.php                         # Model pengguna
│   ├── Resident.php                     # Model penduduk
│   └── Letter.php                       # Model surat (opsional)
├── Services/
│   └── WhatsAppService.php              # Integrasi WhatsApp Gateway
└── Notifications/
    └── AccountApprovedNotification.php  # Notifikasi approval akun
```

---

### 7.2 Implementasi Modul Autentikasi

**File: `app/Http/Controllers/AuthController.php`**

#### Fitur Login
```php
public function login(Request $request)
{
    // Validasi input
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    // Cek user di database
    $user = \App\Models\User::where('email', $credentials['email'])->first();
    
    // Validasi password
    if ($user && !Hash::check($credentials['password'], $user->password)) {
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
    
    // Cek approval status (untuk user non-admin)
    if ($user && !$user->is_approved && $user->role !== 'admin') {
        return back()->withErrors([
            'email' => 'Akun Anda masih menunggu verifikasi dari administrator.',
        ])->onlyInput('email');
    }
    
    // Attempt login dengan Laravel Auth
    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        return $this->redirectBasedOnRole(Auth::user());
    }
    
    return back()->withErrors(['email' => 'Email atau password salah.']);
}
```

**Poin Penting:**
- Menggunakan `Hash::check()` untuk validasi password yang terenkripsi
- Pengecekan status `is_approved` untuk user yang menunggu verifikasi admin
- `session()->regenerate()` untuk keamanan mencegah session fixation
- Redirect berbasis role (admin ke `/dashboard`, user ke `/user/dashboard`)

#### Fitur Register & Validasi NIK
```php
public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'nik' => 'required|string|min:16|max:16',
        'password' => 'required|min:8|confirmed',
    ]);
    
    // Validasi NIK harus terdaftar di tabel residents
    $resident = \App\Models\Resident::where('nik', $validated['nik'])->first();
    
    if (!$resident) {
        return back()->withErrors([
            'nik' => 'NIK tidak ditemukan di database penduduk. Silakan hubungi admin desa.'
        ])->withInput();
    }
    
    // Cek NIK sudah digunakan user lain
    if (\App\Models\User::where('nik', $validated['nik'])->exists()) {
        return back()->withErrors([
            'nik' => 'NIK sudah terdaftar sebagai user.'
        ])->withInput();
    }
    
    // Buat user baru dengan status pending approval
    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'nik' => $validated['nik'],
        'password' => Hash::make($validated['password']),
        'role' => 'user',
        'is_approved' => false, // Menunggu approval admin
    ]);
    
    return redirect()->route('login')->with('success', 
        'Registrasi berhasil! Silakan tunggu persetujuan dari administrator.');
}
```

**Validasi Keamanan:**
- NIK harus tepat 16 digit
- NIK harus ada di database penduduk (cross-check dengan `residents` table)
- Email harus unique
- Password minimal 8 karakter dan harus dikonfirmasi
- User baru auto role = 'user' dan `is_approved = false`

---

### 7.3 Implementasi Modul Penduduk (CRUD)

**File: `app/Http/Controllers/ResidentController.php`**

#### Fungsi Index - Filter & Search
```php
public function index(Request $request)
{
    $query = Resident::query();
    
    // Filter berdasarkan dusun/hamlet
    if ($request->filled('hamlet')) {
        $query->where('hamlet', $request->hamlet);
    }
    
    // Filter berdasarkan status (active/moved/deceased)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    // Pencarian by nama atau NIK
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('nik', 'like', '%' . $search . '%');
        });
    }
    
    $residents = $query->latest()->get();
    
    // Hitung statistik
    $stats = [
        'total' => Resident::count(),
        'active' => Resident::where('status', 'active')->count(),
        'inactive' => Resident::where('status', '!=', 'active')->count(),
    ];
    
    return view('pages.residents.index', compact('residents', 'stats'));
}
```

#### Fungsi Store - Tambah Penduduk
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'nik' => 'required|string|min:16|max:16|unique:residents,nik',
        'name' => 'required|string|max:100',
        'birth_place' => 'required|string|max:100',
        'birth_date' => 'required|date',
        'gender' => 'required|in:Male,Female',
        'religion' => 'required|string|max:50',
        'occupation' => 'required|string|max:100',
        'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
        'address' => 'required|string',
        'hamlet' => 'nullable|string|max:100',
        'family_card_number' => 'required|string|min:16|max:16',
        'phone' => 'nullable|string|max:15',
        'status' => 'required|in:active,moved,deceased',
    ], [
        'nik.unique' => 'NIK sudah terdaftar',
        'nik.min' => 'NIK harus tepat 16 digit',
        'nik.max' => 'NIK harus tepat 16 digit',
        // ... custom error messages lainnya
    ]);
    
    Resident::create($validated);
    
    return redirect()->route('residents.index')
        ->with('success', 'Data penduduk berhasil ditambahkan!');
}
```

**Validasi Penting:**
- NIK harus unique dan tepat 16 digit
- Gender dan marital_status menggunakan enum validation
- Custom error message berbahasa Indonesia untuk UX lebih baik
- Menggunakan Eloquent ORM `create()` untuk insert ke database

---

### 7.4 Implementasi Modul Pengajuan Surat (User)

**File: `app/Http/Controllers/UserSubmissionController.php`**

#### Dashboard User - Statistik Pengajuan
```php
public function dashboard()
{
    $user = auth()->user();
    
    // Get submissions milik user yang login
    $submissions = $this->getUserSubmissions($user->id);
    
    // Hitung statistik by status
    $stats = [
        'total' => count($submissions),
        'pending' => count(array_filter($submissions, 
            fn($s) => $s['status'] === 'pending')),
        'approved' => count(array_filter($submissions, 
            fn($s) => $s['status'] === 'approved')),
        'rejected' => count(array_filter($submissions, 
            fn($s) => $s['status'] === 'rejected')),
    ];
    
    return view('user.dashboard', compact('submissions', 'stats'));
}
```

#### Fungsi Store - Submit Pengajuan
```php
public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'letter_type' => 'required|string',
        'purpose' => 'required|string',
        'notes' => 'nullable|string',
    ]);
    
    $user = auth()->user();
    $submissions = $this->getAllSubmissions();
    
    // Buat submission baru
    $submission = [
        'id' => uniqid('sub_'),  // Generate unique ID
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_email' => $user->email,
        'user_nik' => $user->nik,
        'letter_type' => $validated['letter_type'],
        'purpose' => $validated['purpose'],
        'notes' => $validated['notes'] ?? '',
        'status' => 'pending',  // Default status
        'letter_number' => null,
        'admin_notes' => null,
        'created_at' => now()->format('Y-m-d H:i:s'),
        'updated_at' => now()->format('Y-m-d H:i:s'),
    ];
    
    $submissions[] = $submission;
    
    // Simpan ke JSON file
    Storage::disk('local')->put('online_submissions.json', 
        json_encode($submissions, JSON_PRETTY_PRINT));
    
    return redirect()->route('user.dashboard')
        ->with('success', 'Pengajuan surat berhasil dikirim!');
}
```

#### Fungsi Print - Cetak PDF Surat
```php
public function print($id)
{
    $submissions = $this->getAllSubmissions();
    $submission = collect($submissions)->firstWhere('id', $id);
    
    // Cek ownership
    if (!$submission || $submission['user_id'] != auth()->id()) {
        return redirect()->route('user.dashboard')
            ->with('error', 'Pengajuan tidak ditemukan');
    }
    
    // Cek status - hanya approved/completed yang bisa diprint
    if (!in_array($submission['status'], ['approved', 'completed'])) {
        return redirect()->route('user.dashboard')
            ->with('error', 'Hanya surat yang sudah disetujui yang dapat dicetak');
    }
    
    return view('user.submission-print', compact('submission'));
}
```

**Fitur Keamanan:**
- User hanya bisa melihat pengajuan miliknya sendiri (filter by `user_id`)
- Tombol cetak hanya muncul jika status = 'approved' atau 'completed'
- Validasi ownership sebelum print atau view detail

---

### 7.5 Implementasi Modul Verifikasi (Admin)

**File: `app/Http/Controllers/OnlineSubmissionController.php`**

#### Fungsi Index - Filter Multi-Status
```php
public function index(Request $request)
{
    $submissions = $this->getSubmissions();
    
    // Filter by status (support multiple dengan comma)
    if ($request->has('status') && $request->status !== '') {
        $statusParam = $request->status;
        
        // Cek apakah multiple status (comma-separated)
        if (strpos($statusParam, ',') !== false) {
            $allowedStatuses = array_map('trim', explode(',', $statusParam));
            $submissions = array_filter($submissions, function($item) use ($allowedStatuses) {
                return in_array($item['status'], $allowedStatuses);
            });
        } else {
            $submissions = array_filter($submissions, function($item) use ($request) {
                return $item['status'] === $request->status;
            });
        }
    }
    
    // Sort by date descending
    usort($submissions, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    
    return view('pages.services.online-submission.index', compact('submissions'));
}
```

#### Fungsi Update Status - Approve/Reject
```php
public function updateStatus(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'status' => 'required|in:pending,approved,rejected,completed',
        'admin_notes' => 'nullable|string',
        'letter_number' => 'required_if:status,approved|nullable|string',
    ], [
        'letter_number.required_if' => 'Nomor surat wajib diisi saat menyetujui pengajuan',
    ]);
    
    $submissions = $this->getSubmissions();
    $index = collect($submissions)->search(fn($item) => $item['id'] === $id);
    
    if ($index === false) {
        return redirect()->back()->with('error', 'Permohonan tidak ditemukan!');
    }
    
    // Update data submission
    $submissions[$index]['status'] = $request->status;
    $submissions[$index]['admin_notes'] = $request->admin_notes;
    $submissions[$index]['updated_at'] = now()->format('Y-m-d H:i:s');
    
    if ($request->status === 'approved') {
        $submissions[$index]['letter_number'] = $request->letter_number;
        $submissions[$index]['approved_at'] = now()->format('Y-m-d H:i:s');
    }
    
    // Simpan perubahan
    Storage::disk('local')->put('online_submissions.json', 
        json_encode($submissions, JSON_PRETTY_PRINT));
    
    // Kirim notifikasi WhatsApp ke user
    $this->sendWhatsAppNotification($submissions[$index]);
    
    return redirect()->route('online-submission.index')
        ->with('success', 'Status permohonan berhasil diupdate!');
}

private function sendWhatsAppNotification($submission)
{
    $user = User::find($submission['user_id']);
    
    if ($user && $user->phone) {
        $whatsappService = new WhatsAppService();
        
        $message = "Halo {$user->name}, ";
        if ($submission['status'] === 'approved') {
            $message .= "pengajuan surat Anda telah *DISETUJUI* dengan nomor: {$submission['letter_number']}. ";
            $message .= "Silakan login untuk mencetak surat.";
        } else {
            $message .= "pengajuan surat Anda telah *DITOLAK*. ";
            $message .= "Alasan: {$submission['admin_notes']}";
        }
        
        $whatsappService->sendMessage($user->phone, $message);
    }
}
```

**Validasi Bisnis:**
- Jika status = 'approved', nomor surat **wajib diisi** (required_if validation)
- Jika status = 'rejected', admin_notes direkomendasikan untuk alasan penolakan
- Setelah update status, kirim notifikasi WhatsApp otomatis ke user
- Timestamp `approved_at` dicatat saat approved

---

### 7.6 Routing & Middleware

**File: `routes/web.php`**

```php
// Public Routes (tanpa login)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [FrontendNewsController::class, 'index'])->name('berita.index');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// User Routes (butuh auth)
Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [UserSubmissionController::class, 'dashboard'])
        ->name('user.dashboard');
    Route::get('/user/submission/create', [UserSubmissionController::class, 'create'])
        ->name('user.submission.create');
    Route::post('/user/submission', [UserSubmissionController::class, 'store'])
        ->name('user.submission.store');
    Route::get('/user/submission/{id}/print', [UserSubmissionController::class, 'print'])
        ->name('user.submission.print');
});

// Admin Routes (butuh auth + role admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('residents', ResidentController::class);
    Route::resource('online-submission', OnlineSubmissionController::class);
    Route::post('/online-submission/{id}/update-status', 
        [OnlineSubmissionController::class, 'updateStatus'])
        ->name('online-submission.update-status');
});
```

**Middleware `admin`:**
```php
// File: app/Http/Middleware/AdminMiddleware.php
public function handle(Request $request, Closure $next)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }
    
    return $next($request);
}
```

**Keamanan Routing:**
- Route public tidak butuh middleware
- Route `/user/*` butuh middleware `auth` (user sudah login)
- Route `/dashboard`, `/residents`, `/online-submission` butuh middleware `auth` + `admin`
- Jika user non-admin akses route admin → Error 403 Forbidden

---

### 7.7 Model & Database Schema

#### Model User
**File: `app/Models/User.php`**
```php
protected $fillable = [
    'name', 'email', 'password', 'nik', 'role', 'is_approved', 'phone'
];

protected $hidden = ['password', 'remember_token'];

protected $casts = [
    'email_verified_at' => 'datetime',
    'is_approved' => 'boolean',
];

// Relation
public function resident()
{
    return $this->belongsTo(Resident::class, 'nik', 'nik');
}
```

**Kolom Penting:**
- `role`: enum('admin', 'user')
- `is_approved`: boolean untuk approval registrasi user
- `nik`: foreign key ke tabel residents

#### Model Resident
**File: `app/Models/Resident.php`**
```php
protected $fillable = [
    'nik', 'name', 'birth_place', 'birth_date', 'gender',
    'religion', 'occupation', 'marital_status', 'address',
    'hamlet', 'family_card_number', 'phone', 'status'
];

protected $casts = [
    'birth_date' => 'date',
];

// Scope untuk filter active residents
public function scopeActive($query)
{
    return $query->where('status', 'active');
}
```

**Database Migration (residents):**
```php
Schema::create('residents', function (Blueprint $table) {
    $table->id();
    $table->string('nik', 16)->unique();
    $table->string('name', 100);
    $table->string('birth_place', 100);
    $table->date('birth_date');
    $table->enum('gender', ['Male', 'Female']);
    $table->string('religion', 50);
    $table->string('occupation', 100);
    $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed']);
    $table->text('address');
    $table->string('hamlet', 100)->nullable();
    $table->string('family_card_number', 16);
    $table->string('phone', 15)->nullable();
    $table->enum('status', ['active', 'moved', 'deceased'])->default('active');
    $table->timestamps();
});
```

---

### 7.8 WhatsApp Notification Service

**File: `app/Services/WhatsAppService.php`**

```php
class WhatsAppService
{
    private $apiUrl;
    private $token;
    
    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url');
        $this->token = config('services.whatsapp.token');
    }
    
    public function sendMessage($phone, $message)
    {
        // Format nomor telepon (pastikan +62)
        $phone = $this->formatPhoneNumber($phone);
        
        $data = [
            'phone' => $phone,
            'message' => $message,
        ];
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])->post($this->apiUrl . '/send-message', $data);
            
            return $response->successful();
        } catch (\Exception $e) {
            \Log::error('WhatsApp send failed: ' . $e->getMessage());
            return false;
        }
    }
    
    private function formatPhoneNumber($phone)
    {
        // Hapus karakter non-numeric
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Ubah 08xx menjadi 628xx
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        return $phone;
    }
}
```

**Konfigurasi (`config/services.php`):**
```php
'whatsapp' => [
    'api_url' => env('WHATSAPP_API_URL', 'https://api.whatsapp.com'),
    'token' => env('WHATSAPP_API_TOKEN', ''),
],
```

**Penggunaan:**
- Otomatis kirim notifikasi saat admin approve/reject pengajuan surat
- Format nomor HP otomatis ke format internasional (+62)
- Error handling dengan Log jika gagal kirim

---

### 7.9 Flow Lengkap Use Case

#### Use Case: User Mengajukan Surat

**Langkah-langkah:**

1. **User Login** → `AuthController@login()`
   - Validasi email & password
   - Cek status `is_approved`
   - Redirect ke `/user/dashboard`

2. **User Mengisi Form Pengajuan** → `UserSubmissionController@create()`
   - Tampilkan form dengan dropdown jenis surat
   - Validasi field wajib (letter_type, purpose)

3. **Submit Pengajuan** → `UserSubmissionController@store()`
   - Validasi input
   - Generate unique ID dengan `uniqid('sub_')`
   - Simpan ke `storage/app/online_submissions.json`
   - Status default = 'pending'
   - Redirect dengan success message

4. **Admin Review** → `OnlineSubmissionController@index()`
   - Filter pengajuan status 'pending'
   - Klik detail untuk review

5. **Admin Approve** → `OnlineSubmissionController@updateStatus()`
   - Validasi nomor surat wajib diisi
   - Update status jadi 'approved'
   - Simpan `letter_number` dan `approved_at`
   - Kirim notifikasi WhatsApp ke user

6. **User Cetak Surat** → `UserSubmissionController@print()`
   - Cek ownership (hanya bisa cetak surat sendiri)
   - Cek status (hanya 'approved' atau 'completed')
   - Generate PDF dengan nomor surat dan kop desa

**Diagram Flow:**
```
[User Register] → NIK Validation → [Pending Approval]
       ↓
[Admin Approve User] → is_approved = true
       ↓
[User Login] → [Dashboard] → [Form Pengajuan Surat]
       ↓
[Submit Pengajuan] → status = 'pending' → [Admin Review]
       ↓
[Admin Approve/Reject] → WhatsApp Notification
       ↓
[User Cetak PDF] (jika approved)
```

---

### 7.10 Fitur Keamanan yang Diimplementasikan

#### 1. **SQL Injection Protection**
- Menggunakan Eloquent ORM dan Query Builder
- Semua input auto-escaped
- Prepared statements di background

```php
// AMAN: menggunakan Eloquent
$user = User::where('email', $request->email)->first();

// BAHAYA (tidak digunakan):
// $user = DB::raw("SELECT * FROM users WHERE email = '$email'");
```

#### 2. **CSRF Protection**
- Laravel otomatis inject `@csrf` token di setiap form
- Middleware `VerifyCsrfToken` memvalidasi setiap POST request

```blade
<form method="POST" action="/login">
    @csrf  <!-- Token otomatis divalidasi -->
    ...
</form>
```

#### 3. **Password Hashing**
- Menggunakan `Hash::make()` untuk enkripsi password
- Algoritma bcrypt dengan 10 rounds

```php
'password' => Hash::make($request->password)
```

#### 4. **Session Security**
- Session regeneration setelah login → `session()->regenerate()`
- Session invalidation saat logout → `session()->invalidate()`
- HttpOnly cookies (tidak bisa diakses JavaScript)

#### 5. **Authorization Middleware**
- Route admin dilindungi middleware `admin`
- Cek ownership sebelum akses user data (pengajuan surat)

```php
// Cek apakah user pemilik submission
if ($submission['user_id'] != auth()->id()) {
    abort(403);
}
```

#### 6. **Validation & Sanitization**
- Semua input divalidasi dengan Laravel Validation
- Custom error message berbahasa Indonesia
- XSS protection otomatis di Blade (`{{ }}` auto-escape)

---

### 7.11 Potongan Kode Implementasi Sistem

Berikut adalah potongan kode penting dari implementasi sistem yang digunakan dalam pengujian black box:

---

#### **Kode 4.28 - Potongan kode halaman Login Admin**

```html
1.  <!DOCTYPE html>
2.  <html lang="id">
3.  <head>
4.      <meta charset="UTF-8">
5.      <meta name="viewport" content="width=device-width, initial-scale=1.0">
6.      <title>Login - Sistem Informasi</title>
7.      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
8.      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
9.      <style>
10.         body {
11.             background: linear-gradient(135deg, #0f7b2a 0%, #1a5f3a 100%);
12.             min-height: 100vh;
13.             display: flex;
14.             align-items: center;
15.             justify-content: center;
16.         }
17.         .login-card {
18.             background: white;
19.             border-radius: 15px;
20.             box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
21.         }
22.     </style>
23. </head>
24. <body>
25.     <div class="login-container">
26.         <div class="login-card">
27.             <div class="login-header">
28.                 <div class="login-logo">
29.                     <img src="{{ asset('images/logo-lampung-tengah.png') }}" alt="Logo">
30.                 </div>
31.                 <div class="login-title">Sistem Informasi</div>
32.                 <div class="login-subtitle">Kampung Badran Sari</div>
33.             </div>
34.             <div class="login-body">
35.                 <form action="{{ route('login.post') }}" method="POST">
36.                     @csrf
37.                     <div class="mb-3">
38.                         <label for="email" class="form-label">Email</label>
39.                         <input type="email" class="form-control" id="email" 
40.                                name="email" required autofocus>
41.                     </div>
42.                     <div class="mb-3">
43.                         <label for="password" class="form-label">Password</label>
44.                         <input type="password" class="form-control" 
45.                                id="password" name="password" required>
46.                     </div>
47.                     <button type="submit" class="btn btn-login">Login</button>
48.                 </form>
49.             </div>
50.         </div>
51.     </div>
52. </body>
53. </html>
```

**Keterangan:**
- **Baris 1-8**: Deklarasi HTML dan import library Bootstrap & Font Awesome
- **Baris 10-22**: Styling CSS untuk tampilan login dengan gradient hijau (#0f7b2a)
- **Baris 27-33**: Header login dengan logo dan judul sistem
- **Baris 35-48**: Form login dengan field email, password, dan tombol submit
- **Baris 36**: Token CSRF untuk keamanan Laravel

---

#### **Kode 4.29 - Potongan kode Controller Login (AuthController.php)**

```php
1.  <?php
2.  namespace App\Http\Controllers;
3.  
4.  use Illuminate\Http\Request;
5.  use Illuminate\Support\Facades\Auth;
6.  use Illuminate\Support\Facades\Hash;
7.  
8.  class AuthController extends Controller
9.  {
10.     public function login(Request $request)
11.     {
12.         $credentials = $request->validate([
13.             'email' => 'required|email',
14.             'password' => 'required',
15.         ]);
16.         
17.         $user = \App\Models\User::where('email', $credentials['email'])->first();
18.         
19.         if ($user && !Hash::check($credentials['password'], $user->password)) {
20.             return back()->withErrors([
21.                 'email' => 'Email atau password salah.',
22.             ])->onlyInput('email');
23.         }
24.         
25.         if ($user && !$user->is_approved && $user->role !== 'admin') {
26.             return back()->withErrors([
27.                 'email' => 'Akun Anda masih menunggu verifikasi dari administrator.',
28.             ])->onlyInput('email');
29.         }
30.         
31.         if (Auth::attempt($credentials, $request->filled('remember'))) {
32.             $request->session()->regenerate();
33.             return $this->redirectBasedOnRole(Auth::user());
34.         }
35.         
36.         return back()->withErrors(['email' => 'Email atau password salah.']);
37.     }
38.     
39.     private function redirectBasedOnRole($user)
40.     {
41.         if ($user->role === 'admin') {
42.             return redirect()->route('dashboard');
43.         }
44.         return redirect()->route('user.dashboard');
45.     }
46. }
```

**Keterangan:**
- **Baris 12-15**: Validasi input email dan password wajib diisi
- **Baris 17**: Query user berdasarkan email dari database
- **Baris 19-23**: Validasi password dengan Hash::check untuk keamanan
- **Baris 25-29**: Cek status approval user (mencegah login jika belum disetujui admin)
- **Baris 31-33**: Proses login dengan Laravel Auth dan regenerasi session
- **Baris 39-45**: Redirect berdasarkan role (admin atau user)

---

#### **Kode 4.30 - Potongan kode Hero Landing Page**

```html
1.  {{-- Hero Carousel Section --}}
2.  <section class="hero-carousel">
3.      <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
4.          <div class="carousel-inner">
5.              <div class="carousel-item active">
6.                  <img src="{{ asset('images/hero-1.jpg') }}" class="d-block w-100" alt="Hero 1">
7.                  <div class="carousel-caption">
8.                      <h1 class="hero-title" data-aos="fade-up">Selamat Datang di</h1>
9.                      <h2 class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
10.                         Kampung Badran Sari
11.                     </h2>
12.                     <p class="hero-description" data-aos="fade-up" data-aos-delay="200">
13.                         Kecamatan Punggur - Kabupaten Lampung Tengah
14.                     </p>
15.                     <div class="hero-buttons" data-aos="fade-up" data-aos-delay="300">
16.                         <a href="{{ url('/profil-desa') }}" class="btn btn-light btn-lg me-3">
17.                             <i class="fas fa-info-circle me-2"></i>Profil Desa
18.                         </a>
19.                         <a href="{{ url('/layanan') }}" class="btn btn-outline-light btn-lg">
20.                             <i class="fas fa-file-alt me-2"></i>Layanan Surat
21.                         </a>
22.                     </div>
23.                 </div>
24.             </div>
25.         </div>
26.         <button class="carousel-control-prev" type="button" 
27.                 data-bs-target="#heroCarousel" data-bs-slide="prev">
28.             <span class="carousel-control-prev-icon"></span>
29.         </button>
30.     </div>
31. </section>
```

**Keterangan:**
- **Baris 2-3**: Container carousel Bootstrap untuk slideshow hero section
- **Baris 5-6**: Item carousel dengan gambar hero sebagai background
- **Baris 8-14**: Teks judul dan deskripsi dengan animasi AOS (fade-up)
- **Baris 16-21**: Tombol CTA (Call-to-Action) untuk Profil Desa dan Layanan Surat
- **Baris 26-29**: Kontrol navigasi carousel (prev/next)

---

#### **Kode 4.31 - Potongan kode Dashboard Admin**

```php
1.  @extends('layouts.app')
2.  
3.  @section('title', 'Dashboard')
4.  
5.  @section('content')
6.  <div class="dashboard-container">
7.      <h1 class="dashboard-title">DASHBOARD ADMIN</h1>
8.      
9.      <div class="stats-grid">
10.         {{-- Card Total Penduduk --}}
11.         <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
12.             <div class="stat-card-body">
13.                 <div class="stat-content">
14.                     <div class="stat-text">
15.                         <div class="stat-value">{{ $totalResidents }}</div>
16.                         <div class="stat-label">Total Penduduk</div>
17.                     </div>
18.                     <div class="stat-icon">
19.                         <i class="fas fa-users"></i>
20.                     </div>
21.                 </div>
22.             </div>
23.             <a href="{{ route('residents.index') }}" class="stat-card-footer">
24.                 <span>Lihat Detail</span>
25.                 <i class="fas fa-arrow-right"></i>
26.             </a>
27.         </div>
28.         
29.         {{-- Card Pengajuan Pending --}}
30.         <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
31.             <div class="stat-card-body">
32.                 <div class="stat-content">
33.                     <div class="stat-text">
34.                         <div class="stat-value">{{ $pendingSubmissions }}</div>
35.                         <div class="stat-label">Pengajuan Menunggu</div>
36.                     </div>
37.                     <div class="stat-icon">
38.                         <i class="fas fa-clock"></i>
39.                     </div>
40.                 </div>
41.             </div>
42.             <a href="{{ route('online-submission.index') }}?status=pending" 
43.                class="stat-card-footer">
44.                 <span>Proses Sekarang</span>
45.                 <i class="fas fa-arrow-right"></i>
46.             </a>
47.         </div>
48.     </div>
49. </div>
50. @endsection
```

**Keterangan:**
- **Baris 1**: Extends layout app untuk struktur halaman admin
- **Baris 7**: Judul dashboard dengan styling khusus
- **Baris 9-27**: Card statistik total penduduk dengan gradient ungu dan icon users
- **Baris 15**: Menampilkan variabel `$totalResidents` dari controller
- **Baris 23-26**: Link ke halaman detail residents dengan icon arrow
- **Baris 30-47**: Card statistik pengajuan pending dengan gradient pink
- **Baris 42-43**: Link filter ke pengajuan dengan status pending

---

#### **Kode 4.32 - Potongan kode Validasi Pengajuan Surat**

```php
1.  public function store(Request $request)
2.  {
3.      $validated = $request->validate([
4.          'letter_type' => 'required|string',
5.          'purpose' => 'required|string',
6.          'notes' => 'nullable|string',
7.      ]);
8.      
9.      $user = auth()->user();
10.     $submissions = $this->getAllSubmissions();
11.     
12.     $submission = [
13.         'id' => uniqid('sub_'),
14.         'user_id' => $user->id,
15.         'user_name' => $user->name,
16.         'user_email' => $user->email,
17.         'user_nik' => $user->nik,
18.         'letter_type' => $validated['letter_type'],
19.         'purpose' => $validated['purpose'],
20.         'notes' => $validated['notes'] ?? '',
21.         'status' => 'pending',
22.         'letter_number' => null,
23.         'admin_notes' => null,
24.         'created_at' => now()->format('Y-m-d H:i:s'),
25.         'updated_at' => now()->format('Y-m-d H:i:s'),
26.     ];
27.     
28.     $submissions[] = $submission;
29.     
30.     Storage::disk('local')->put('online_submissions.json', 
31.         json_encode($submissions, JSON_PRETTY_PRINT));
32.     
33.     return redirect()->route('user.dashboard')
34.         ->with('success', 'Pengajuan surat berhasil dikirim!');
35. }
```

**Keterangan:**
- **Baris 3-7**: Validasi form pengajuan (jenis surat dan tujuan wajib diisi)
- **Baris 9-10**: Ambil data user yang login dan semua submissions
- **Baris 13**: Generate unique ID dengan prefix 'sub_'
- **Baris 14-20**: Mapping data user dan input form ke array submission
- **Baris 21**: Status default 'pending' saat submit
- **Baris 30-31**: Simpan ke file JSON dengan format pretty print
- **Baris 33-34**: Redirect dengan pesan sukses

---

#### **Kode 4.33 - Potongan kode Middleware Admin**

```php
1.  <?php
2.  namespace App\Http\Middleware;
3.  
4.  use Closure;
5.  use Illuminate\Http\Request;
6.  use Illuminate\Support\Facades\Auth;
7.  
8.  class AdminMiddleware
9.  {
10.     public function handle(Request $request, Closure $next)
11.     {
12.         if (!Auth::check()) {
13.             return redirect()->route('login')
14.                 ->with('error', 'Silakan login terlebih dahulu.');
15.         }
16.         
17.         if (Auth::user()->role !== 'admin') {
18.             abort(403, 'Unauthorized action. Admin access only.');
19.         }
20.         
21.         return $next($request);
22.     }
23. }
```

**Keterangan:**
- **Baris 12-15**: Cek apakah user sudah login, jika belum redirect ke halaman login
- **Baris 17-19**: Cek role user, jika bukan 'admin' tampilkan error 403 Forbidden
- **Baris 21**: Lanjutkan request jika lolos validasi (user adalah admin)

---

### 7.12 Summary Teknis

| Aspek | Implementasi |
|-------|--------------|
| **Framework** | Laravel 11 |
| **PHP Version** | 8.2+ |
| **Database** | MySQL dengan Eloquent ORM |
| **Storage** | JSON files di `storage/app/` |
| **Authentication** | Laravel Breeze + Custom Middleware |
| **Authorization** | Role-based (admin/user) + Middleware |
| **Validation** | Laravel Request Validation |
| **Security** | CSRF, Bcrypt, Session Regeneration, Query Builder |
| **Notification** | WhatsApp API Integration |
| **PDF Generation** | Blade View → wkhtmltopdf (opsional) |

**Jumlah Controller:** 17 files
**Jumlah Model:** 4 models (User, Resident, Family, Letter)
**Jumlah Route:** ~50 routes (public, auth, user, admin)
**Lines of Code:** ~3000 LOC (estimasi)

---

## Kesimpulan

Dokumentasi ini mencakup **30 test case paling penting** untuk Sistem Informasi Desa Badran Sari:

✅ **Autentikasi (6)** - Login valid/invalid untuk Admin & User, Register dengan NIK valid/invalid  
✅ **Manajemen Penduduk (6)** - CRUD data penduduk dengan validasi NIK dan akses  
✅ **Pengajuan Surat (6)** - User mengajukan surat, melihat status, dan cetak PDF jika approved  
✅ **Verifikasi Surat (6)** - Admin memproses, approve/reject dengan validasi input  
✅ **Dashboard (2)** - Monitoring statistik untuk Admin dan User  
✅ **Keamanan (4)** - Validasi akses, proteksi SQL Injection, dan session management

Setiap test case harus dijalankan sesuai skenario untuk memastikan sistem berfungsi dengan baik dan aman.

---

**Dibuat oleh**: GitHub Copilot  
**Tanggal**: 3 Maret 2026  
**Status**: Ready for Testing ✅
