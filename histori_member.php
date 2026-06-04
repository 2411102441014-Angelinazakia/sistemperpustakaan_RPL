<?php
session_start();
if(!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'config.php';

$user_skrg = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Histori Saya</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Riwayat Peminjaman Anda</h2>

    <table border="1">
        <tr>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
            <th>Denda (Estimasi)</th>
        </tr>
        <?php
        $query = "SELECT Peminjaman.*, Buku.judul 
                  FROM Peminjaman 
                  JOIN Buku ON Peminjaman.id_buku = Buku.id_buku 
                  JOIN Anggota ON Peminjaman.id_anggota = Anggota.id_anggota 
                  WHERE Anggota.nama = '$user_skrg' 
                  ORDER BY id_pinjam DESC";
        
        $res = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($res)) {
            $denda = 0;
            if($row['status'] == 'Dipinjam') {
                $jt = strtotime($row['tgl_jatuh_tempo']);
                $skrg = strtotime(date('Y-m-d'));
                $telat = ($skrg - $jt) / (60*60*24);
                if($telat > 0) $denda = $telat * 2000;
            }
            
            $status_color = ($row['status'] == 'Dipinjam') ? 'orange' : 'green';
            
            echo "<tr>
                <td>{$row['judul']}</td>
                <td>{$row['tgl_pinjam']}</td>
                <td>{$row['tgl_jatuh_tempo']}</td>
                <td style='color: $status_color; font-weight:bold;'>{$row['status']}</td>
                <td>" . ($denda > 0 ? "<span style='color:red;'>Rp " . number_format($denda,0,',','.') . "</span>" : "-") . "</td>
            </tr>";
        }
        if(mysqli_num_rows($res) == 0) {
            echo "<tr><td colspan='5'>Belum ada riwayat peminjaman.</td></tr>";
        }
        ?>
    </table>
    <br>
    <div style="text-align: center;"><a href="index.php" class="btn-back">Kembali</a></div>
</div>
</body>
</html>