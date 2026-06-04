<?php
session_start();
include 'config.php';

if (isset($_POST['register'])) {
    $username = clean($_POST['username']);
    $password = clean($_POST['password']);
    $alamat = clean($_POST['alamat']);

    // Cek apakah username sudah digunakan
    $checkUser = mysqli_query($conn, "SELECT * FROM User WHERE username = '$username'");
    if (mysqli_num_rows($checkUser) > 0) {
        $error = "Username sudah digunakan, silakan pilih yang lain.";
    } else {
        // 1. Simpan ke tabel Anggota
        $queryAnggota = "INSERT INTO Anggota (nama, alamat) VALUES ('$username', '$alamat')";
        if (mysqli_query($conn, $queryAnggota)) {
            // 2. Simpan ke tabel User dengan role 'Anggota'
            $queryUser = "INSERT INTO User (username, password, role) VALUES ('$username', '$password', 'Anggota')";
            if (mysqli_query($conn, $queryUser)) {
                header("Location: login_anggota.php?pesan=registrasi_berhasil");
                exit;
            } else {
                $error = "Gagal membuat akun login.";
            }
        } else {
            $error = "Gagal mendaftarkan data anggota.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Anggota - Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            width: 400px;
        }
        input {
            box-sizing: border-box;
            margin-right: 0 !important;
        }
    </style>
</head>
<body>
<div class="register-container">
    <form method="POST">
        <h2>Daftar Anggota Baru</h2>
        <?php if(isset($error)) : ?>
            <p style="color: #e74c3c; font-style: italic;"><?php echo $error; ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username / Nama Lengkap" required style="width: 100%; margin-bottom: 15px;">
        <input type="password" name="password" placeholder="Password" required style="width: 100%; margin-bottom: 15px;">
        <input type="text" name="alamat" placeholder="Alamat Lengkap" required style="width: 100%; margin-bottom: 15px;">
        <button type="submit" name="register" style="width: 100%;">Daftar Sekarang</button>
        <p style="text-align: center; margin-top: 15px;">Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>
</div>
</body>
</html>