<?php
session_start();

// Proteksi:  untuk memastikan hanya Admin yang bisa menghapus data
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

include 'config.php';

if(isset($_GET['id'])) {
    $id = clean($_GET['id']);

    // 1. Ambil nama anggota terlebih dahulu sebelum dihapus
    $query_nama = mysqli_query($conn, "SELECT nama FROM Anggota WHERE id_anggota = '$id'");
    $data = mysqli_fetch_assoc($query_nama);
    $nama_anggota = $data['nama'];

    // Gunakan pengecekan: Jika anggota sedang meminjam buku, penghapusan akan gagal di level DB
    // Kita hapus dulu di tabel User, lalu di tabel Anggota
    $deleteUser = mysqli_query($conn, "DELETE FROM User WHERE username = '$nama_anggota' AND role = 'Anggota'");
    $deleteAnggota = mysqli_query($conn, "DELETE FROM Anggota WHERE id_anggota = '$id'");

    if (!$deleteAnggota) {
        // Jika gagal (biasanya karena masih ada data di tabel Peminjaman)
        echo "<script>
                alert('Gagal menghapus! Anggota ini mungkin masih memiliki riwayat peminjaman. Hapus riwayatnya terlebih dahulu.');
                window.location='anggota.php';
              </script>";
        exit;
    }
}

header("Location: anggota.php");
exit;
?>