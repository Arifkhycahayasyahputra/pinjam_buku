<?php
session_start();
require_once "../models/m_riwayat.php";

$riwayat = new m_riwayat();
$data_riwayat = $riwayat->tampil_data();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman</title>
    <link rel="stylesheet" href="/pinjam_buku/asset/cekriwayat.css">

</head>

<body>

    <div class="container">


        <div class="top-bar">
            <div>
                <h2>Riwayat Peminjaman Buku</h2>
                <p>Data riwayat peminjaman & pengembalian buku</p>
            </div>

            <div>
                <a href="v_dasbord_admin.php" class="btn btn-buku">Kembali ke dasbord</a>
                <a href="../controllers/c_logout.php" class="btn btn-logout">Logout</a>
            </div>
        </div>


        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Buku</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($data_riwayat)): $no = 1;
                    foreach ($data_riwayat as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row->nama_buku) ?></td>
                            <td><?= htmlspecialchars($row->nama_peminjam) ?></td>
                            <td><?= date('d-m-Y', strtotime($row->tanggal_peminjaman)) ?></td>
                            <td><?= date('d-m-Y', strtotime($row->tanggal_pengembalian)) ?></td>
                            <td>
                                <a href="../controllers/c_riwayat.php?aksi=kembalikan&id_riwayat=<?= $row->id_riwayat ?>"
                                    class="btn-kembali"
                                    onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                    Kembalikan
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;
                else: ?>
                    <tr>
                        <td colspan="6" align="center">Data riwayat belum ada</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>

        <div class="footer">
            © <?= date('Y'); ?> Sistem Perpustakaan
        </div>

    </div>

</body>

</html>