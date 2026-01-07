<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UAS Pemrograman Lanjut - Intro</title>
    <link rel="icon" href="logodarmajaya.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1e3a8a; /* Biru Tua sesuai gambar */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0;
        }

        /* Card Container */
        .intro-card {
            background: white;
            width: 100%;
            max-width: 450px;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            position: relative;
            z-index: 2;
            animation: fadeUp 0.8s ease-out; /* Animasi Muncul */
        }

        /* Typography */
        h4 { color: #1e3a8a; font-weight: 700; margin-bottom: 5px; }
        .subtitle { color: #6c757d; font-size: 14px; letter-spacing: 1px; margin-bottom: 30px; }
        
        .info-label {
            font-size: 12px;
            color: #999;
            margin-bottom: 2px;
            text-transform: uppercase;
        }
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        
        .btn-start {
            background-color:  #003399; 
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 15px;
            width: 100%;
            border: none;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            text-align: center;
            text-decoration: none;
            margin-top: 20px;
        }
        .btn-start:hover {
            background-color:  #003399;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(25, 135, 84, 0.3);
        }

        /* Footer */
        .footer-text {
            text-align: center;
            font-size: 11px;
            color: #bbb;
            margin-top: 20px;
        }

        /* --- ANIMASI TRANSISI (THE WAVE EFFECT) --- */
        .transition-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: #f4f6f9; /* Warna background login */
            z-index: 9999;
            transform: translateY(100%); /* Mulai dari bawah */
            transition: transform 0.6s cubic-bezier(0.77, 0, 0.175, 1);
        }
        .transition-active {
            transform: translateY(0);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="transition-overlay" id="wave"></div>

    <div class="intro-card">
        <div class="text-center">
            <h4>UAS Pemrograman Lanjut</h4>
            <p class="subtitle">TAHUN AJARAN 2025 / 2026</p>
        </div>

        <div class="mt-4">
            <div class="info-label">Nama Mahasiswa</div>
            <div class="info-value">Steven Erlinto</div>

            <div class="info-label">NPM</div>
            <div class="info-value">2411010038</div>

            <div class="info-label">Kelas / Jurusan</div>
            <div class="info-value">5TI1 - Teknik Informatika</div>

            <div class="info-label">Dosen Pengampu</div>
            <div class="info-value">Sulyono, S.Kom., M.TI</div>
        </div>

        <a href="login.php" class="btn-start" onclick="startTransition(event)">
            Buka Aplikasi &rarr;
        </a>

        <div class="footer-text">
            Institut Informatika & Bisnis Darmajaya
        </div>
    </div>

    <script>
        function startTransition(e) {
            e.preventDefault(); // Tahan link dulu
            const wave = document.getElementById('wave');
            
            // 1. Jalankan Animasi Wave Naik
            wave.classList.add('transition-active');

            // 2. Redirect setelah animasi selesai (600ms)
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 600);
        }
    </script>
</body>
</html>