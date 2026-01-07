<?php
session_start();
include 'koneksi.php';

// Cek Login
if(!isset($_SESSION['login'])){
    header('location:login.php');
    exit;
}

// LOGIKA PENGALIHAN:
// Jika yang login BUKAN Admin (Mahasiswa), langsung lempar ke halaman cari data.
if($_SESSION['level'] != 'admin'){
    header('location:tampil.php');
    exit;
}

// --- HITUNG STATISTIK (Query Database) ---

// 1. Hitung Buku Sedang Dipinjam (tgl_kembali NULL)
$q_pinjam = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peminjaman WHERE tgl_kembali IS NULL");
$d_pinjam = mysqli_fetch_assoc($q_pinjam);
$jml_pinjam = $d_pinjam['total'];

// 2. Hitung Buku Sudah Kembali (tgl_kembali Ada Isinya)
$q_kembali = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peminjaman WHERE tgl_kembali IS NOT NULL");
$d_kembali = mysqli_fetch_assoc($q_kembali);
$jml_kembali = $d_kembali['total'];

// 3. Hitung Total Denda (Pake Rumus SQL biar cepat)
// Rumus: Jika selisih hari > 7, maka (Selisih - 7) * 2500. Jika tidak, 0.
$q_denda = mysqli_query($koneksi, "
    SELECT SUM(
        CASE 
            WHEN DATEDIFF(tgl_kembali, tgl_pinjam) > 7 
            THEN (DATEDIFF(tgl_kembali, tgl_pinjam) - 7) * 2500 
            ELSE 0 
        END
    ) as total_rupiah 
    FROM peminjaman 
    WHERE tgl_kembali IS NOT NULL
");
$d_denda = mysqli_fetch_assoc($q_denda);
$total_denda = $d_denda['total_rupiah']; // Hasil Rupiah
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - SIA Perpus</title>
    <link rel="icon" href="logodarmajaya.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; }
        .navbar-dj { background: linear-gradient(90deg, #003399 0%, #0044cc 100%); }
        .card-stat { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s; }
        .card-stat:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .icon-box { font-size: 2.5rem; opacity: 0.3; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dj navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src=".png" width="30" class="d-inline-block align-text-top me-2 bg-white rounded p-1">
                Admin Dashboard
            </a>
            <div class="d-flex">
                <a href="input.php" class="btn btn-outline-light btn-sm me-2">+ Input Peminjaman</a>
                <a href="tampil.php" class="btn btn-outline-light btn-sm me-2">Lihat Data</a>
                <a href="logout.php" class="btn btn-light btn-sm fw-bold">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h3 class="fw-bold text-secondary mb-4">Ringkasan Perpustakaan</h3>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card card-stat bg-warning bg-opacity-10 border-warning border-start border-5">
                    <div class="card-body d-flex justify-content-between align-items-center p-4">
                        <div>
                            <h6 class="text-uppercase text-muted fw-bold mb-1">Sedang Dipinjam</h6>
                            <h2 class="mb-0 fw-bold text-warning"><?= $jml_pinjam; ?> Buku</h2>
                        </div>
                        <div class="icon-box text-warning">
                            <i class="fas fa-book-reader"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-stat bg-success bg-opacity-10 border-success border-start border-5">
                    <div class="card-body d-flex justify-content-between align-items-center p-4">
                        <div>
                            <h6 class="text-uppercase text-muted fw-bold mb-1">Sudah Dikembalikan</h6>
                            <h2 class="mb-0 fw-bold text-success"><?= $jml_kembali; ?> Buku</h2>
                        </div>
                        <div class="icon-box text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-stat bg-danger bg-opacity-10 border-danger border-start border-5">
                    <div class="card-body d-flex justify-content-between align-items-center p-4">
                        <div>
                            <h6 class="text-uppercase text-muted fw-bold mb-1">Total Denda Masuk</h6>
                            <h2 class="mb-0 fw-bold text-danger">Rp <?= number_format($total_denda, 0, ',', '.'); ?></h2>
                        </div>
                        <div class="icon-box text-danger">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card card-stat">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold" style="color: #003399;">Statistik Peminjaman</h5>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card card-stat h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold text-secondary">Aksi Cepat</h5>
                    </div>
                    <div class="card-body px-4">
                        <p class="text-muted small">Menu pintasan untuk administrator.</p>
                        <div class="d-grid gap-3">
                            <a href="input.php" class="btn btn-primary py-3 fw-bold" style="background-color: #003399;">
                                <i class="fas fa-plus-circle me-2"></i> Input Peminjaman Baru
                            </a>
                            <a href="tampil.php" class="btn btn-outline-primary py-3 fw-bold">
                                <i class="fas fa-list me-2"></i> Kelola Data & Pengembalian
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar', // Bisa ganti 'pie' atau 'doughnut'
            data: {
                labels: ['Sedang Dipinjam', 'Sudah Dikembalikan'],
                datasets: [{
                    label: 'Jumlah Buku',
                    data: [<?= $jml_pinjam ?>, <?= $jml_kembali ?>],
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.7)', // Kuning (Pinjam)
                        'rgba(25, 135, 84, 0.7)'  // Hijau (Kembali)
                    ],
                    borderColor: [
                        'rgba(255, 193, 7, 1)',
                        'rgba(25, 135, 84, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>