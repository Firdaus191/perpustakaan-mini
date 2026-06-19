# 📚 Perpustakaan Mini - Sistem Manajemen Perpustakaan

<div align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/Vite-B73BFE?style=for-the-badge&logo=vite&logoColor=FFD62E" alt="Vite" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
</div>

<br>

**Perpustakaan Mini** adalah aplikasi berbasis web modern yang dirancang untuk mempermudah pengelolaan perpustakaan berskala kecil hingga menengah. Mengusung antarmuka yang bersih dan intuitif, sistem ini memfasilitasi administrasi buku, manajemen anggota, hingga pelacakan siklus sirkulasi (peminjaman dan pengembalian) secara efisien, transparan, dan terotomatisasi.

Dibangun di atas ekosistem Laravel yang tangguh, sistem ini menawarkan performa tinggi, keamanan yang solid, serta kemudahan untuk skalabilitas di masa depan.

---

## 📑 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Akun Demo](#-akun-demo)
- [Panduan Instalasi](#-panduan-instalasi)
- [Tips & Catatan Pengembangan](#-tips--catatan-pengembangan)

---

## ✨ Fitur Utama

Sistem ini membagi fungsionalitasnya berdasarkan hak akses pengguna (Role) untuk menjaga keamanan dan privasi data.

### 🛡️ Administrator (Admin)

Memiliki akses penuh ke seluruh pengelolaan sistem, master data, dan sirkulasi.

| ID        | Fitur                   | Deskripsi                                                                          |
| --------- | ----------------------- | ---------------------------------------------------------------------------------- |
| **AD-01** | **Dashboard Analitik**  | Menampilkan ringkasan statistik dan aktivitas perpustakaan.                        |
| **AD-02** | **Manajemen Kategori**  | Menambah, mengedit, dan menghapus kategori buku.                                   |
| **AD-03** | **Manajemen Buku**      | Mengelola katalog buku perpustakaan secara lengkap.                                |
| **AD-04** | **Manajemen Anggota**   | Mengelola data anggota perpustakaan yang terdaftar.                                |
| **AD-05** | **Kelola Peminjaman**   | Validasi _booking_ peminjaman, perpanjangan waktu, dan manajemen sirkulasi keluar. |
| **AD-06** | **Kelola Pengembalian** | Memproses pengembalian buku dan melacak status keterlambatan (jika ada).           |

### 👤 Pengguna (User / Anggota)

Memiliki akses untuk melakukan peminjaman mandiri dan melacak aktivitas mereka.

| ID        | Fitur                 | Deskripsi                                                               |
| --------- | --------------------- | ----------------------------------------------------------------------- |
| **US-01** | **Dashboard Anggota** | Tampilan ringkasan aktivitas dan status akun bagi pengguna.             |
| **US-02** | **Eksplorasi Buku**   | Melihat dan mencari daftar koleksi buku perpustakaan.                   |
| **US-03** | **Peminjaman Buku**   | Melakukan permintaan atau _booking_ pinjaman buku secara online.        |
| **US-04** | **Pengembalian Buku** | Memproses permintaan pengembalian buku ke sistem.                       |
| **US-05** | **Riwayat Transaksi** | Melihat catatan historis seluruh aktivitas peminjaman dan pengembalian. |
| **US-06** | **Manajemen Profil**  | Memperbarui profil personal dan kredensial akun.                        |

---

## 🛠️ Tech Stack

Aplikasi ini dikembangkan menggunakan teknologi standar industri web modern:

- **Backend:** Laravel (PHP 8.3+)
- **Frontend:** Blade Templates, Tailwind CSS v4, Vite
- **Database:** MySQL / SQLite
- **Authentication:** Laravel Auth Middleware terintegrasi
- **Styling & Assets:** Vite Asset Bundler

---

## 🔑 Akun Demo

Anda dapat menggunakan akun berikut untuk mengeksplorasi sistem:

| Role      | Email              | Password   | Deskripsi                                                             |
| :-------- | :----------------- | :--------- | :-------------------------------------------------------------------- |
| **Admin** | `admin@perpus.com` | `password` | Memiliki akses penuh ke seluruh modul konfigurasi dan transaksi.      |
| **User**  | `user@perpus.com`  | `password` | Akun anggota (ANG-001) untuk mencoba simulasi peminjaman dan riwayat. |

---

## 🚀 Panduan Instalasi

Ikuti langkah-langkah teknis di bawah ini untuk menjalankan aplikasi di lingkungan lokal Anda. Pastikan **PHP >= 8.3**, **Composer**, dan **Node.js** sudah terinstal.

### 1. Clone Repository & Masuk ke Direktori

```bash
git clone <url-repo-anda> perpustakaan-mini
cd perpustakaan-mini
```

### 2. Instalasi Dependensi PHP (Composer)

```bash
composer install
```

### 3. Instalasi Dependensi Frontend (NPM)

```bash
npm install
```

### 4. Konfigurasi Environment (`.env`)

Salin file konfigurasi _environment_ bawaan (sesuaikan dengan sistem operasi Anda):

```bash
# Untuk Windows (Command Prompt / PowerShell)
copy .env.example .env

# Untuk Mac/Linux
cp .env.example .env
```

_Catatan: Aplikasi ini menggunakan **SQLite** (`DB_CONNECTION=sqlite`) secara default. Anda **tidak perlu** repot mengatur MySQL/XAMPP. Database akan dibuat secara otomatis di langkah ke-6!_

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Migrasi Database & Seeding

Jalankan perintah ini untuk membuat struktur database beserta _dummy data_ (Akun Demo, Kategori, Buku):

```bash
php artisan migrate --seed
```

*(💡 Jika muncul *prompt* "Database does not exist. Would you like to create it?", ketik `yes` lalu tekan Enter).*

### 7. Build Asset Frontend (Vite)

Jalankan proses _build_ Vite agar _styling_ Tailwind CSS dapat dimuat:

```bash
npm run build
```

### 8. Jalankan Local Development Server

```bash
php artisan serve
```

Aplikasi kini dapat diakses melalui browser pada URL: **`http://127.0.0.1:8000`**

---

## 💡 Tips & Catatan Pengembangan

- **Hot Reloading:** Saat Anda melakukan modifikasi di file Blade (`.blade.php`), CSS, atau JS, buka terminal baru dan jalankan `npm run dev` agar _browser_ merender perubahan secara _real-time_ tanpa _refresh_ manual.
- **Concurrent Scripts:** Jika Anda ingin menjalankan server dan Vite secara bersamaan dalam satu perintah, Anda dapat menjalankan `composer run dev` jika _script_ telah dikonfigurasi (lihat `composer.json` > `"scripts"`).
- **Storage Link:** Jika proyek menggunakan upload file/gambar (misalnya _cover_ buku), pastikan Anda menjalankan `php artisan storage:link` agar file dapat diakses publik.

---

_Dibuat dengan ❤️ oleh Tino dkk._
