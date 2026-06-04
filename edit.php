<?php
session_start();
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM Buku WHERE id_buku = '$id'");
$row = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){
    $judul = clean($_POST['judul']);
    $penulis = clean($_POST['penulis']);
    
    mysqli_query($conn, "UPDATE Buku SET judul='$judul', penulis='$penulis' WHERE id_buku='$id'");
    header("Location: buku.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edit Data Buku</h2>
    <form method="POST">
        <input type="text" name="judul" value="<?php echo $row['judul']; ?>" required style="width: 100%; margin-bottom: 15px;">
        <input type="text" name="penulis" value="<?php echo $row['penulis']; ?>" required style="width: 100%; margin-bottom: 15px;">
        <button type="submit" name="update" style="width: 100%;">Simpan Perubahan</button>
        <p style="text-align: center; margin-top: 15px;"><a href="buku.php" class="btn-back">Batal dan Kembali</a></p>
    </form>
</div>
</body>
</html>