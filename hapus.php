<?php
session_start();

// Proteksi: Pastikan hanya Admin yang bisa menghapus data
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

include 'config.php';

if(isset($_GET['id'])) {
    $id = clean($_GET['id']);
    $query = mysqli_query($conn, "DELETE FROM Buku WHERE id_buku = '$id'");

    if (!$query) {
        // Jika gagal karena buku sedang dipinjam atau ada di reservasi
        echo "<script>
                alert('Buku tidak bisa dihapus karena sedang dalam transaksi peminjaman atau reservasi!');
                window.location='buku.php';
            </script>";
        exit;
    }
}

header("Location: buku.php");
exit;
?>