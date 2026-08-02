# Sistem Informasi Manajemen Perpustakaan Digital (Laravel 13 + Livewire 3)

Aplikasi manajemen perpustakaan modern, bilingual (Bahasa Indonesia & English), dan siap pakai yang dibangun dengan arsitektur **Repository Pattern** dan **Action Class**.

---

## 🚀 Fitur Utama

- 📊 **Dashboard Interaktif**: Ringkasan total judul buku, anggota aktif, transaksi peminjaman aktif, peminjaman terlambat, serta daftar buku populer.
- 📚 **Katalog & Stok Buku**: Pencarian instan (live search), filter kategori, manajemen stok otomatis (tersedia vs dipinjam), dan lokasi rak.
- 👥 **Manajemen Anggota**: Pengelolaan profil anggota (Siswa, Guru, Umum), nomor anggota otomatis, dan riwayat peminjaman.
- 🔄 **Sirkulasi Peminjaman & Pengembalian**:
  - Transaksi peminjaman cepat dengan validasi limit stok dan batas pinjam per anggota.
  - Pengembalian buku dengan **kalkulasi denda otomatis** jika lewat tanggal jatuh tempo.
- ⚠️ **Sistem Peringatan Terlambat (Overdue Alerts)**: Daftar peminjaman terlambat beserta jumlah hari keterlambatan, kontak anggota, dan badge counter di sidebar.
- 🌐 **Lokalisasi Dwibahasa (Bilingual)**: Dukungan Bahasa Indonesia dan English yang disimpan via session.

---

## 🛠️ Prasyarat (Requirements)

- PHP >= 8.2 (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`)
- Composer >= 2.x
- Node.js >= 18.x & NPM
- MySQL / MariaDB (misalnya via Laragon / XAMPP)

---

## 💻 Panduan Instalasi (Quick Start)

### 1. Clone Repository & Install Dependencies
```bash
# Inisialisasi atau clone folder proyek
cd c:/laragon/www/library

# Install dependensi PHP
composer install

# Install dependensi JavaScript/CSS
npm install
```

### 2. Setup File Konfigurasi Environment (`.env`)
Salin file `.env.example` ke `.env` dan atur koneksi database:
```ini
APP_NAME="LibSys"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library
DB_USERNAME=root
DB_PASSWORD=
```

Generate App Key:
```bash
php artisan key:generate
```

### 3. Migrasi Database & Seeding Data Dummy
Jalankan migrasi database beserta seeder data awal (30 buku, 15 anggota, dan sampel transaksi):
```bash
php artisan migrate:fresh --seed
```

### 4. Menjalankan Server Lokal & Vite
Jalankan dev server Laravel:
```bash
php artisan serve
```

Di terminal terpisah, jalankan Vite frontend bundler:
```bash
npm run dev
```

Akses aplikasi di browser pada: **http://localhost:8000** atau **http://library.test** (Laragon).

---

## 🔑 Kredensial Login Bawaan (Default Staff Accounts)

| Peran | Email | Password |
|---|---|---|
| **Administrator** | `admin@library.com` | `password` |
| **Pustakawan (Librarian)** | `librarian@library.com` | `password` |

---

## 🧪 Menjalankan Automated Tests

Aplikasi dilengkapi dengan pengujian otomatis menggunakan **Pest**:
```bash
php vendor/bin/pest tests/Feature/BorrowBookActionTest.php tests/Feature/ReturnBookActionTest.php tests/Feature/GetOverdueLoansActionTest.php
```

---

## 📐 Penjelasan Arsitektur Kode

Untuk mempelajari lebih lanjut mengenai pola arsitektur **Repository Pattern** & **Action Class** yang diterapkan di proyek ini, silakan baca dokumentasi [ARCHITECTURE.md](ARCHITECTURE.md).
