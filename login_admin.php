<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}
include 'config.php';

if (isset($_POST['login'])) {
    $username = clean($_POST['username']);
    $password = clean($_POST['password']);

    // Query khusus mencari role Admin
    $query = mysqli_query($conn, "SELECT * FROM User WHERE username = '$username' AND password = '$password' AND role = 'Admin'");
    
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
    <title>Login Admin - Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: var(--beige); }
        .login-container { width: 360px; }
        input { box-sizing: border-box; width: 100%; margin-bottom: 15px; }
        h2 { color: var(--mahogany); text-align: center; border: none; }
    </style>
</head>
<body>
<div class="login-container">
    <form method="POST">
        <h2>LOGIN ADMIN</h2>
        <?php if(isset($error)) : ?>
            <p style="color: red; text-align: center;">Kredensial Admin Salah!</p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username Admin" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login" style="width: 100%;">Masuk Sistem</button>
        <p style="text-align: center; margin-top: 10px;"><a href="login.php" style="font-size: 0.8em; color: #7f8c8d;">Bukan Admin? Kembali</a></p>
    </form>
</div>
</body>
</html>