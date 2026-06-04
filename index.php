<?php
session_start();
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';

$countBuku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM Buku"))['total'];
$countAnggota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM Anggota"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .profile-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            background-color: var(--white);
            border: 1px solid var(--mahogany);
            border-radius: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            cursor: pointer;
        }
        .profile-badge svg {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            fill: var(--mahogany);
        }
        .dropdown-logout {
            display: none;
            position: absolute;
            top: 35px;
            right: 0;
            background-color: var(--white);
            border: 1px solid var(--mahogany);
            border-radius: 8px;
            padding: 10px;
            z-index: 100;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            white-space: nowrap;
        }
        .profile-container:hover .dropdown-logout {
            display: block;
        }
        .dropdown-logout a {
            color: red;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.8em;
        }
        h1 {
            font-size: 2.5em;
            font-weight: 900;
            text-align: center;
            margin-top: 50px;
        }
        .stats-row {
            justify-content: center;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile-container">
        <div class="profile-badge">
            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
            <small><strong><?php echo strtoupper($_SESSION['role']); ?></strong></small>
        </div>
        <div class="dropdown-logout">
            <a href="logout.php" onclick="return confirm('Yakin ingin keluar?')">Logout / Keluar Akun</a>
        </div>
    </div>

    <h1 style="color: var(--mahogany); margin-bottom: 5px;">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>

    <?php if($_SESSION['role'] == 'Admin') : ?>
    <div class="stats-row">
        <span class="stat-item">📚 <b><?php echo $countBuku; ?></b> Total Buku</span>
        <span class="stat-item">👥 <b><?php echo $countAnggota; ?></b> Anggota Terdaftar</span>
    </div>
    <?php endif; ?>

    <div class="dashboard-grid">
        <?php if($_SESSION['role'] == 'Admin') : ?>
        <!-- Card Kelola Buku -->
        <a href="buku.php" class="card">
            <svg viewBox="0 0 24 24"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/></svg>
            <h3>Kelola Buku</h3>
            <p>Tambah, edit, dan hapus koleksi buku perpustakaan.</p>
        </a>

        <!-- Card Kelola Anggota -->
        <a href="anggota.php" class="card">
            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            <h3>Kelola Anggota</h3>
            <p>Manajemen data member dan pendaftaran anggota baru.</p>
        </a>

        <!-- Card Transaksi Peminjaman -->
        <a href="peminjam.php" class="card">
            <svg viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM9 4h2v5l-1-.75L9 9V4z"/></svg>
            <h3>Peminjaman</h3>
            <p>Catat transaksi peminjaman buku oleh anggota.</p>
        </a>

        <!-- Card Pengembalian -->
        <a href="pengembalian.php" class="card">
            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
            <h3>Pengembalian</h3>
            <p>Proses pengembalian buku dan hitung denda otomatis.</p>
        </a>
        <?php else : ?>
        <!-- MENU UNTUK ANGGOTA -->
        <a href="katalog.php" class="card">
            <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            <h3>Katalog Buku</h3>
            <p>Cari koleksi buku yang tersedia di perpustakaan kami.</p>
        </a>

        <a href="histori_member.php" class="card">
            <svg viewBox="0 0 24 24"><path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg>
            <h3>Histori Pinjam</h3>
            <p>Lihat status buku yang Anda pinjam dan denda keterlambatan.</p>
        </a>

        <a href="reservasi.php" class="card">
            <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
            <h3>Reservasi</h3>
            <p>Pesan buku terlebih dahulu sebelum datang ke perpustakaan.</p>
        </a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>