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
require_once "../models/m_riwayat.php";

$riwayat = new m_riwayat();
$data_riwayat = $riwayat->tampil_data();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Peminjaman</title>
<link rel="stylesheet" href="/pinjam_buku/asset/riwayat_peminjaman.css">
</head>
<body>

<div class="container">

<div class="header">
    <h2>📖 Riwayat Peminjaman Buku</h2>
    <p>Semua data aktivitas peminjaman & pengembalian buku</p>

    <div class="menu">
        <a href="v_dasbord_admin.php" class="btn dashboard">🏠 Kembali ke Dashboard</a>
    </div>
</div>

<div class="table-box">

<table>

<thead>
<tr>
    <th>No</th>
    <th>Nama Buku</th>
    <th>Nama Peminjam</th>
    <th>Tanggal Pinjam</th>
    <th>Tanggal Kembali</th>
    <th>Jumlah</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php if(!empty($data_riwayat)): ?>
<?php $no=1; foreach($data_riwayat as $row): ?>

<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($row->nama_buku) ?></td>
    <td><?= htmlspecialchars($row->nama_peminjam) ?></td>
    <td><?= $row->tanggal_peminjaman ?></td>
    <td><?= $row->tanggal_pengembalian ?></td>
    <td><?= $row->jumlah_pinjam ?></td>
    <td>
        <a href="../controllers/c_riwayat.php?aksi=hapus&id_riwayat=<?= $row->id_riwayat ?>"
           onclick="return confirm('Yakin ingin menghapus riwayat ini?')"
           style="background:red;color:white;padding:6px 10px;border-radius:5px;text-decoration:none;">
           Hapus
        </a>
    </td>
</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>
    <td colspan="7" class="empty">
        Belum ada riwayat peminjaman
    </td>
</tr>

<?php endif; ?>

</tbody>

</table>

</div>

<div class="footer">
© <?= date('Y'); ?> Sistem Perpustakaan Digital
</div>

</div>

</body>
</html>