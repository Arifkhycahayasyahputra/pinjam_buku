<?php

session_start();


/*
=========================================================
CEK LOGIN
=========================================================
*/

if (!isset($_SESSION['role'])) {

    header("Location: ../index.php");
    exit;

}


/*
=========================================================
USER SAJA
=========================================================
*/

if ($_SESSION['role'] !== 'user') {

    header("Location: v_dasbord_admin.php");
    exit;

}


/*
=========================================================
MODEL DENDA
=========================================================
*/

require_once "../models/m_denda.php";

$denda_model = new m_denda();


/*
=========================================================
DATA SESSION
=========================================================
*/

$id_pengguna = $_SESSION['id_pengguna'] ?? 0;

$id_pengguna = (int) $id_pengguna;

$nama_user = $_SESSION['nama_pengguna'] ?? 'User';


/*
=========================================================
AMBIL DENDA USER
=========================================================
*/

$data_denda = [];

if ($id_pengguna > 0) {

    $data_denda =
        $denda_model->tampil_denda_user(
            $id_pengguna
        );

}


/*
=========================================================
TOTAL
=========================================================
*/

$total_denda = 0;

$total_belum_lunas = 0;

$total_lunas = 0;


foreach ($data_denda as $denda) {

    $total_denda +=
        (float) $denda->jumlah_denda;


    if ($denda->status_pembayaran === 'belum_lunas') {

        $total_belum_lunas +=
            (float) $denda->jumlah_denda;

    } else {

        $total_lunas +=
            (float) $denda->jumlah_denda;

    }

}

?>


<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Denda - Perpustakaan</title>


    <!-- CSS DENDA -->

    <link
        rel="stylesheet"
        href="/pinjam_buku/asset/denda_new.css?v=4"
    >

</head>


<body>


<!-- =====================================================
     NAVBAR
====================================================== -->

<nav class="navbar">

    <div class="logo">
        📚 Perpustakaan
    </div>


    <div class="nav-menu">


        <!-- DASHBOARD -->

        <a href="/pinjam_buku/dashboard">

            🏠 Dashboard

        </a>


        <!-- LIHAT BUKU -->

        <a
            href="/pinjam_buku/buku"
            class="nav-link"
        >

            📚 Lihat Buku

        </a>


        <!-- DENDA -->

        <a
            href="/pinjam_buku/denda"
            class="nav-link active"
        >

            💰 Denda

        </a>


        <!-- TOMBOL TEMA -->

        <button
            type="button"
            id="theme-toggle"
            class="theme-toggle"
            aria-label="Ganti tema"
            title="Ganti tema"
        >

            🌙

        </button>


        <!-- LOGOUT -->
<!-- 
        <a
            href="../controllers/c_logout.php"
            class="logout"
        >

            🚪 Logout

        </a> -->


    </div>

</nav>



<!-- =====================================================
     CONTAINER
====================================================== -->

