    # ERD SISTEM INFORMASI DESA - LAYOUT LAYER

## 📐 VISUALISASI LAYOUT DENGAN STRUKTUR LAYER

```
╔═══════════════════════════════════════════════════════════════════════════╗
║                                                                           ║
║  LAYER 1: SISTEM ADMIN (Puncak Hirarki - KONTROL PENUH)                 ║
║  ┌──────────────────────────────────────────────────────┐               ║
║  │                   ADMIN_DESA                          │               ║
║  │  • id_admin (PK)  • nama  • email  • password  • role │               ║
║  └──────────────────────────────────────────────────────┘               ║
║       ↓ mengelola ↓ mengelola ↓ mengelola ↓ mengelola ↓ mengelola      ║
║    (0,N)→(1,1)  (0,N)→(1,1)  (0,N)→(1,1)  (0,N)→(1,1)  (0,N)→(1,1)   ║
║       ↓              ↓              ↓              ↓              ↓      ║
║                                                                           ║
║  LAYER 2: DATA GEOGRAFIS & DEMOGRAFI (Inti Data - Dikelola Admin)       ║
║  ┌─────────────────────────────────────────────────────────────────────┐ ║
║  │      BERITA                      DUSUN                               │ ║
║  │  • id_berita (PK)           • id_dusun (PK)                         │ ║
║  │  • judul, isi, kategori     • nama_dusun (UK)                      │ ║
║  │  • tanggal_publikasi        • kepala_dusun                         │ ║
║  │  • id_admin (FK)            • rt, rw, total_warga                  │ ║
║  └─────────────────────────────────────────────────────────────────────┘ ║
║                                 ↓ memiliki (1,N)→(1,1)                   ║
║                                 ↓                                        ║
║  ┌──────────────────────────────────────────────────────┐               ║
║  │      ↑ mengelola (0,N)→(1,1)                         │               ║
║  │                   KELUARGA                           │               ║
║  │ • id_keluarga (PK)  • no_kk (UK)  • kepala_keluarga │               ║
║  │ • nik_kepala  • rt • rw  • alamat  • kode_pos      │               ║
║  │ • jumlah_anggota  • id_dusun (FK)                  │               ║
║  └──────────────────────────────────────────────────────┘               ║
║                    ↓ beranggotakan (1,N)→(0,1)                          ║
║                    ↓                                                    ║
║  ┌──────────────────────────────────────────────────────┐               ║
║  │      ↑ mengelola (0,N)→(1,1)                         │               ║
║  │                   PENDUDUK                           │               ║
║  │ • id_penduduk (PK)  • nik (UK)  • nama              │               ║
║  │ • jenis_kelamin  • tanggal_lahir  • tempat_lahir   │               ║
║  │ • alamat  • agama  • status_pernikahan  • pekerjaan │               ║
║  │ • no_hp  • status  • email  • password  • role     │               ║
║  │ • is_approved  • id_keluarga (FK)                  │               ║
║  └──────────────────────────────────────────────────────┘               ║
║         ↓ membuat          ↓ untuk              ↓ mengajukan            ║
║      (0,N)→(1,1)      (0,N)→(1,1)           (0,N)→(1,1)                 ║
║         ↓                 ↓                      ↓                       ║
║                                                                           ║
║  LAYER 3: DOKUMEN & LAYANAN (Output/Hasil)                              ║
║  ┌─────────────────────────────────┐  ┌─────────────────────────────────┐║
║  │        SURAT                    │  │    PERMOHONAN_SURAT             ││
║  │ • id_surat (PK)                 │  │      ↑ memverifikasi            ││
║  │ • nomor_surat (UK)              │  │      (0,N)→(1,1)                ││
║  │ • jenis_surat                   │  │ • id_permohonan (PK)            ││
║  │ • keperluan  • tanggal_surat    │  │ • kode_pengajuan (UK)           ││
║  │ • status  • data_tambahan       │  │ • nama_pemohon                  ││
║  │ • nama_kepala_desa              │  │ • nik_pemohon                   ││
║  │ • id_penduduk (FK)              │  │ • jenis_surat  • keterangan     ││
║  │ • id_penduduk_pembuat (FK)      │  │ • status  • tanggal             ││
║  └─────────────────────────────────┘  │ • id_penduduk (FK)              ││
║         ↑                              │ • id_surat (FK) ◄──────┐        ││
║         │                              │ • id_admin (FK)        │        ││
║         │                              └────────────────────────┼────────┘║
║         │        menghasilkan (0,1)→(0,1)                      │         ║
║         └────────────────────────────────────────────────────────┘       ║
║                                                                           ║
╚═══════════════════════════════════════════════════════════════════════════╝
```

---

## 🎯 PENJELASAN STRUKTUR LAYER

### **LAYER 1: ADMIN_DESA** ⭐
**Fungsi:** Puncak hirarki sistem, KONTROL PENUH
- Mengelola konten (BERITA)
- **Mengelola data geografis (DUSUN)**
- **Mengelola data keluarga (KELUARGA)**
- **Mengelola data penduduk (PENDUDUK)**
- **Memverifikasi permintaan surat (PERMOHONAN_SURAT)**

**Relasi:**
- 1 Admin bisa mengelola **N** Berita (0,N)→(1,1)
- **1 Admin bisa mengelola N DUSUN (0,N)→(1,1)** ⭐ BARU
- **1 Admin bisa mengelola N KELUARGA (0,N)→(1,1)** ⭐ BARU
- **1 Admin bisa mengelola N PENDUDUK (0,N)→(1,1)** ⭐ BARU
- **1 Admin bisa verifikasi N PERMOHONAN_SURAT (0,N)→(1,1)** ⭐ BARU

