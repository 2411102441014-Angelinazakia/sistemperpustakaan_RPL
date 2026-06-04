<?php
session_start();
if(!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Katalog Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Katalog Buku Perpustakaan</h2>
    
    <form method="GET">
        <input type="text" name="cari" placeholder="Cari Judul atau Penulis..." style="width: 70%;">
        <button type="submit">Cari Buku</button>
    </form>

    <table border="1">
        <tr>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php
        $keyword = isset($_GET['cari']) ? clean($_GET['cari']) : '';
        $query = "SELECT * FROM Buku WHERE judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%'";
        $data = mysqli_query($conn, $query);
        
        while($row = mysqli_fetch_array($data)) {
            $status_stok = ($row['stok'] > 0) ? $row['stok'] : "<span style='color:red;'>Habis</span>";
            $img = !empty($row['gambar']) ? "uploads/".$row['gambar'] : "https://via.placeholder.com/50x70?text=No+Image";
            echo "<tr>
                <td><img src='$img' width='50' style='border-radius: 4px;'></td>
                <td>{$row['judul']}</td>
                <td>{$row['penulis']}</td>
                <td>$status_stok</td>
                <td>";
                if($row['stok'] > 0) {
                    echo "<a href='reservasi.php?id_buku={$row['id_buku']}' class='btn-edit' style='background-color: #27ae60;'>Reservasi</a>";
                } else {
                    echo "-";
                }
            echo "</td></tr>";
        }
        ?>
    </table>
    <br>
    <div style="text-align: center;"><a href="index.php" class="btn-back">Kembali</a></div>
</div>
</body>
</html>