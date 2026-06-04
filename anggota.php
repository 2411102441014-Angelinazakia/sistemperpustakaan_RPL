<?php
session_start();
// 1. Cek Login
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// 2. Sertakan koneksi
include 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Anggota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Manajemen Data Anggota</h2>

    <!-- Form Tambah Anggota -->
    <form method="POST" style="max-width: fit-content;">
        <input type="text" name="nama" placeholder="Nama Anggota" required>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <button type="submit" name="tambah">Tambah Anggota</button>
    </form>

    <?php
    if(isset($_POST['tambah'])){
        $nama = clean($_POST['nama']);
        $alamat = clean($_POST['alamat']);
        
        // Gunakan pengecekan agar jika salah satu gagal, kita tahu
        $q1 = mysqli_query($conn, "INSERT INTO Anggota (nama, alamat) VALUES ('$nama', '$alamat')");
        $q2 = mysqli_query($conn, "INSERT INTO User (username, password, role) VALUES ('$nama', '123', 'Anggota')");

        if($q1 && $q2) {
            echo "<p style='color: green;'>Anggota dan Akun Login berhasil ditambahkan!</p>";
        } else {
            echo "<p style='color: red;'>Gagal menambahkan data: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>

    <table border="1">
        <tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Aksi</th></tr>
        <?php
        $data = mysqli_query($conn, "SELECT * FROM Anggota");
        while($row = mysqli_fetch_array($data)){
            echo "<tr>
                <td>{$row['id_anggota']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['alamat']}</td>
                <td>";
                if($_SESSION['role'] == 'Admin') {
                    echo "<a href='edit_anggota.php?id={$row['id_anggota']}' class='btn-edit'>Edit</a> 
                        <a href='hapus_anggota.php?id={$row['id_anggota']}' class='btn-delete' onclick=\"return confirm('Hapus anggota ini?')\">Hapus</a>";
                }
            echo "</td></tr>";
        }
        ?>
    </table>
    <br>
    <div style="text-align: center;"><a href="index.php" class="btn-back">Kembali ke Dashboard</a></div>
</div>
</body>
</html>