# Instalasi Logo Lampung Tengah

Logo Lampung Tengah telah ditambahkan ke aplikasi web desa di beberapa lokasi:

## Lokasi Logo dalam Aplikasi

1. **Halaman Login** (`resources/views/auth/login.blade.php`)
   - Logo ditampilkan di bagian header login
   
2. **Landing Page** (`resources/views/welcome.blade.php`)
   - Logo ditampilkan di bagian atas halaman

3. **Dashboard Admin - Sidebar** (`resources/views/layouts/sidebar.blade.php`)
   - Logo ditampilkan di bagian brand sidebar

4. **Frontend Navbar** (`resources/views/frontend/layout.blade.php`)
   - Logo ditampilkan di navbar halaman frontend

## Cara Menyimpan Logo

Simpan file logo dengan nama **`logo-lampung-tengah.png`** ke dalam folder:

```
public/images/logo-lampung-tengah.png
```

### Langkah-langkah:

1. Unduh gambar logo Lampung Tengah yang telah disediakan
2. Simpan dengan nama file: `logo-lampung-tengah.png`
3. Letakkan di folder `public/images/`
4. Pastikan format file adalah PNG dengan background transparan untuk hasil terbaik

### Alternatif via Command Line:

Jika Anda memiliki file logo di lokasi lain, gunakan command berikut:

**Windows (PowerShell):**
```powershell
Copy-Item "path\ke\logo-anda.png" "public\images\logo-lampung-tengah.png"
```

**Windows (Command Prompt):**
```cmd
copy "path\ke\logo-anda.png" "public\images\logo-lampung-tengah.png"
```

**Linux/Mac:**
```bash
cp /path/ke/logo-anda.png public/images/logo-lampung-tengah.png
```

## Spesifikasi Logo

- **Nama File:** `logo-lampung-tengah.png`
- **Lokasi:** `public/images/`
- **Format Recommended:** PNG dengan background transparan
- **Ukuran Recommended:** Minimal 200x200 pixels untuk kualitas yang baik

## Verifikasi

Setelah menyimpan logo, buka aplikasi di browser dan periksa:

1. Halaman login: `http://localhost/webdesa/public/login`
2. Landing page: `http://localhost/webdesa/public/`
3. Dashboard admin: Login dan lihat sidebar
4. Frontend: Buka halaman utama website desa

## Troubleshooting

Jika logo tidak muncul:

1. **Periksa nama file** - Harus tepat: `logo-lampung-tengah.png`
2. **Periksa lokasi** - Harus di: `public/images/`
3. **Clear cache browser** - Tekan Ctrl+F5 atau Cmd+Shift+R
4. **Periksa permissions** - File harus readable oleh web server
5. **Periksa format** - Pastikan file adalah gambar valid (PNG/JPG)

## Fallback

Jika logo tidak tersedia, aplikasi akan menampilkan:
- **Login:** Background putih dengan ikon
- **Frontend:** SVG placeholder dengan inisial "DS"
- **Sidebar:** Ikon landmark default

---

**Catatan:** Logo Lampung Tengah adalah simbol resmi Kabupaten Lampung Tengah. Pastikan penggunaan logo sesuai dengan peraturan dan ketentuan yang berlaku.