<main class="container">


    <!-- =================================================
         HEADER
    ================================================== -->

    <section class="page-header">


        <div>


            <p class="small-title">

                PERPUSTAKAAN DIGITAL

            </p>


            <h1>

                💰 Denda Saya

            </h1>


            <p>

                Halo,

                <strong>

                    <?= htmlspecialchars($nama_user) ?>

                </strong>.

                Berikut adalah daftar denda yang terkait
                dengan transaksi peminjaman kamu.

            </p>


        </div>


    </section>



    <!-- =================================================
         RINGKASAN
    ================================================== -->

    <section class="summary-grid">


        <!-- TOTAL DENDA -->

        <div class="summary-card">


            <div class="summary-icon">

                💰

            </div>


            <div>

                <span>

                    Total Denda

                </span>


                <strong>

                    Rp <?= number_format(
                        $total_denda,
                        0,
                        ',',
                        '.'
                    ) ?>

                </strong>

            </div>


        </div>



        <!-- BELUM LUNAS -->

        <div class="summary-card belum">


            <div class="summary-icon">

                ⚠️

            </div>


            <div>

                <span>

                    Belum Lunas

                </span>


                <strong>

                    Rp <?= number_format(
                        $total_belum_lunas,
                        0,
                        ',',
                        '.'
                    ) ?>

                </strong>

            </div>


        </div>



        <!-- SUDAH LUNAS -->

        <div class="summary-card lunas">


            <div class="summary-icon">

                ✅

            </div>


            <div>

                <span>

                    Sudah Lunas

                </span>


                <strong>

                    Rp <?= number_format(
                        $total_lunas,
                        0,
                        ',',
                        '.'
                    ) ?>

                </strong>

            </div>


        </div>


    </section>



    <!-- =================================================
         DAFTAR DENDA
    ================================================== -->

    <section class="denda-section">


        <div class="section-title">


            <div>


                <h2>

                    Daftar Denda

                </h2>


                <p>

                    Denda yang tampil hanya denda milik
                    akun kamu.

                </p>


            </div>


        </div>



        <?php if (empty($data_denda)): ?>


            <!-- =========================================
                 TIDAK ADA DENDA
            ========================================== -->

            <div class="empty-denda">


                <div class="empty-icon">

                    🎉

                </div>


                <h3>

                    Tidak Ada Denda

                </h3>


                <p>

                    Saat ini kamu tidak memiliki denda.

                </p>


                <a
                    href="/pinjam_buku/dashboard"
                    class="btn-primary"
                >

                    ← Kembali ke Dashboard

                </a>


            </div>


        <?php else: ?>


            <!-- =========================================
                 GRID DENDA
            ========================================== -->

            <div class="denda-grid">


                <?php foreach ($data_denda as $data): ?>


                    <article class="denda-card">


                        <!-- FOTO / ICON -->

                        <div class="denda-image">


                            <?php if (!empty($data->gambar)): ?>


                                <img
                                    src="<?= htmlspecialchars($data->gambar) ?>"
                                    alt="<?= htmlspecialchars($data->nama_buku) ?>"
                                >


                            <?php else: ?>


                                <div class="no-image">

                                    📚

                                </div>


                            <?php endif; ?>


                            <!-- STATUS -->

                            <?php if ($data->status_pembayaran === 'lunas'): ?>


                                <span class="badge badge-lunas">

                                    ✓ Lunas

                                </span>


                            <?php else: ?>


                                <span class="badge badge-belum">

                                    ⚠ Belum Lunas

                                </span>


                            <?php endif; ?>


                        </div>



                        <!-- INFORMASI -->

                        <div class="denda-content">


                            <!-- KATEGORI -->

                            <span class="kategori">

                                <?= htmlspecialchars(
                                    $data->nama_kategori
                                ) ?>

                            </span>



                            <!-- NAMA BUKU -->

                            <h3>

                                <?= htmlspecialchars(
                                    $data->nama_buku
                                ) ?>

                            </h3>



                            <!-- ID DENDA -->

                            <div class="info-row">

                                <span>

                                    ID Denda

                                </span>


                                <strong>

                                    #<?= (int) $data->id_denda ?>

                                </strong>

                            </div>



                            <!-- TANGGAL DENDA -->

                            <div class="info-row">

                                <span>

                                    Tanggal Denda

                                </span>


                                <strong>

                                    <?= htmlspecialchars(
                                        $data->tanggal_denda
                                    ) ?>

                                </strong>

                            </div>



                            <!-- KETERLAMBATAN -->

                            <?php if (
                                (int) $data->jumlah_hari_terlambat > 0
                            ): ?>


                                <div class="info-row">


                                    <span>

                                        Keterlambatan

                                    </span>


                                    <strong>

                                        <?= (int) $data->jumlah_hari_terlambat ?>

                                        hari

                                    </strong>


                                </div>


                            <?php endif; ?>



                            <!-- KETERANGAN -->

                            <div class="keterangan">


                                <span>

                                    Keterangan

                                </span>


                                <p>

                                    <?= htmlspecialchars(
                                        $data->keterangan
                                    ) ?>

                                </p>


                            </div>



                            <!-- HARGA DENDA -->

                            <div class="harga">


                                <span>

                                    Jumlah Denda

                                </span>


                                <strong>

                                    Rp <?= number_format(
                                        (float) $data->jumlah_denda,
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </strong>


                            </div>



                            <!-- =================================
                                 AKSI
                            ================================== -->

                            <?php if (
                                $data->status_pembayaran
                                === 'belum_lunas'
                            ): ?>


                                <a
                                    href="/pinjam_buku/denda/bayar?id_denda=<?= (int) $data->id_denda ?>"
                                    class="btn-bayar"
                                >

                                    💳 Bayar Denda

                                </a>


                            <?php else: ?>


                                <div class="sudah-lunas">


                                    ✅ Denda Sudah Lunas


                                    <?php if (
                                        !empty(
                                            $data->tanggal_pembayaran
                                        )
                                    ): ?>


                                        <small>

                                            Dibayar:

                                            <?= htmlspecialchars(
                                                $data->tanggal_pembayaran
                                            ) ?>

                                        </small>


                                    <?php endif; ?>


                                </div>


                            <?php endif; ?>


                        </div>


                    </article>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>


    </section>


</main>



<!-- =====================================================
     THEME JS
====================================================== -->

<script src="/pinjam_buku/asset/theme.js"></script>


</body>

</html>