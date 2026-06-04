<?php
session_start();
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

?>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Transaksi Pengembalian Buku</h2>
<?php
include 'config.php';

if(isset($_POST['proses_kembali'])) {
    $id_pinjam = clean($_POST['id_pinjam']);
    $tgl_kembali = date('Y-m-d');
    
    // Ambil data jatuh tempo dari tabel Peminjaman
    $query = mysqli_query($conn, "SELECT tgl_jatuh_tempo FROM Peminjaman WHERE id_pinjam = '$id_pinjam'");
    $data = mysqli_fetch_assoc($query);
    
    // Hitung Denda (Rp 2.000/hari)
    $jatuh_tempo = strtotime($data['tgl_jatuh_tempo']);
    $sekarang = strtotime($tgl_kembali);
    $terlambat = ($sekarang - $jatuh_tempo) / (60 * 60 * 24);
    $denda = ($terlambat > 0) ? $terlambat * 2000 : 0;

    // 1. Simpan ke tabel Pengembalian
    mysqli_query($conn, "INSERT INTO Pengembalian (id_pinjam, tgl_kembali, denda) VALUES ('$id_pinjam', '$tgl_kembali', '$denda')");

    // 2. Update status di tabel Peminjaman
    mysqli_query($conn, "UPDATE Peminjaman SET status = 'Kembali' WHERE id_pinjam = '$id_pinjam'");

    // 3. Tambah kembali stok buku
    mysqli_query($conn, "UPDATE Buku SET stok = stok + 1 WHERE id_buku = (SELECT id_buku FROM Peminjaman WHERE id_pinjam = '$id_pinjam')");

    echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid var(--mahogany);'>
            <strong>Berhasil dikembalikan!</strong><br>
            Denda yang harus dibayar: <b>Rp " . number_format($denda, 0, ',', '.') . "</b>
        </div>";
}
?>

    <h3>Daftar Buku Yang Sedang Dipinjam</h3>
    <table border="1">
        <tr>
            <th>ID Pinjam</th>
            <th>Peminjam</th>
            <th>Judul Buku</th>
            <th>Aksi</th>
        </tr>
        <?php
        $pinjaman = mysqli_query($conn, "SELECT Peminjaman.*, Buku.judul, Anggota.nama 
                                        FROM Peminjaman 
                                        JOIN Buku ON Peminjaman.id_buku = Buku.id_buku 
                                        JOIN Anggota ON Peminjaman.id_anggota = Anggota.id_anggota 
                                        WHERE Peminjaman.status = 'Dipinjam'");
        
        while($p = mysqli_fetch_array($pinjaman)) {
            echo "<tr>
                <td>{$p['id_pinjam']}</td>
                <td>{$p['nama']}</td>
                <td>{$p['judul']}</td>
                <td>
                    <form method='POST' style='box-shadow:none; background:none; padding:0; margin:0;'>
                        <input type='hidden' name='id_pinjam' value='{$p['id_pinjam']}'>
                        <button type='submit' name='proses_kembali' style='padding: 5px 10px; font-size: 0.8em;'>Pengembalian Diterima</button>
                    </form>
                </td>
            </tr>";
        }
        ?>
    </table>
    <br>
    <div style="text-align: center;"><a href="index.php" class="btn-back">Kembali ke Dashboard</a></div>
</div>
</body>