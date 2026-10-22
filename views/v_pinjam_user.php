<?php
session_start();

require_once "../models/m_buku.php";

if (!isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit;
}

$buku = new m_buku();
$data_buku = $buku->tampil_data();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pinjam Buku</title>

    <link rel="stylesheet" href="/pinjam_buku/asset/pinjam_user.css?v=">
</head>

<body>

<div class="navbar">

    <div class="menu">

        <a href="/pinjam_buku/dashboard" class="nav-btn">
            🏠 Kembali Ke Dashboard
        </a>

        <button type="button" id="theme-toggle" class="theme-toggle">
            🌙
        </button>
    </div>

</div>


<div class="container">

    <div class="title-box">

        <div>
            <h2>📚 Daftar Buku Perpustakaan</h2>

            <p>
                Silahkan pilih buku yang ingin dipinjam dari daftar berikut.
            </p>
        </div>

    </div>


    <div class="table-wrapper">

        <table>

            <thead>

                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Judul Buku</th>
                    <th>Pencipta</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

                <?php if (!empty($data_buku)): ?>

                    <?php $no = 1; ?>

                    <?php foreach ($data_buku as $row): ?>

                        <tr>

                            <td>
                                <?= $no++ ?>
                            </td>


                            <td>

                                <?php if (!empty($row->gambar)): ?>

                                    <img
                                        src="<?= htmlspecialchars($row->gambar) ?>"
                                        alt="<?= htmlspecialchars($row->nama_buku) ?>"
                                    >

                                <?php else: ?>

                                    <div class="no-cover">
                                        📚
                                    </div>

                                <?php endif; ?>

                            </td>


                            <td>

                                <strong>
                                    <?= htmlspecialchars($row->nama_buku) ?>
                                </strong>

                            </td>


                            <td>

                                <?= htmlspecialchars($row->pencipta) ?>

                            </td>


                            <td>

                                <span class="stok">
                                    Stok: <?= htmlspecialchars($row->stok) ?>
                                </span>

                            </td>


                            <td>

                                <?php if ($row->stok > 0): ?>

                                    <a
                                        class="btn-pinjam"
                                        href="/pinjam_buku/pinjam?kode_buku=<?= urlencode($row->kode_buku) ?>"
                                    >
                                        Pinjam
                                    </a>

                                <?php else: ?>

                                    <span class="stok-habis">
                                        Stok Habis
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="6">

                            Buku belum tersedia

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>


<!-- THEME GLOBAL -->
<script src="/pinjam_buku/asset/theme.js"></script>

</body>

</html>