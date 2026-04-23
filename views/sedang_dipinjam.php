<?php
include "../models/m_pinjam.php";

$pinjam = new m_pinjam();
$data_pinjam = $pinjam->tampil_buku_dipinjam();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Buku Dipinjam</title>
<link rel="stylesheet" href="/pinjam_buku/asset/dipinjam.css">
</head>
<body>

<div class="container">

<!-- HEADER -->
<div class="header">
    <h2>📚 Buku Sedang Dipinjam</h2>
    <p>Daftar buku yang saat ini masih dalam proses peminjaman.</p>

    <a href="v_dasbord_user.php" class="back-btn">🏠 Kembali ke Dashboard</a>
</div>

<!-- TABLE -->
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
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php if(!empty($data_pinjam)): ?>

<?php $no=1; foreach($data_pinjam as $row): ?>

<tr>

    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($row->nama_buku) ?></td>
    <td><?= htmlspecialchars($row->nama_pengguna) ?></td>
    <td><?= $row->tanggal_pinjam ?></td>
    <td><?= $row->tanggal_kembali ?></td>
    <td><?= $row->jumlah_pinjam ?></td>

    <td>
        <span class="status <?= ($row->status=='dipinjam') ? 'pinjam' : 'kembali' ?>">
            <?= ucfirst($row->status) ?>
        </span>
    </td>

    <td>
        <a class="btn-kembali"
        href="../controllers/c_kembalikan.php?id_pinjam=<?= $row->id_pinjam ?>">
            🔄 Kembalikan
        </a>
    </td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>
    <td colspan="8" class="empty">
        Tidak ada buku yang sedang dipinjam
    </td>
</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</body>
</html>