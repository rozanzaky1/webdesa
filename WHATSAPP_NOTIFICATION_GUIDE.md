# Setup Notifikasi WhatsApp

Sistem ini menggunakan WhatsApp untuk mengirim notifikasi kepada user ketika:
1. **Akun disetujui** oleh admin
2. **Surat selesai** dan siap diambil

## Cara Setup

### 1. Daftar di Fonnte (WhatsApp Gateway)

1. Buka https://fonnte.com
2. Klik **Daftar** / **Register**
3. Verifikasi email Anda
4. Login ke dashboard Fonnte
5. Hubungkan nomor WhatsApp Anda dengan scan QR Code
6. Copy **API Key** Anda dari dashboard

### 2. Tambahkan API Key ke .env

Tambahkan baris ini di file `.env`:

```env
# WhatsApp API Configuration (Fonnte)
WHATSAPP_API_URL=https://api.fonnte.com/send
WHATSAPP_API_KEY=your_api_key_here
```

Ganti `your_api_key_here` dengan API Key yang Anda copy dari Fonnte.

### 3. Pastikan User Punya Nomor Telepon

Nomor telepon user harus diisi di field `phone` pada tabel `users`.

Format nomor telepon yang didukung:
- `08123456789` (akan otomatis dikonversi ke `628123456789`)
- `628123456789` (format WhatsApp)
- `+628123456789` (akan otomatis dikonversi ke `628123456789`)

### 4. Test Notifikasi

#### Test Notifikasi Akun Disetujui:
1. Daftar akun baru di website (menu Register)
2. Login sebagai admin
3. Buka menu **Verifikasi User**
4. Klik tombol **Setujui** pada user yang baru daftar
5. User akan menerima notifikasi WhatsApp

#### Test Notifikasi Surat Selesai:
1. User ajukan surat via menu **Layanan Online**
2. Login sebagai admin
3. Buka menu **Pengajuan Surat Online**
4. Ubah status menjadi **Completed** (Selesai)
5. User akan menerima notifikasi WhatsApp

## Format Pesan WhatsApp

### Akun Disetujui
```
🎉 *Akun Diverifikasi - Kampung Badran Sari*

Halo *[Nama User]*,

Selamat! Akun Anda telah diverifikasi oleh administrator.

Anda sekarang dapat mengakses semua layanan yang tersedia di Sistem Informasi Kampung Badran Sari.

📌 *Login di:* https://badransari.web.id/login

Silakan login dengan email dan password yang Anda daftarkan.

Terima kasih telah bergabung dengan kami!

---
Salam,
Tim Kampung Badran Sari
```

### Surat Selesai
```
✅ *Surat Selesai - Kampung Badran Sari*

Halo *[Nama User]*,

Surat Anda telah selesai diproses!

📋 *Jenis Surat:* Surat Keterangan Domisili
📄 *Nomor Surat:* 001/SKD/BS/II/2026

Silakan login ke sistem untuk melihat dan mengunduh surat Anda.

🔗 *Login di:* https://badransari.web.id/login

Terima kasih telah menggunakan layanan kami.

---
Salam,
Tim Kampung Badran Sari
```

## Troubleshooting

### Notifikasi Tidak Terkirim

1. **Cek API Key**
   - Pastikan `WHATSAPP_API_KEY` di `.env` sudah benar
   - Login ke Fonnte dan cek apakah API Key masih aktif

2. **Cek Nomor WhatsApp di Fonnte**
   - Pastikan nomor WhatsApp di Fonnte masih terhubung
   - Scan ulang QR Code jika perlu

3. **Cek Format Nomor User**
   - Pastikan nomor user ada dan formatnya benar
   - Format: `08xxx` atau `628xxx`

4. **Cek Log Error**
   - Lihat file `storage/logs/laravel.log`
   - Cari error dengan keyword "WhatsApp"

5. **Cek Saldo/Kuota Fonnte**
   - Beberapa layanan WhatsApp Gateway memerlukan saldo
   - Login ke Fonnte dan cek saldo Anda

### Alternatif WhatsApp Gateway

Jika tidak menggunakan Fonnte, Anda bisa menggunakan gateway lain seperti:
- **Wablas** (https://wablas.com)
- **Woowa** (https://woowa.id)
- **Qontak** (https://qontak.com)

Tinggal sesuaikan API URL dan format request di file:
`app/Services/WhatsAppService.php`

## Biaya

- **Fonnte**: Mulai dari Rp 150.000/bulan untuk unlimited pesan
- **Gratis Trial**: Biasanya ada free trial 100-500 pesan

## Support

Untuk bantuan lebih lanjut:
- Email: support@badransari.kampung.id
- WhatsApp: +62 858-3268-2557
