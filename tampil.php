<?php
session_start();
include 'koneksi.php';

// 1. Cek Apakah Sudah Login
if(!isset($_SESSION['login'])){
    header('location:login.php');
    exit;
}

$level = $_SESSION['level']; // Mengambil level user (admin/pengguna)
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Peminjaman - SIA Perpus</title>
    
    <link rel="icon" href="logodarmajaya.png" type="image/png">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f4f6f9; 
        }
        .navbar-dj { 
            background: linear-gradient(90deg, #003399 0%, #0044cc 100%); /* Biru Darmajaya */
        }
        .head-table { 
            background-color: #003399; 
            color: white; 
        }
        .badge-status { font-weight: 500; letter-spacing: 0.5px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dj navbar-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="logodarmajaya.png" width="30" height="30" class="d-inline-block align-text-top me-2 rounded bg-white p-1">
                SIA Perpus
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    <?php if($level == 'admin'){ ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php"><i class="fas fa-chart-line me-1"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="input.php"><i class="fas fa-plus-circle me-1"></i> Pinjam Baru</a>
                        </li>
                    <?php } ?>
                    
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <span class="text-white-50 small me-2 d-none d-lg-inline">Halo, <?= $_SESSION['nama']; ?></span>
                        <a href="logout.php" class="btn btn-light btn-sm fw-bold px-3">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        
        <?php if($level == 'pengguna') { ?>
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3 text-secondary"><i class="fas fa-search me-2"></i>Cari Status Peminjaman</h5>
                    <form method="POST" class="d-flex gap-2 flex-column flex-md-row">
                        <input type="text" name="cari_nama" class="form-control" placeholder="Masukan Nama Peminjam..." required>
                        <input type="text" name="cari_judul" class="form-control" placeholder="Judul Buku..." required>
                        <button type="submit" name="cari" class="btn btn-primary fw-bold" style="background-color: #003399;">
                            CARI DATA
                        </button>
                    </form>
                    <small class="text-muted mt-2 d-block">*Masukan nama lengkap dan judul buku untuk melihat denda.</small>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php
        $tampil_tabel = false;
        $query_sql = "";

        // Logika Admin: Tampilkan Semua (Urutkan yg belum kembali di atas)
        if($level == 'admin'){
            $query_sql = "SELECT * FROM peminjaman ORDER BY tgl_kembali ASC, id DESC"; 
            $tampil_tabel = true;
        } 
        // Logika User: Hanya tampil jika tombol cari ditekan
        else if(isset($_POST['cari'])){
            $nama = $_POST['cari_nama'];
            $judul = $_POST['cari_judul'];
            $query_sql = "SELECT * FROM peminjaman WHERE nama_peminjam LIKE '%$nama%' AND judul_buku LIKE '%$judul%'";
            $tampil_tabel = true;
        }
        ?>

        <?php if($tampil_tabel) { ?>
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-secondary">Daftar Peminjaman Buku</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="head-table text-nowrap">
                            <tr>
                                <th class="py-3 px-3">No</th>
                                <th>Nama Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Durasi / Status</th>
                                <th>Denda</th>
                                <?php if($level == 'admin'){ ?> <th class="text-center">Aksi</th> <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = mysqli_query($koneksi, $query_sql);
                            $no = 1;

                            if(mysqli_num_rows($data) > 0){
                                while($d = mysqli_fetch_array($data)){
                                    
                                    // --- LOGIKA HITUNG ---
                                    if($d['tgl_kembali'] == NULL){
                                        // A. JIKA BELUM DIKEMBALIKAN
                                        $tgl_kembali_view = "<span class='badge bg-warning text-dark badge-status'>Belum Kembali</span>";
                                        $denda_view = "-";
                                        $durasi_view = "<small class='text-muted fst-italic'>Sedang berjalan...</small>";
                                        
                                        // Tombol Aksi Admin: Kembalikan, Edit, Hapus
                                        $btn_kembali = "<a href='kembali.php?id=".$d['id']."' class='btn btn-success btn-sm' onclick='return confirm(\"Proses pengembalian buku ini?\")' title='Kembalikan Buku'><i class='fas fa-check'></i></a>";

                                    } else {
                                        // B. JIKA SUDAH DIKEMBALIKAN
                                        $tgl1 = new DateTime($d['tgl_pinjam']);
                                        $tgl2 = new DateTime($d['tgl_kembali']);
                                        
                                        // Hitung jarak hari
                                        $jarak = $tgl2->diff($tgl1);
                                        $total_hari = ($tgl2 < $tgl1) ? 0 : $jarak->days;

                                        $tgl_kembali_view = date('d M Y', strtotime($d['tgl_kembali']));
                                        $durasi_view = $total_hari . " Hari";

                                        // Hitung Denda (Jika > 7 Hari) 
                                        if($total_hari > 7){
                                            $telat = $total_hari - 7;
                                            $hitung_denda = $telat * 2500; // 
                                            $denda_view = "<span class='text-danger fw-bold'>Rp ".number_format($hitung_denda,0,',','.')."</span> <div style='font-size:11px' class='text-danger'>(Telat $telat hari)</div>";
                                        } else {
                                            $denda_view = "<span class='badge bg-success badge-status'>Bebas Denda</span>";
                                        }

                                        // Tombol Aksi Admin: Tombol Kembali Hilang
                                        $btn_kembali = ""; 
                                    }
                            ?>
                            <tr>
                                <td class="px-3"><?= $no++; ?></td>
                                <td class="fw-bold text-secondary"><?= $d['nama_peminjam']; ?></td>
                                <td><?= $d['judul_buku']; ?></td>
                                <td><?= date('d M Y', strtotime($d['tgl_pinjam'])); ?></td>
                                <td><?= $tgl_kembali_view; ?></td>
                                <td><?= $durasi_view; ?></td>
                                <td><?= $denda_view; ?></td>
                                
                                <?php if($level == 'admin'){ ?>
                                    <td class="text-center text-nowrap">
                                        <?= $btn_kembali; ?>
                                        
                                        <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-warning btn-sm text-white" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                                        
                                        <a href="hapus.php?id=<?= $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus Data"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php 
                                } 
                            } else {
                                // Jika Data Kosong
                                $col = ($level == 'admin') ? 8 : 7;
                                echo "<tr><td colspan='$col' class='text-center py-5 text-muted'><i class='fas fa-folder-open fa-3x mb-3 opacity-25'></i><br>Data tidak ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <?php } else if($level == 'pengguna') { ?>
            <div class="text-center mt-5 text-muted opacity-75">
                <i class="fas fa-search fa-4x mb-3 text-secondary opacity-25"></i>
                <p>Silakan lakukan pencarian data terlebih dahulu.</p>
            </div>
        <?php } ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>