<?php
session_start();
// Menghapus semua session
session_destroy();
// Mengalihkan ke halaman login
header("Location: login.php");
exit;
?>