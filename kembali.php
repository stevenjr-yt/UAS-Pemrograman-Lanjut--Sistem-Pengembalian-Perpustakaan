<?php
session_start();
include 'koneksi.php';


if(!isset($_SESSION['login']) || $_SESSION['level'] != 'admin'){
    header('location:tampil.php');
    exit;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $tgl_sekarang = date('Y-m-d'); 

    
    $query = "UPDATE peminjaman SET tgl_kembali = '$tgl_sekarang' WHERE id = '$id'";
    
    if(mysqli_query($koneksi, $query)){
        echo "<script>alert('Buku Berhasil Dikembalikan! Cek Denda.'); window.location='tampil.php';</script>";
    }
}
?>