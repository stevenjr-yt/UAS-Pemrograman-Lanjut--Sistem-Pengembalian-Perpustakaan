<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya Admin
if(!isset($_SESSION['login']) || $_SESSION['level'] != 'admin'){
    header('location:tampil.php');
    exit;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    $query = "DELETE FROM peminjaman WHERE id = '$id'";
    
    if(mysqli_query($koneksi, $query)){
        echo "<script>alert('Data Berhasil Dihapus!'); window.location='tampil.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>