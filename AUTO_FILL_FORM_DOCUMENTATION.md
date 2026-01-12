# Dokumentasi Fitur Auto-Fill Form Pengajuan Surat

## 📋 Ringkasan Fitur

Fitur ini memungkinkan user untuk membuat pengajuan surat dengan data yang otomatis terisi (auto-fill) dari database `residents`. User juga dapat memilih untuk mengajukan surat atas nama **diri sendiri** atau **anggota keluarga** yang terdaftar dengan nomor KK yang sama.

---

## 🎯 Tujuan

1. **Mempercepat Proses Pengajuan**: Data pemohon otomatis terisi tanpa perlu input manual berulang
2. **Mengurangi Kesalahan Input**: Data diambil dari database yang sudah tervalidasi
3. **Mendukung Pengajuan untuk Keluarga**: User dapat mengajukan surat untuk anggota keluarga lain dalam satu KK

---

## 🔄 Alur Kerja

### 1. User Login
- User yang sudah login dan akun sudah diverifikasi admin
- User memiliki data lengkap di tabel `residents`

### 2. Akses Form Pengajuan
- User masuk ke menu **Layanan Publik** → **Ajukan Surat**
- Sistem mengambil data resident user dari database

### 3. Pilih Pemohon
Jika user memiliki anggota keluarga (nomor KK sama), akan muncul pilihan:
- ✅ **Diri Sendiri**: Menggunakan data user yang login
- ✅ **Anggota Keluarga**: Menggunakan data anggota keluarga lain

### 4. Auto-Fill Data
Saat memilih pemohon, form otomatis terisi:
- ✅ Nama Lengkap
- ✅ NIK
- ✅ Alamat Lengkap
- ✅ Pekerjaan
- ✅ No. Telepon

### 5. Isi Detail Surat
User melengkapi informasi tambahan:
- Jenis Surat (dropdown)
- Keperluan (textarea, min 10 karakter)
- Catatan Tambahan (optional)

### 6. Submit Pengajuan
- Data tersimpan di `storage/app/online_submissions.json`
- Status awal: **Pending**
- User dapat memantau status di menu **Riwayat Pengajuan**

---

## 💾 Struktur Database

### Tabel: `residents`
```sql
CREATE TABLE residents (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT FOREIGN KEY REFERENCES users(id),
    nik VARCHAR(16) NOT NULL,
    family_card_number VARCHAR(16),
    name VARCHAR(255) NOT NULL,
    gender ENUM('Laki-laki', 'Perempuan'),
    birth_date DATE,
    birth_place VARCHAR(100),
    address TEXT,
    hamlet VARCHAR(100),
    religion VARCHAR(50),
    marital_status VARCHAR(50),
    occupation VARCHAR(100),
    phone VARCHAR(15),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Relasi Database
```
users (1) ←→ (1) residents
residents (n) → (1) family_card_number [same number = family members]
```

---

## 📁 File yang Terlibat

### Backend

#### 1. **ServiceController.php**
Path: `app/Http/Controllers/Frontend/ServiceController.php`

**Method: `create()`**
```php
public function create()
{
    $letterTypes = $this->getLetterTypes();
    
    // Get resident data of logged-in user
    $resident = auth()->user()->resident;
    
    // Get family members if family_card_number exists
    $familyMembers = [];
    if ($resident && $resident->family_card_number) {
        $familyMembers = \App\Models\Resident::where('family_card_number', $resident->family_card_number)
            ->where('id', '!=', $resident->id)
            ->where('status', 'active')
            ->get();
    }
    
    return view('frontend.services.form', compact('letterTypes', 'resident', 'familyMembers'));
}
```

**Method: `store()`**
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'resident_id' => 'nullable|exists:residents,id',
        'name' => 'required|string|max:255',
        'nik' => 'required|numeric|digits:16',
        'address' => 'required|string',
        'occupation' => 'required|string|max:100',
        'phone' => 'required|string|max:15',
        'letter_type' => 'required|string',
        'purpose' => 'required|string|min:10',
        'notes' => 'nullable|string',
    ]);
    
    $user = auth()->user();
    
    $submission = [
        'id' => uniqid('sub_'),
        'user_id' => $user->id,
        'resident_id' => $validated['resident_id'] ?? $user->resident->id ?? null,
        'name' => $validated['name'],
        'nik' => $validated['nik'],
        'address' => $validated['address'],
        'occupation' => $validated['occupation'],
        'phone' => $validated['phone'],
        'user_email' => $user->email,
        'letter_type' => $validated['letter_type'],
        'purpose' => $validated['purpose'],
        'notes' => $validated['notes'] ?? '',
        'status' => 'pending',
        'created_at' => now()->format('Y-m-d H:i:s'),
        'updated_at' => now()->format('Y-m-d H:i:s'),
    ];
    
    // Save to JSON file
    // ... (logic lainnya)
}
```

#### 2. **Resident.php Model**
Path: `app/Models/Resident.php`

