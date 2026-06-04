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
    mysqli_query($conn, "DELETE FROM Buku WHERE id_buku = '$id'");
}

header("Location: buku.php");
exit;
?>