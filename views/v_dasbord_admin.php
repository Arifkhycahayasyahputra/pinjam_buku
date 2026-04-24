<?php
session_start();


if (!isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: v_dasbord_user.php");
    exit;
}


include "../models/m_dashboard.php";

$dashboard = new m_dashboard();

$total_buku    = $dashboard->total_buku();
$total_user    = $dashboard->total_user();
$total_pending = $dashboard->total_pending();
$total_pinjam  = $dashboard->total_pinjam();
$total_kembali = $dashboard->total_kembali();


$nama_admin = $_SESSION['nama_pengguna'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

<link rel="stylesheet" href="/pinjam_buku/asset/dasbord_admin.css">

</head>
<body>


<div class="sidebar">

    <h2>📚 Admin</h2>

    <a href="#">🏠 Dashboard</a>
    <a href="../views/v_admin_buku.php">📖 Data Buku</a>
    <a href="../views/v_data_user.php">👥 Data User</a>
    <a href="../views/verif_admin.php">📩 Pengajuan Pinjaman</a>
    <a href="../views/v_riwayat_peminjaman_buku.php">📜 Riwayat</a>
    <a href="../controllers/c_logout.php">🚪 Logout</a>

</div>


<div class="main">

    
    <div class="topbar">
        <h1>Dashboard Admin</h1>
        <span>Selamat datang, <?= htmlspecialchars($nama_admin) ?> 👋</span>
    </div>


    <div class="welcome">
        <h2>Selamat Datang di Dashboard Admin</h2>
        <p>Kelola sistem perpustakaan dengan mudah dan cepat</p>
    </div>

    
    <div class="cards">

        <div class="card">
            <h3>📚 Total Buku</h3>
            <p><?= $total_buku ?></p>
        </div>

        <div class="card">
            <h3>👥 Total User</h3>
            <p><?= $total_user ?></p>
        </div>

        <div class="card">
            <h3>📩 Pengajuan Baru</h3>
            <p><?= $total_pending ?></p>
        </div>

        <div class="card">
            <h3>📥 Peminjaman</h3>
            <p><?= $total_pinjam ?></p>
        </div>

        <div class="card">
            <h3>📤 Total Pengembalian Buku</h3>
            <p><?= $total_kembali ?></p>
        </div>

    </div>


    <div class="section">
        <h3>📌 Informasi Admin</h3>
        <p>Gunakan sidebar untuk mengelola semua data perpustakaan.</p>
    </div>

</div>

</body>
</html>