```php
class Resident extends Model
{
    protected $fillable = [
        'user_id',
        'nik',
        'family_card_number',
        'name',
        'gender',
        'birth_date',
        'birth_place',
        'address',
        'hamlet',
        'religion',
        'marital_status',
        'occupation',
        'phone',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function familyMembers()
    {
        return $this->hasMany(Resident::class, 'family_card_number', 'family_card_number')
            ->where('id', '!=', $this->id)
            ->where('status', 'active');
    }
}
```

#### 3. **User.php Model**
Path: `app/Models/User.php`

```php
public function resident()
{
    return $this->hasOne(Resident::class);
}
```

---

### Frontend

#### 1. **form.blade.php**
Path: `resources/views/frontend/services/form.blade.php`

**Fitur Utama:**
- ✅ Radio button untuk pilih pemohon (diri sendiri / anggota keluarga)
- ✅ Auto-fill 5 field: name, nik, address, occupation, phone
- ✅ JavaScript untuk update data saat pilihan berubah
- ✅ Hidden field `resident_id` untuk track siapa yang mengajukan

**HTML Structure:**
```blade
<!-- Pilih Pemohon Section -->
@if($resident && $familyMembers->count() > 0)
<div class="alert alert-success mb-4">
    <h6>Pilih Pemohon Surat</h6>
    <div class="form-group">
        <!-- Radio: Diri Sendiri -->
        <input type="radio" name="applicant_type" value="self" checked>
        
        <!-- Radio: Anggota Keluarga -->
        @foreach($familyMembers as $member)
            <input type="radio" name="applicant_type" value="{{ $member->id }}">
        @endforeach
    </div>
    <input type="hidden" name="resident_id" id="resident_id">
</div>
@endif

<!-- Form Fields (readonly, auto-filled) -->
<input type="text" name="name" id="applicant_name" readonly>
<input type="text" name="nik" id="applicant_nik" readonly>
<textarea name="address" id="applicant_address" readonly></textarea>
<input type="text" name="occupation" id="applicant_occupation" readonly>
<input type="text" name="phone" id="applicant_phone" readonly>
```

**JavaScript Logic:**
```javascript
document.addEventListener('DOMContentLoaded', function() {
    const applicantRadios = document.querySelectorAll('.applicant-radio');
    
    applicantRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                updateFormFields(this);
            }
        });
    });

    function updateFormFields(radio) {
        // Get data attributes
        const nik = radio.dataset.nik || '';
        const name = radio.dataset.name || '';
        const address = radio.dataset.address || '';
        const occupation = radio.dataset.occupation || '';
        const phone = radio.dataset.phone || '';

        // Update form fields
        document.getElementById('applicant_name').value = name;
        document.getElementById('applicant_nik').value = nik;
        document.getElementById('applicant_address').value = address;
        document.getElementById('applicant_occupation').value = occupation;
        document.getElementById('applicant_phone').value = phone;

        // Update resident_id
        if (radio.value === 'self') {
            document.getElementById('resident_id').value = '';
        } else {
            document.getElementById('resident_id').value = radio.value;
        }
    }
});
```

---

## 🧪 Testing & Validasi

### Skenario Testing

#### 1. **User Tanpa Data Resident**
**Expected:**
- Form tetap bisa diakses
- Field name terisi dengan `auth()->user()->name`
- Field lain kosong (manual input)
- Tidak ada section "Pilih Pemohon"

#### 2. **User dengan Data Resident (Tanpa Keluarga)**
**Expected:**
- Field auto-fill dengan data user resident
- Tidak ada section "Pilih Pemohon"
- `resident_id` = user's resident id

#### 3. **User dengan Data Resident + Ada Anggota Keluarga**
**Expected:**
- Muncul section "Pilih Pemohon"
- Default checked: "Diri Sendiri"
- Menampilkan list anggota keluarga (radio buttons)
- Saat pilih anggota keluarga, semua field otomatis berubah
- `resident_id` berubah sesuai pilihan

#### 4. **Validasi Submit**
**Expected:**
- Validasi NIK 16 digit
- Validasi keperluan minimal 10 karakter
- Data tersimpan ke JSON dengan `resident_id` yang benar
- Redirect ke halaman riwayat dengan success message

---

## 🔒 Keamanan

### Validasi Backend
```php
// ServiceController.php - store()
$validated = $request->validate([
    'resident_id' => 'nullable|exists:residents,id',  // Must exist in DB
    'name' => 'required|string|max:255',
    'nik' => 'required|numeric|digits:16',           // Exactly 16 digits
    'address' => 'required|string',
    'occupation' => 'required|string|max:100',
    'phone' => 'required|string|max:15',
    'letter_type' => 'required|string',
    'purpose' => 'required|string|min:10',           // Min 10 chars
    'notes' => 'nullable|string',
]);
```

### Proteksi Data
- ✅ Field pemohon `readonly` (tidak bisa diubah manual)
- ✅ Validasi `resident_id` harus exist di database
- ✅ Hanya user yang login bisa akses
- ✅ Data keluarga dibatasi dengan `family_card_number` yang sama

