<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_perpustakaan";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function clean($data) {
    global $conn;
    // Gunakan trim untuk menghapus spasi yang tidak sengaja terketik di awal/akhir
    return mysqli_real_escape_string($conn, trim($data));
}