---

### **LAYER 2: DATA GEOGRAFIS & DEMOGRAFI** 📍
**Fungsi:** Inti data kependudukan desa + Konten

**Entitas:**
- **BERITA:** Artikel desa, pengumuman, informasi
- **DUSUN → KELUARGA → PENDUDUK:** Hirarki geografis dan data individu

**Hirarki Geografis:**
```
DUSUN (Wilayah dusun)
  ├─ Kepala dusun
  ├─ RT/RW
  └─ Total warga
      │
      └─→ KELUARGA (Kartu Keluarga)
          ├─ No KK
          ├─ Kepala keluarga
          ├─ RT/RW
          └─ Jumlah anggota
              │
              └─→ PENDUDUK (Data individu)
                  ├─ NIK
                  ├─ Nama
                  ├─ Jenis kelamin
                  ├─ Tanggal & tempat lahir
                  ├─ Agama
                  ├─ Status pernikahan
                  ├─ Pekerjaan
                  └─ Status (aktif/pindah/meninggal)
```

**Relasi:**
- 1 Dusun memiliki **N** Keluarga (1,N)→(1,1)
- 1 Keluarga memiliki **N** Penduduk (1,N)→(0,1)

**Catatan:** PENDUDUK sekarang mengintegrasikan fungsi login (dengan email, password, role) jika diperlukan, tanpa perlu tabel PENGGUNA terpisah.

### **LAYER 3: SURAT & PERMOHONAN_SURAT** 📄
**Fungsi:** Output sistem, dokumen & layanan

- **SURAT:** Surat yang sudah diterbitkan → siap cetak/pakai
- **PERMOHONAN_SURAT:** Pengajuan surat online → verifikasi admin → siap proses

**Alur:**
```
PENDUDUK mengajukan Permohonan
    ↓
PERMOHONAN_SURAT dibuat (status: baru)
    ↓
ADMIN_DESA memverifikasi Permohonan
    ├─ Setuju → menghasilkan SURAT (siap cetak)
    └─ Tolak → status ditolak
```

**Relasi:**
- **1 Penduduk (role: admin/user_surat) bisa membuat N Surat (0,N)→(1,1)**
- 1 Penduduk bisa untuk **N** Surat (0,N)→(1,1)
- 1 Penduduk bisa mengajukan **N** Permohonan (0,N)→(1,1)
- **1 Admin bisa verifikasi N Permohonan (0,N)→(1,1)** ⭐ BARU
- 1 Permohonan bisa menghasilkan max 1 Surat (0,1)→(0,1)

---

## 📊 POSISI ENTITAS DI ERDPLUS

Untuk layout yang optimal, atur posisi seperti ini (dalam pixel):

| Entitas | X Position | Y Position | Width | Height |
|---------|-----------|----------|-------|--------|
| ADMIN_DESA | 400 | 50 | 250 | 100 |
| BERITA | 100 | 250 | 200 | 100 |
| DUSUN | 400 | 250 | 250 | 100 |
| KELUARGA | 400 | 450 | 250 | 120 |
| PENDUDUK | 400 | 650 | 300 | 150 |
| SURAT | 200 | 900 | 250 | 140 |
| PERMOHONAN_SURAT | 700 | 900 | 250 | 140 |

**Tips:** Gunakan "Auto Layout → Hierarchical" di ERDPlus untuk auto-arrange!

---

## ✅ KEUNTUNGAN LAYOUT LAYER (3-LAYER SIMPLIFIED)

| Aspek | Manfaat |
|-------|----------|
| **Visualisasi** | Hirarki jelas: Admin → Data → Dokumen (dari 4-layer) |
| **Simplifikasi** | Hapus duplikasi PENGGUNA, langsung ke PENDUDUK dengan role |
| **Relasi** | 10 relasi (dari 13), lebih fokus pada data core |
| **Pemahaman** | Lebih mudah: Admin mengelola SEMUA data master |
| **Dokumentasi** | Terstruktur top-down, lebih compact |
| **Scalability** | Mudah tambah entitas baru di layer yang sesuai |
| **Maintenance** | Jelas mana bagian apa (admin/data/output) |

---

## 🔍 PERBANDINGAN: LAYOUT LAMA vs BARU

### Layout Lama (4-Layer dengan PENGGUNA - ❌ Redundan)
- Ada duplikasi: PENGGUNA (login) + PENDUDUK (data) terpisah
- Relasi lebih kompleks (13 relasi)
- Layer 2 hanya untuk interface
- Sulit maintain consistency data

### Layout Baru (3-Layer Simplified - ✅ Efisien)
- Satu entitas PENDUDUK untuk data + login (dengan role/email/password opsional)
- Relasi lebih fokus (10 relasi, hapus 3 PENGGUNA-related)
- Admin mengelola SEMUA data master langsung
- Lebih scalable & mudah dipahami
- Total entitas: 7 (dari 8)

---

## 📝 CHECKLIST IMPLEMENTASI DI ERDPLUS

- [ ] Buat 7 entitas dengan atribut lengkap
- [ ] Atur posisi per layer (gunakan Auto Layout → Hierarchical)
- [ ] Buat 10 relasi dengan kardinalitas benar
- [ ] Cek: Tidak ada garis crossing berlebihan
- [ ] Verify: PENGGUNA sudah dihapus, PENDUDUK terintegrasi login fields
- [ ] Download image hasil ERD
- [ ] Verify: Gambar sesuai struktur 3-layer

Selamat membuat ERD yang lebih efisien! 🎨
