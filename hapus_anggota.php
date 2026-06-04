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

    // 1. Ambil nama anggota terlebih dahulu sebelum dihapus
    $query_nama = mysqli_query($conn, "SELECT nama FROM Anggota WHERE id_anggota = '$id'");
    $data = mysqli_fetch_assoc($query_nama);
    $nama_anggota = $data['nama'];

    // 2. Hapus akun di tabel User agar username bisa digunakan kembali
    mysqli_query($conn, "DELETE FROM User WHERE username = '$nama_anggota' AND role = 'Anggota'");

    // 3. Hapus data di tabel Anggota
    mysqli_query($conn, "DELETE FROM Anggota WHERE id_anggota = '$id'");
}

header("Location: anggota.php");
exit;
?>