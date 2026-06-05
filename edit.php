<?php
session_start();
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';

$id = $_GET['id'];
$id = clean($id); // Tambahkan pembersihan untuk keamanan
$query = mysqli_query($conn, "SELECT * FROM Buku WHERE id_buku = '$id'");
$row = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){
    $judul = clean($_POST['judul']);
    $penulis = clean($_POST['penulis']);
    $harga = (int)clean($_POST['harga']); // Pastikan harga adalah angka
    
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    if($gambar) {
        if(!is_dir('uploads')) mkdir('uploads');
        move_uploaded_file($tmp_name, "uploads/" . $gambar);
        $gambar_db = clean($gambar);
        $query_update = "UPDATE Buku SET judul='$judul', penulis='$penulis', harga='$harga', gambar='$gambar_db' WHERE id_buku='$id'";
    } else {
        $query_update = "UPDATE Buku SET judul='$judul', penulis='$penulis', harga='$harga' WHERE id_buku='$id'";
    }

    mysqli_query($conn, $query_update);
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
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="judul" value="<?php echo $row['judul']; ?>" required style="width: 100%; margin-bottom: 15px;">
        <input type="text" name="penulis" value="<?php echo $row['penulis']; ?>" required style="width: 100%; margin-bottom: 15px;">
        <input type="number" name="harga" value="<?php echo $row['harga']; ?>" required style="width: 100%; margin-bottom: 15px;" placeholder="Harga Buku">
        
        <div style="margin-bottom: 15px;">
            <p><small>Ganti Gambar (Opsional):</small></p>
            <input type="file" name="gambar" accept="image/*">
        </div>

        <button type="submit" name="update" style="width: 100%;">Simpan Perubahan</button>
        <p style="text-align: center; margin-top: 15px;"><a href="buku.php" class="btn-back">Batal dan Kembali</a></p>
    </form>
</div>
</body>
</html>