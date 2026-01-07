<div align="center">

  <img src="logodarmajaya.png" alt="Logo Project" width="100">

  # SIA Perpustakaan (Sistem Informasi Peminjaman)
  
  **UAS Pemrograman Lanjut - Tahun Ajaran 2025/2026**
  
  ![PHP](https://img.shields.io/badge/Language-PHP_Native-blue?style=for-the-badge&logo=php)
  ![MySQL](https://img.shields.io/badge/Database-MySQL-orange?style=for-the-badge&logo=mysql)
  ![Bootstrap](https://img.shields.io/badge/Design-Bootstrap_5-purple?style=for-the-badge&logo=bootstrap)
  ![Status](https://img.shields.io/badge/Status-Completed-success?style=for-the-badge)

  <p align="center">
    Aplikasi manajemen perpustakaan sederhana namun powerful dengan fitur perhitungan denda otomatis, dashboard statistik, dan pemisahan hak akses (Admin & Mahasiswa).
  </p>

</div>

---

## 📸 Preview Aplikasi

Berikut adalah tampilan antarmuka dari aplikasi ini:

| **Intro / Landing Page** | **Login Page** |
|:---:|:---:|
| <img src="screenshot_intro.png" width="100%" alt="Intro Page"> | <img src="screenshot_login.png" width="100%" alt="Login Page"> |
| *Tampilan awal dengan efek animasi Wave* | *Halaman Login Modern* |

| **Dashboard Admin** | **Data Peminjaman & Denda** |
|:---:|:---:|
| <img src="screenshot_dashboard.png" width="100%" alt="Dashboard"> | <img src="screenshot_tabel.png" width="100%" alt="Tabel Data"> |
| *Statistik Peminjaman Real-time* | *Tabel dengan Indikator Denda Otomatis* |

> *Catatan: Ganti `screenshot_intro.png`, dll dengan nama file gambar yang kamu upload.*

---

## 🔥 Fitur Unggulan

Aplikasi ini dibangun dengan logika yang memisahkan proses peminjaman dan pengembalian untuk akurasi data.

### 1. 👨‍💻 Admin Panel (Full Access)
* **Dashboard Statistik:** Menampilkan grafik batang (Chart.js), jumlah buku dipinjam, buku kembali, dan total nominal denda yang masuk.
* **Input Peminjaman:** Form input yang hanya mencatat Tanggal Pinjam (Tanggal Kembali default `NULL`).
* **Manajemen Pengembalian:** Tombol "Kembalikan" yang mencatat tanggal *real-time* hari ini.
* **Auto-Calculate Denda:** Sistem otomatis menghitung denda jika durasi pinjam > 7 hari.
    * *Rumus:* `(Total Hari - 7) x Rp 2.500`.
* **CRUD Data:** Edit dan Hapus data peminjaman jika terjadi kesalahan input.

### 2. 🎓 Student Access (Mahasiswa)
* **Search Engine:** Mahasiswa tidak bisa melihat semua data. Wajib memasukkan **Nama** dan **Judul Buku** untuk privasi.
* **Status Checker:** Melihat apakah buku sudah dikembalikan atau belum.
* **Fine Info:** Menampilkan nominal denda jika terlambat mengembalikan buku.

### 3. 🎨 UI/UX Modern
* **Responsive Design:** Menggunakan Bootstrap 5 yang rapi di HP maupun Laptop.
* **Intro Animation:** Tampilan pembuka ala *Linktree* dengan efek transisi *wave*.
* **Informative Badges:** Warna status yang berbeda (Kuning: Pinjam, Hijau: Aman, Merah: Denda).

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP Native (Procedural Style).
* **Frontend:** HTML5, CSS3, Bootstrap 5.3.
* **Database:** MySQL / MariaDB.
* **Visualisasi:** Chart.js (Grafik Statistik).
* **Font:** Poppins (Google Fonts).

---

## 💾 Database Schema (SQL)

Silakan import query berikut ke phpMyAdmin untuk membuat database dan tabel yang dibutuhkan.

```sql
-- 1. Buat Database
CREATE DATABASE uas_darmajaya;
USE uas_darmajaya;

-- 2. Buat Tabel User (Login)
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(50),
    password VARCHAR(50),
    level VARCHAR(20) -- 'admin' atau 'pengguna'
);

-- 3. Isi Data User (Default)
INSERT INTO user (nama, username, password, level) VALUES 
('Administrator', 'admin', 'darmajaya', 'admin'),
('Mahasiswa', 'user', '12345', 'pengguna');

-- 4. Buat Tabel Peminjaman
CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_peminjam VARCHAR(100) NOT NULL,
    judul_buku VARCHAR(200) NOT NULL,
    tgl_pinjam DATE NOT NULL,
    tgl_kembali DATE NULL -- Boleh Kosong (NULL) saat baru pinjam
);

-- 5. Contoh Data Dummy
INSERT INTO peminjaman (nama_peminjam, judul_buku, tgl_pinjam, tgl_kembali) VALUES 
('Andi Santoso', 'Pemrograman PHP', '2024-12-10', '2024-12-18'), -- Telat
('Budi Hartono', 'MySQL untuk Pemula', '2024-12-15', '2024-12-22'), -- Aman
('Citra Maharani', 'Pengantar Database', '2025-01-01', NULL); -- Sedang Pinjam
