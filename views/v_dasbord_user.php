<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard User</title>
<link rel="stylesheet" href="/pinjam_buku/asset/dasbord.css">
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="menu">

        <div class="logo">📚 Perpustakaan</div>

        <div class="menu-right">
            <a href="../controllers/c_logout.php">🚪 Logout</a>
        </div>

    </div>
</div>

<!-- CONTENT -->
<div class="container">

    <div class="hero">
        <h1>Selamat Datang 👋</h1>
        <p>Kelola peminjaman buku dengan mudah, cepat, dan modern melalui sistem perpustakaan digital.</p>
    </div>

    <div class="grid">

        <div class="card">
            <h3>📚 Daftar Buku</h3>
            <p>Lihat semua koleksi buku yang tersedia di perpustakaan.</p>
            <a href="../views/v_pinjam_user.php">Buka</a>
        </div>

        <div class="card">
            <h3>📖 Buku Dipinjam</h3>
            <p>Lihat buku yang sedang kamu pinjam saat ini.</p>
            <a href="../views/sedang_dipinjam.php">Lihat</a>
        </div>

        <div class="card">
            <h3>📜 Riwayat Peminjaman</h3>
            <p>Cek riwayat semua peminjaman yang pernah kamu lakukan.</p>
            <a href="../views/v_riwayat_user.php">Cek</a>
        </div>

    </div>

    <div class="footer">
        © <?= date('Y'); ?> Sistem Perpustakaan Digital
    </div>

</div>

</body>
</html>