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
<form method="POST">
    <input type="text" name="judul" placeholder="Judul Buku" required>
    <input type="text" name="penulis" placeholder="Penulis" required>
    <button type="submit" name="tambah">Tambah Buku</button>
</form>
<?php endif; ?>

<?php
if(isset($_POST['tambah']) && $_SESSION['role'] == 'Admin') {
    $judul = clean($_POST['judul']);
    $penulis = clean($_POST['penulis']);
    
    $q = mysqli_query($conn, "INSERT INTO Buku (judul, penulis, stok) VALUES ('$judul', '$penulis', 10)");
    
    if($q) {
        echo "<p style='color: green;'>Buku berhasil ditambahkan ke database!</p>";
    } else {
        echo "<p style='color: red;'>Gagal menambah buku: " . mysqli_error($conn) . "</p>";
    }
}
?>

<table border="1">
    <tr><th>ID</th><th>Judul</th><th>Penulis</th><th>Aksi</th></tr>
    <?php
    $data = mysqli_query($conn, "SELECT * FROM Buku");
    while($row = mysqli_fetch_array($data)){
        echo "<tr>
            <td>{$row['id_buku']}</td>
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