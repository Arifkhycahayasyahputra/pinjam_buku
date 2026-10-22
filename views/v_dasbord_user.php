<?php

session_start();

// ==========================================================
// CEK LOGIN
// ==========================================================
if (!isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit;
}

// ==========================================================
// CEK ROLE USER
// ==========================================================
if ($_SESSION['role'] !== 'user') {
    header("Location: /pinjam_buku/admin");
    exit;
}

// ==========================================================
// NAMA USER
// ==========================================================
$nama_user = $_SESSION['nama_pengguna'] ?? 'User';

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>

    <link rel="stylesheet" href="/pinjam_buku/asset/user_dasbord.css?v=1">
</head>

<body>

<!-- NAVBAR -->
<header class="navbar">
    <div class="menu">

        <div class="logo">📚 Perpustakaan</div>

        <div class="menu-right">

            <button
                type="button"
                id="theme-toggle"
                class="theme-toggle"
                aria-label="Ganti tema"
                title="Ganti tema"
            >🌙</button>

            <a href="/pinjam_buku/controllers/c_logout.php">🚪 Logout</a>

        </div>

    </div>
</header>


<!-- CONTAINER -->
<main class="container">

    <!-- HERO -->
    <section class="hero">
        <h1>Selamat Datang, <?= htmlspecialchars($nama_user) ?> 👋</h1>
        <p>
            Peminjaman buku dengan mudah, cepat, dan modern
            melalui sistem perpustakaan digital.
        </p>
    </section>

    <!-- MENU DASHBOARD -->
    <section class="grid">

        <!-- DAFTAR BUKU -->
        <article class="card">
            <div class="card-icon">📚</div>
            <h3>Daftar Buku</h3>
            <p>Lihat semua koleksi buku yang tersedia di perpustakaan.</p>
            <a href="/pinjam_buku/buku" class="card-button">Buka →</a>
        </article>

        <!-- BUKU DIPINJAM -->
        <article class="card">
            <div class="card-icon">📖</div>
            <h3>Buku Dipinjam</h3>
            <p>Lihat buku yang sedang kamu pinjam saat ini.</p>
            <a href="/pinjam_buku/dipinjam" class="card-button">Lihat →</a>
        </article>

        <!-- RIWAYAT -->
        <article class="card">
            <div class="card-icon">📜</div>
            <h3>Riwayat Peminjaman</h3>
            <p>Cek riwayat semua peminjaman yang pernah kamu lakukan.</p>
            <a href="/pinjam_buku/riwayat" class="card-button">Cek →</a>
        </article>

        <!-- DENDA -->
        <article class="card">
            <div class="card-icon">💰</div>
            <h3>Denda Saya</h3>
            <p>Lihat denda peminjaman dan lakukan pembayaran jika masih belum lunas.</p>
            <a href="/pinjam_buku/denda" class="card-button">Lihat Denda →</a>
        </article>

    </section>

    <!-- FOOTER -->
    <footer class="footer">
        © <?= date('Y'); ?> Sistem Perpustakaan Digital
    </footer>

</main>

<script src="/pinjam_buku/asset/theme.js"></script>

</body>
</html>