<?php
session_start();

// Jika user sudah login, pindahkan langsung ke index.php
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .portal-container {
            text-align: center;
            max-width: 600px;
        }
        .portal-grid {
            display: flex;
            gap: 40px; /* Memperlebar jarak antar pilihan di halaman Portal */
            justify-content: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="portal-container">
    <h1 style="color: var(--mahogany); font-size: 3em; margin-bottom: 10px;">SELAMAT DATANG</h1>
    <p style="color: #666;">Silakan pilih akses masuk ke Sistem Perpustakaan</p>

    <div class="portal-grid">
        <a href="login_admin.php" class="card" style="padding: 40px; width: 180px;">
            <svg viewBox="0 0 24 24" style="width: 80px; height: 80px;"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            <h3 style="font-size: 1.2em;">ADMIN</h3>
        </a>

        <a href="login_anggota.php" class="card" style="padding: 40px; width: 180px;">
            <svg viewBox="0 0 24 24" style="width: 80px; height: 80px;"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            <h3 style="font-size: 1.2em;">ANGGOTA</h3>
        </a>
    </div>
</div>
</body>
</html>