<?php
ob_start(); // Mencegah error "headers already sent"
session_start();
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}
include 'config.php';

if (isset($_POST['login'])) {
    $username = clean($_POST['username']);
    $password = clean($_POST['password']);

    // Query khusus mencari role Anggota
    $query = mysqli_query($conn, "SELECT * FROM User WHERE username = '$username' AND password = '$password' AND role = 'Anggota'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Anggota - Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { width: 360px; }
        input { box-sizing: border-box; width: 100%; margin-bottom: 15px; }
        h2 { color: var(--mahogany); text-align: center; border: none; }
    </style>
</head>
<body>
<div class="login-container">
    <form method="POST">
        <h2>LOGIN ANGGOTA</h2>
        
        <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'registrasi_berhasil' && !isset($_POST['login'])) : ?>
            <p style="color: green; text-align: center;">Daftar Berhasil! Silakan Login.</p>
        <?php endif; ?>

        <?php if(isset($error)) : ?>
            <p style="color: red; text-align: center;">Username atau Password salah!</p>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Username Anggota" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login" style="width: 100%;">Masuk</button>
        <p style="text-align: center; margin-top: 15px;">Belum jadi anggota? <a href="register.php">Daftar di sini</a></p>
        <p style="text-align: center;"><a href="login.php" style="font-size: 0.8em; color: #7f8c8d;">Kembali ke Pilihan</a></p>
    </form>
</div>
</body>
</html>