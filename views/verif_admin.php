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

include "../models/m_pinjam.php";

$pinjam = new m_pinjam();
$data = $pinjam->tampil_pending();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengajuan Pinjaman Buku</title>
<link rel="stylesheet" href="/pinjam_buku/asset/verif_admin.css">


</head>
<body>

<div class="container">

<div class="header">
    <h2>📩 Pengajuan Pinjaman Buku</h2>
    <p>Kelola dan verifikasi seluruh pengajuan pinjaman dari pengguna.</p>

    <div class="top-btn">
        <a href="v_dasbord_admin.php" class="back-btn">🏠 Kembali ke Dashboard</a>
    </div>
</div>


<div class="table-box">

<table>

<thead>
<tr>
    <th>Nama User</th>
    <th>Buku</th>
    <th>Tanggal Pinjam</th>
    <th>Jumlah</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php if(!empty($data)): ?>

<?php foreach($data as $row): ?>

<tr>
    <td><?= htmlspecialchars($row->nama_pengguna) ?></td>

    <td><?= htmlspecialchars($row->nama_buku) ?></td>

    <td><?= htmlspecialchars($row->tanggal_pinjam) ?></td>

    <td><?= htmlspecialchars($row->jumlah_pinjam) ?></td>

    <td>
        <a class="verif-btn"
        href="verifikasi.php?id=<?= $row->id_pinjam ?>">
            ✅ Verifikasi
        </a>
    </td>
</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>
    <td colspan="5" class="empty">
        Belum ada pengajuan pinjaman.
    </td>
</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</body>
</html>