---

## 📊 Data Flow Diagram

```
┌─────────────┐
│   User      │
│   Login     │
└──────┬──────┘
       │
       ▼
┌─────────────────────────┐
│  ServiceController      │
│  create()               │
│                         │
│  1. Get user resident   │
│  2. Get family members  │
│     (same KK number)    │
└──────┬──────────────────┘
       │
       ▼
┌─────────────────────────┐
│  form.blade.php         │
│                         │
│  Display:               │
│  - Radio buttons        │
│  - Auto-filled fields   │
└──────┬──────────────────┘
       │
       ▼ (User selects & submits)
┌─────────────────────────┐
│  ServiceController      │
│  store()                │
│                         │
│  1. Validate input      │
│  2. Determine resident  │
│  3. Save to JSON        │
└──────┬──────────────────┘
       │
       ▼
┌─────────────────────────┐
│  online_submissions     │
│  .json                  │
│                         │
│  Saved with:            │
│  - user_id              │
│  - resident_id          │
│  - submission data      │
└─────────────────────────┘
```

---

## 🎨 UI/UX Features

### Visual Elements

1. **Alert Box (Pilih Pemohon)**
   - Background: `#e8f5e9` (light green)
   - Border: `#4a7c2c` (green)
   - Icon: Font Awesome `fa-users`

2. **Radio Buttons**
   - Custom styling
   - Active color: `#4a7c2c`
   - Clear labels with NIK display

3. **Form Fields**
   - Readonly fields: slightly grayed background
   - Focus state: green border `#4a7c2c`
   - Smooth transitions

### Responsive Design
- ✅ Mobile-friendly layout
- ✅ Grid system untuk 2 kolom (pekerjaan & telepon)
- ✅ Stack pada layar kecil

---

## 🚀 Cara Penggunaan

### Untuk User

1. **Login** ke akun yang sudah diverifikasi
2. Pastikan data resident sudah lengkap (NIK, alamat, pekerjaan, telepon)
3. Buka menu **Layanan Publik** → **Ajukan Surat**
4. Jika ada anggota keluarga, pilih pemohon (diri sendiri / anggota keluarga)
5. Data otomatis terisi
6. Pilih **Jenis Surat** dari dropdown
7. Isi **Keperluan** dengan detail (min 10 karakter)
8. (Opsional) Isi **Catatan Tambahan**
9. Klik **Kirim Pengajuan**
10. Cek status di **Riwayat Pengajuan**

### Untuk Admin

1. Monitor pengajuan di dashboard admin
2. Lihat detail pemohon:
   - Data lengkap otomatis tersedia
   - `resident_id` untuk tracking
3. Approve/Reject sesuai kebijakan
4. Generate nomor surat otomatis

---

## 🛠️ Maintenance & Troubleshooting

### Common Issues

#### Issue 1: Data tidak auto-fill
**Penyebab:** User belum memiliki data resident
**Solusi:** 
- Pastikan saat register, user mengisi form lengkap
- Data resident harus tersimpan di tabel `residents` dengan `user_id` yang benar

#### Issue 2: Anggota keluarga tidak muncul
**Penyebab:** Nomor KK tidak sama atau status inactive
**Solusi:**
- Cek `family_card_number` di database
- Pastikan status = 'active' untuk semua anggota keluarga

#### Issue 3: Error saat submit
**Penyebab:** Validasi gagal
**Solusi:**
- NIK harus 16 digit angka
- Keperluan minimal 10 karakter
- Semua field wajib terisi

### Debug Commands
```bash
# Check user resident relationship
php artisan tinker
>>> $user = User::find(1);
>>> $user->resident;

# Check family members
>>> $resident = Resident::find(1);
>>> $resident->familyMembers;

# Clear cache if needed
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 📝 Changelog

### Version 1.0 (Latest)
- ✅ Auto-fill form data dari residents table
- ✅ Fitur pilih pemohon (diri sendiri / anggota keluarga)
- ✅ JavaScript untuk dynamic field updates
- ✅ Validasi `resident_id` di backend
- ✅ Responsive UI dengan Bootstrap
- ✅ Integration dengan existing submission system

---

## 🔮 Future Enhancements

1. **Upload Dokumen Pendukung**
   - Foto/scan KTP
   - Kartu Keluarga
   - Dokumen lainnya

2. **Preview Surat**
   - Template preview sebelum submit
   - PDF preview untuk admin

3. **Notifikasi Real-time**
   - WebSocket untuk status updates
   - Push notification ke browser

4. **History & Analytics**
   - Dashboard statistik pengajuan
   - Export data ke Excel/PDF

---

## 📞 Support

Jika ada pertanyaan atau issue, silakan hubungi:
- **Developer**: [Your Name]
- **Email**: [Your Email]
- **Repository**: [GitHub URL]

---

**Last Updated**: January 2026
**Version**: 1.0.0
**Laravel Version**: 11.x
