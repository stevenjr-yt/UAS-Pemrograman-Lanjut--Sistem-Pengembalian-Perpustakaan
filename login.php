<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){
    $user = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass = mysqli_real_escape_string($koneksi, $_POST['password']);

    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$user' AND password='$pass'");
    
    if(mysqli_num_rows($cek) > 0){
        $data = mysqli_fetch_assoc($cek);
        $_SESSION['login'] = true;
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['level'] = $data['level'];

        if($data['level'] == 'admin'){
         header('location:dashboard.php'); 
        } else {
        header('location:tampil.php');
}
    } else {
        $error = "Akun tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIA Perpustakaan</title>
    <link rel="icon" href="logodarmajaya.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f2f5 0%, #e2e6ea 100%);
        }
        .card-login {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header-login {
            background-color: #003399; 
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        .btn-dj {
            background-color: #003399; 
            color: #fff;
            font-weight: 600;
            border: none;
        }
        .btn-dj:hover { background-color: #003399; color: #fff; }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="col-md-4 col-sm-10">
        <div class="card card-login">
            <div class="header-login">
                <img src="logodarmajaya.png" alt="Logo" width="50" class="mb-2 bg-white rounded-circle p-1">
                <h4 class="mb-0 fw-bold">PERPUSTAKAAN</h4>
                <small>IIB DARMAJAYA</small>
            </div>
            <div class="card-body p-4">
                <?php if(isset($error)) { echo "<div class='alert alert-danger py-2'>$error</div>"; } ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">USERNAME</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukan Username" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">PASSWORD</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukan Password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-dj w-100 py-2">MASUK APLIKASI</button>
                </form>
            </div>
            <div class="card-footer text-center bg-white border-0 pb-4">
                <small class="text-muted">UAS Pemrograman Lanjut - 5T11</small>
            </div>
        </div>
    </div>
</body>
</html>