# 🍽️ SiCantik - Sistem Informasi Catering

SiCantik (Sistem Informasi Catering) merupakan aplikasi berbasis web yang dirancang untuk membantu pengelolaan layanan catering secara digital. Sistem ini memudahkan pelanggan dalam melihat menu, memberikan ulasan, menghubungi admin, serta membantu pengelola dalam mengelola data menu, pesanan, pembayaran, dan informasi website melalui dashboard admin yang terintegrasi.

---

## ✨ Fitur Utama

### 👨‍💼 Admin
- Mengelola kategori menu catering
- Mengelola data menu catering
- Mengelola data pelanggan
- Mengelola pesanan catering
- Mengelola detail pesanan
- Mengelola pembayaran
- Mengelola ulasan pelanggan
- Mengelola pesan kontak dari pengunjung website
- Mengelola tampilan website secara dinamis

### 👥 Pengunjung Website
- Melihat informasi catering
- Melihat daftar kategori menu
- Melihat menu catering beserta harga
- Mengirim pesan melalui form kontak
- Mengirim ulasan layanan
- Melihat ulasan pelanggan lain
- Mengakses informasi kontak dan media sosial

---

## 🗄️ Struktur Database

Sistem menggunakan 9 tabel utama:

| Tabel | Fungsi |
|---------|---------|
| kategori_menus | Menyimpan kategori menu catering |
| menus | Menyimpan daftar menu catering |
| pelanggans | Menyimpan data pelanggan |
| pesanans | Menyimpan data pesanan |
| detail_pesanans | Menyimpan detail item pesanan |
| pembayarans | Menyimpan data pembayaran |
| ulasans | Menyimpan ulasan pelanggan |
| pesan_kontaks | Menyimpan pesan dari pengunjung |
| pengaturan_websites | Menyimpan konfigurasi website |

---

## 🛠️ Teknologi yang Digunakan

- Laravel
- Blade Template Engine
- Filament Admin Panel
- MariaDB
- Docker
- Nginx
- PHP
- CSS
- JavaScript
- WSL
- Git & GitHub

---

## 🎨 Tampilan Website Dinamis

Seluruh konten website dapat dikelola melalui dashboard admin tanpa perlu mengubah source code secara langsung.

Beberapa bagian yang dapat diubah melalui admin:

- Nama website
- Logo website
- Favicon
- Hero image
- Judul hero
- Deskripsi hero
- Informasi kontak
- Media sosial
- Footer
- Menu catering
- Kategori menu
- Ulasan pelanggan

---

## 📋 Alur Sistem

1. Admin mengelola data menu catering.
2. Pengunjung melihat menu yang tersedia.
3. Pengunjung dapat menghubungi admin melalui form kontak.
4. Pengunjung dapat memberikan ulasan layanan.
5. Data ulasan dan pesan kontak otomatis masuk ke dashboard admin.
6. Admin mengelola pesanan dan pembayaran pelanggan.

---

## 🚀 Instalasi

Clone repository:

```bash
git clone https://github.com/illhammf/sicantik-2026.git
```

Masuk ke folder project:

```bash
cd sicantik-2026
```

Jalankan container:

```bash
dcu
```

Inisialisasi database:

```bash
dci
```

Akses website:

```text
http://sicantik.test
```

Akses admin panel:

```text
http://sicantik.test/admin
```

---

## 👨‍💻 Developer

**Ilham Firmansyah**  
Teknik Informatika - Universitas Esa Unggul

---

## 📄 Lisensi

Project ini dibuat untuk kebutuhan pembelajaran mata kuliah Pemrograman Web Universitas Esa Unggul.