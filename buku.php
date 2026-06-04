<?php
session_start();
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';
?>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Manajemen Data Buku</h2>

<?php if($_SESSION['role'] == 'Admin') : ?>
<!-- Form Tambah hanya muncul untuk Admin -->
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="judul" placeholder="Judul Buku" required>
    <input type="text" name="penulis" placeholder="Penulis" required>
    <input type="file" name="gambar" accept="image/*">
    <button type="submit" name="tambah">Tambah Buku</button>
</form>
<?php endif; ?>

<?php
if(isset($_POST['tambah']) && $_SESSION['role'] == 'Admin') {
    $judul = clean($_POST['judul']);
    $penulis = clean($_POST['penulis']);
    
    // Logika Upload Gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    if($gambar) {
        if(!is_dir('uploads')) mkdir('uploads');
        move_uploaded_file($tmp_name, "uploads/" . $gambar);
    }
    
    $gambar_db = clean($gambar);
    $q = mysqli_query($conn, "INSERT INTO Buku (judul, penulis, stok, gambar) VALUES ('$judul', '$penulis', 10, '$gambar_db')");
    
    if($q) {
        echo "<p style='color: green;'>Buku berhasil ditambahkan!</p>";
    } else {
        echo "<p style='color: red;'>Gagal menambah buku: " . mysqli_error($conn) . "</p>";
    }
}
?>

<table border="1">
    <tr><th>ID</th><th>Gambar</th><th>Judul</th><th>Penulis</th><th>Aksi</th></tr>
    <?php
    $data = mysqli_query($conn, "SELECT * FROM Buku");
    while($row = mysqli_fetch_array($data)){
        $img = !empty($row['gambar']) ? "uploads/".$row['gambar'] : "https://via.placeholder.com/50x70?text=No+Image";
        echo "<tr>
            <td>{$row['id_buku']}</td>
            <td><img src='$img' width='50' style='border-radius: 4px;'></td>
            <td>{$row['judul']}</td>
            <td>{$row['penulis']}</td>
            <td>";
            if($_SESSION['role'] == 'Admin') {
                echo "<a href='edit.php?id={$row['id_buku']}' class='btn-edit'>Edit</a> 
                    <a href='hapus.php?id={$row['id_buku']}' class='btn-delete' onclick=\"return confirm('Hapus buku ini?')\">Hapus</a>";
            }
        echo "</td></tr>";
    }
    ?>
</table>
<br>
<div style="text-align: center;"><a href="index.php" class="btn-back">Kembali ke Dashboard</a></div>
</div>
</body>