<?php
session_start();
include 'koneksi.php';

// Cek Login Admin
if(!isset($_SESSION['login']) || $_SESSION['level'] != 'admin'){
    header('location:tampil.php');
    exit;
}

if(isset($_POST['simpan'])){
    $nama = $_POST['nama_peminjam'];
    $judul = $_POST['judul_buku'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    
    // tgl_kembali di-set NULL (karena baru minjam)
    $query = "INSERT INTO peminjaman (nama_peminjam, judul_buku, tgl_pinjam, tgl_kembali) 
              VALUES ('$nama', '$judul', '$tgl_pinjam', NULL)";
    
    if(mysqli_query($koneksi, $query)){
        echo "<script>alert('Data Peminjaman Berhasil Disimpan!'); window.location='tampil.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Peminjaman Baru</title>
    <link rel="icon" href="favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; }
        .navbar-dj { background: linear-gradient(90deg, #003399 0%, #0044cc 100%); }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        .btn-primary-dj { background-color: #003399; border: none; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dj navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="favicon.png" width="30" class="d-inline-block align-text-top me-2 bg-white rounded p-1">
                Admin Panel
            </a>
            <div class="d-flex">
                <a href="tampil.php" class="btn btn-outline-light btn-sm me-2">Lihat Data</a>
                <a href="logout.php" class="btn btn-warning btn-sm fw-bold">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-header bg-white pt-4 pb-0 border-0">
                        <h4 class="fw-bold" style="color: #003399;">+ Form Peminjaman</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Peminjam</label>
                                <input type="text" name="nama_peminjam" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Buku</label>
                                <input type="text" name="judul_buku" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Tanggal Pinjam</label>
                                <input type="date" name="tgl_pinjam" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                                <small class="text-muted">*Batas waktu peminjaman adalah 7 hari.</small>
                            </div>
                            <button type="submit" name="simpan" class="btn btn-primary-dj w-100 py-2 fw-bold">PROSES PINJAM</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>