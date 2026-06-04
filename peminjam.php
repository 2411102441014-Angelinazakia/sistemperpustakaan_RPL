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
    <h2>Transaksi Peminjaman Buku</h2>

    <!-- Form Input Peminjaman -->
    <form method="POST">
        <label>Pilih Buku:</label>
        <select name="id_buku" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
            <?php
            $buku = mysqli_query($conn, "SELECT * FROM Buku WHERE stok > 0");
            while($b = mysqli_fetch_array($buku)) {
                echo "<option value='{$b['id_buku']}'>{$b['judul']} (Stok: {$b['stok']})</option>";
            }
            ?>
        </select>

        <label>Pilih Anggota:</label>
        <select name="id_anggota" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
            <?php
            $agt = mysqli_query($conn, "SELECT * FROM Anggota");
            while($a = mysqli_fetch_array($agt)) {
                echo "<option value='{$a['id_anggota']}'>{$a['nama']}</option>";
            }
            ?>
        </select>

        <button type="submit" name="pinjam">Proses Pinjam</button>
    </form>

<?php
if(isset($_POST['pinjam'])) {
    $id_buku = clean($_POST['id_buku']);
    $id_anggota = clean($_POST['id_anggota']);
    $tgl = date('Y-m-d');
    $tgl_jatuh_tempo = date('Y-m-d', strtotime('+7 days'));

    // 1. Simpan transaksi
    mysqli_query($conn, "INSERT INTO Peminjaman (id_buku, id_anggota, tgl_pinjam, tgl_jatuh_tempo, status) 
                        VALUES ('$id_buku', '$id_anggota', '$tgl', '$tgl_jatuh_tempo', 'Dipinjam')");

    // 2. Kurangi stok buku
    mysqli_query($conn, "UPDATE Buku SET stok = stok - 1 WHERE id_buku = '$id_buku'");

    echo "<p style='color: green;'>Buku berhasil dipinjam!</p>";
}
?>

    <h3>Riwayat Peminjaman Aktif</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Anggota</th>
            <th>Judul Buku</th>
            <th>Tgl Pinjam</th>
            <th>Status</th>
        </tr>
        <?php
        $res = mysqli_query($conn, "SELECT Peminjaman.*, Buku.judul, Anggota.nama 
                                    FROM Peminjaman 
                                    JOIN Buku ON Peminjaman.id_buku = Buku.id_buku 
                                    JOIN Anggota ON Peminjaman.id_anggota = Anggota.id_anggota 
                                    ORDER BY id_pinjam DESC");
        while($row = mysqli_fetch_array($res)) {
            echo "<tr>
                <td>{$row['id_pinjam']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['judul']}</td>
                <td>{$row['tgl_pinjam']}</td>
                <td>{$row['status']}</td>
            </tr>";
        }
        ?>
    </table>
    <br>
    <div style="text-align: center;"><a href="index.php" class="btn-back">Kembali ke Dashboard</a></div>
</div>
</body>