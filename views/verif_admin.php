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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Pengajuan Pinjaman Buku</title>

    <link
        rel="stylesheet"
        href="/pinjam_buku/asset/verif_admin.css?v=3"
    >

</head>


<body>


<div class="container">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="header">


        <div class="header-content">

            <h2>
                📩 Pengajuan Pinjaman Buku
            </h2>

            <p>
                Kelola dan verifikasi seluruh pengajuan pinjaman
                dari pengguna.
            </p>

        </div>



        <!-- =================================================
             BUTTON HEADER
        ================================================== -->

        <div class="top-btn">


            <!-- KEMBALI KE DASHBOARD -->

            <a
                href="/pinjam_buku/admin"
                class="back-btn"
            >
                🏠 Kembali ke Dashboard
            </a>



            <!-- =================================================
                 TOMBOL LIGHT / DARK MODE
            ================================================== -->

            <button
                type="button"
                id="theme-toggle"
                class="theme-toggle"
                aria-label="Ganti tema"
                title="Ganti tema"
            >
                🌙
            </button>


        </div>

    </div>



    <!-- =====================================================
         INFORMATION BAR
    ====================================================== -->

    <div class="info-bar">

        <div class="info-title">
            Daftar Pengajuan
        </div>

        <div class="info-description">
            Periksa pengajuan sebelum melakukan verifikasi.
        </div>

    </div>



    <!-- =====================================================
         TABLE
    ====================================================== -->

    <div class="table-box">


        <table>


            <thead>

                <tr>

                    <th>
                        Nama User
                    </th>

                    <th>
                        Buku
                    </th>

                    <th>
                        Tanggal Pinjam
                    </th>

                    <th>
                        Jumlah
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>



            <tbody>


            <?php if (!empty($data)): ?>


                <?php foreach ($data as $row): ?>


                    <tr>


                        <!-- NAMA USER -->

                        <td>

                            <?= htmlspecialchars(
                                $row->nama_pengguna
                            ) ?>

                        </td>



                        <!-- BUKU -->

                        <td>

                            <?= htmlspecialchars(
                                $row->nama_buku
                            ) ?>

                        </td>



                        <!-- TANGGAL PINJAM -->

                        <td>

                            <?= htmlspecialchars(
                                $row->tanggal_pinjam
                            ) ?>

                        </td>



                        <!-- JUMLAH -->

                        <td>

                            <?= htmlspecialchars(
                                $row->jumlah_pinjam
                            ) ?>

                        </td>



                        <!-- AKSI -->

                        <td>

                            <a
                                class="verif-btn"
                                href="/pinjam_buku/admin/verif?id=<?= $row->id_pinjam ?>"
                            >
                                ✅ Verifikasi
                            </a>

                        </td>


                    </tr>


                <?php endforeach; ?>


            <?php else: ?>


                <tr>

                    <td
                        colspan="5"
                        class="empty"
                    >
                        Belum ada pengajuan pinjaman.
                    </td>

                </tr>


            <?php endif; ?>


            </tbody>


        </table>


    </div>



    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <div class="footer">

        © <?= date('Y'); ?> Sistem Perpustakaan

    </div>


</div>



<!-- =====================================================
     GLOBAL THEME
====================================================== -->

<script src="/pinjam_buku/asset/theme.js"></script>


</body>

</html>