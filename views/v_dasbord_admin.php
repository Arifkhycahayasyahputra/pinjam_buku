<?php

session_start();

/*
==========================================================
TAMPILKAN ERROR SAAT DEBUGGING
(hapus dua baris ini kalau website sudah dipakai sungguhan)
==========================================================
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
==========================================================
CEK LOGIN
==========================================================
*/
if (!isset($_SESSION['role'])) {
    header("Location: /pinjam_buku/");
    exit;
}

/*
==========================================================
CEK ROLE ADMIN
==========================================================
*/
if ($_SESSION['role'] !== 'admin') {
    header("Location: /pinjam_buku/dashboard");
    exit;
}

/*
==========================================================
PANGGIL MODEL
==========================================================
*/
include "../models/m_dashboard.php";

$dashboard = new m_dashboard();

/*
==========================================================
AMBIL DATA DASHBOARD
==========================================================
*/
$total_buku    = $dashboard->total_buku();
$total_user    = $dashboard->total_user();
$total_pending = $dashboard->total_pending();
$total_pinjam  = $dashboard->total_pinjam();
$total_kembali = $dashboard->total_kembali();

/*
==========================================================
NAMA ADMIN
==========================================================
*/
$nama_admin = $_SESSION['nama_pengguna'] ?? 'Admin';

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="/pinjam_buku/asset/admin_dasbord.css?v=4">
</head>

<body>

<!-- SIDEBAR -->
<aside class="sidebar">

    <div class="sidebar-brand">
        <span class="brand-icon">📚</span>
        <span>Admin</span>
    </div>

    <nav class="sidebar-nav">

        <a href="/pinjam_buku/admin" class="nav-link active">
            <span class="nav-icon">🏠</span> Dashboard
        </a>

        <a href="/pinjam_buku/admin/buku" class="nav-link">
            <span class="nav-icon">📖</span> Data Buku
        </a>

        <a href="/pinjam_buku/admin/user" class="nav-link">
            <span class="nav-icon">👥</span> Data User
        </a>

        <a href="/pinjam_buku/admin/pengajuan" class="nav-link">
            <span class="nav-icon">📩</span> Pengajuan Pinjaman
        </a>

        <a href="/pinjam_buku/admin/riwayat" class="nav-link">
            <span class="nav-icon">📜</span> Riwayat
        </a>

    </nav>

    <div class="sidebar-footer">
        <a href="/pinjam_buku/controllers/c_logout.php" class="nav-link">
            <span class="nav-icon">🚪</span> Logout
        </a>
    </div>

</aside>


<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <header class="topbar">

        <h1>Dashboard Admin</h1>

        <div class="topbar-right">

            <span class="user-chip" title="Admin yang sedang login">
                <?= htmlspecialchars($nama_admin) ?>
            </span>

            <button
                type="button"
                id="theme-toggle"
                class="theme-toggle"
                aria-label="Ganti tema"
                title="Ganti tema"
            >🌙</button>

        </div>

    </header>


    <!-- WELCOME -->
    <section class="welcome">
        <h2>Selamat Datang di Dashboard Admin</h2>
        <p>Kelola sistem perpustakaan dengan mudah dan cepat</p>
    </section>


    <!-- STATISTIK -->
    <section class="cards">

        <article class="card">
            <h3 class="card-label">Total Buku</h3>
            <div class="card-stat">
                <span class="card-icon">📚</span>
                <span class="card-value"><?= (int) $total_buku ?></span>
            </div>
        </article>

        <article class="card">
            <h3 class="card-label">Total User</h3>
            <div class="card-stat">
                <span class="card-icon">👥</span>
                <span class="card-value"><?= (int) $total_user ?></span>
            </div>
        </article>

        <article class="card">
            <h3 class="card-label">Pengajuan Baru</h3>
            <div class="card-stat">
                <span class="card-icon">📩</span>
                <span class="card-value"><?= (int) $total_pending ?></span>
            </div>
        </article>

        <article class="card">
            <h3 class="card-label">Peminjaman</h3>
            <div class="card-stat">
                <span class="card-icon">📥</span>
                <span class="card-value"><?= (int) $total_pinjam ?></span>
            </div>
        </article>

        <article class="card">
            <h3 class="card-label">Total Pengembalian Buku</h3>
            <div class="card-stat">
                <span class="card-icon">📤</span>
                <span class="card-value"><?= (int) $total_kembali ?></span>
            </div>
        </article>

    </section>


    <!-- INFORMASI ADMIN -->
    <section class="section">
        <h3>📌 Informasi Admin</h3>
        <p>Gunakan sidebar untuk mengelola semua data perpustakaan.</p>
    </section>

</div>


<!-- GLOBAL THEME -->
<script src="/pinjam_buku/asset/theme.js"></script>

</body>
</html>