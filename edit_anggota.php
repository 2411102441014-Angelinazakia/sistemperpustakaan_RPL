<?php
session_start();
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM Anggota WHERE id_anggota = '$id'");
$row = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){
    $nama = clean($_POST['nama']);
    $alamat = clean($_POST['alamat']);
    
    mysqli_query($conn, "UPDATE Anggota SET nama='$nama', alamat='$alamat' WHERE id_anggota='$id'");
    header("Location: anggota.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edit Data Anggota</h2>
    <form method="POST">
        <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required style="width: 100%; margin-bottom: 15px;">
        <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>" required style="width: 100%; margin-bottom: 15px;">
        <button type="submit" name="update" style="width: 100%;">Simpan Perubahan</button>
        <p style="text-align: center; margin-top: 15px;"><a href="anggota.php" class="btn-back">Batal dan Kembali</a></p>
    </form>
</div>
</body>
</html>