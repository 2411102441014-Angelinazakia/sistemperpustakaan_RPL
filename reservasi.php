<?php
session_start();
if(!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'config.php';

$user_skrg = $_SESSION['username'];
// Cari ID Anggota berdasarkan session username
$agt_query = mysqli_query($conn, "SELECT id_anggota FROM Anggota WHERE nama = '$user_skrg'");
$agt_data = mysqli_fetch_assoc($agt_query);
$id_anggota = $agt_data['id_anggota'] ?? 0;

if(isset($_POST['ajukan'])) {
    if ($id_anggota == 0) {
        $msg = "<span style='color:red;'>Gagal: Data profil anggota tidak ditemukan.</span>";
    } else {
        $id_buku = clean($_POST['id_buku']);
        $tgl = date('Y-m-d');
        mysqli_query($conn, "INSERT INTO Reservasi (id_buku, id_anggota, tgl_reservasi, status) VALUES ('$id_buku', '$id_anggota', '$tgl', 'Pending')");
        $msg = "Reservasi berhasil diajukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Reservasi Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Pengajuan Reservasi</h2>
    
    <?php if(isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>

    <form method="POST">
        <label>Pilih Buku untuk di-Booking:</label>
        <select name="id_buku" required style="width: 100%; padding: 10px; margin: 10px 0;">
            <?php
            $buku_id_url = isset($_GET['id_buku']) ? clean($_GET['id_buku']) : '';
            $buku = mysqli_query($conn, "SELECT * FROM Buku WHERE stok > 0");
            while($b = mysqli_fetch_array($buku)) {
                $selected = ($b['id_buku'] == $buku_id_url) ? 'selected' : '';
                echo "<option value='{$b['id_buku']}' $selected>{$b['judul']}</option>";
            }
            ?>
        </select>
        <button type="submit" name="ajukan" style="width: 100%;">Ajukan Reservasi Sekarang</button>
    </form>

    <h3>Status Reservasi Saya</h3>
    <table border="1">
        <tr><th>Buku</th><th>Tanggal</th><th>Status</th></tr>
        <?php
        $my_res = mysqli_query($conn, "SELECT Reservasi.*, Buku.judul FROM Reservasi JOIN Buku ON Reservasi.id_buku = Buku.id_buku WHERE id_anggota = '$id_anggota'");
        while($r = mysqli_fetch_array($my_res)) {
            echo "<tr>
                <td>{$r['judul']}</td>
                <td>{$r['tgl_reservasi']}</td>
                <td><b>{$r['status']}</b></td>
            </tr>";
        }
        ?>
    </table>
    <br>
    <div style="text-align: center;"><a href="index.php" class="btn-back">Kembali</a></div>
</div>
</body>
</html>