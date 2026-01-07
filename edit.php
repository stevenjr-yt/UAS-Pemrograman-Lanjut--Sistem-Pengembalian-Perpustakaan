<?php
session_start();
include 'koneksi.php';

// Proteksi Admin
if(!isset($_SESSION['login']) || $_SESSION['level'] != 'admin'){
    header('location:tampil.php');
    exit;
}

// Ambil ID dari URL
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id='$id'");
$d = mysqli_fetch_array($data);

// Proses Update
if(isset($_POST['update'])){
    $nama = $_POST['nama_peminjam'];
    $judul = $_POST['judul_buku'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];

    // Logic: Jika tgl_kembali di form kosong, set NULL di database
    if(empty($tgl_kembali)){
        $query = "UPDATE peminjaman SET nama_peminjam='$nama', judul_buku='$judul', tgl_pinjam='$tgl_pinjam', tgl_kembali=NULL WHERE id='$id'";
    } else {
        $query = "UPDATE peminjaman SET nama_peminjam='$nama', judul_buku='$judul', tgl_pinjam='$tgl_pinjam', tgl_kembali='$tgl_kembali' WHERE id='$id'";
    }
    
    if(mysqli_query($koneksi, $query)){
        echo "<script>alert('Data Berhasil Diupdate!'); window.location='tampil.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data - Admin</title>
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
            <a class="navbar-brand fw-bold" href="index.php">Admin Panel</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <a href="tampil.php" class="text-decoration-none text-muted mb-3 d-inline-block">&larr; Batal Edit</a>
                
                <div class="card card-custom">
                    <div class="card-header bg-white pt-4 pb-0 border-0">
                        <h4 class="fw-bold" style="color: #003399;">Edit Data Peminjaman</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Peminjam</label>
                                <input type="text" name="nama_peminjam" class="form-control" value="<?= $d['nama_peminjam']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Buku</label>
                                <input type="text" name="judul_buku" class="form-control" value="<?= $d['judul_buku']; ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Pinjam</label>
                                    <input type="date" name="tgl_pinjam" class="form-control" value="<?= $d['tgl_pinjam']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Kembali</label>
                                    <input type="date" name="tgl_kembali" class="form-control" value="<?= $d['tgl_kembali']; ?>">
                                    <small class="text-muted" style="font-size: 10px;">*Kosongkan jika belum kembali</small>
                                </div>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary-dj w-100 py-2 fw-bold">UPDATE DATA</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>