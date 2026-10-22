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

require_once "../models/m_buku.php";

$buku = new m_buku();
$data_buku = $buku->tampil_data();

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manajemen Buku | Perpustakaan</title>

    <link
        rel="stylesheet"
        href="/pinjam_buku/asset/admin_buku.css?v=3"
    >

</head>


<body>


<div class="container">


    <!-- =====================================================
         NAVBAR / HEADER
    ====================================================== -->

    <div class="navbar">


        <!-- JUDUL -->

        <div>

            <h2>
                📚 Manajemen Buku
            </h2>

            <p>
                Kelola data buku sistem perpustakaan
            </p>

        </div>



        <!-- =================================================
             MENU NAVBAR
        ================================================== -->

        <div class="nav-menu">


            <!-- KEMBALI KE DASHBOARD -->

            <a
                href="/pinjam_buku/admin"
                class="btn btn-user"
            >
                🏠 Kembali Ke Dashboard
            </a>



            <!-- TAMBAH BUKU -->

            <a
                href="/pinjam_buku/admin/buku/tambah"
                class="btn btn-tambah"
            >
                + Tambah Buku
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
         TABLE DATA BUKU
    ====================================================== -->

    <div class="table-box">


        <table>


            <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        Cover
                    </th>

                    <th>
                        Nama Buku
                    </th>

                    <th>
                        Pencipta
                    </th>

                    <th>
                        Tanggal Rilis
                    </th>

                    <th>
                        Stok
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>



            <tbody>


            <?php if (!empty($data_buku)): ?>


                <?php $no = 1; ?>

                <?php foreach ($data_buku as $row): ?>


                <tr>


                    <!-- NOMOR -->

                    <td>

                        <?= $no++ ?>

                    </td>



                    <!-- COVER -->

                    <td>

                        <?php if (!empty($row->gambar)): ?>

                            <img
                                src="<?= htmlspecialchars($row->gambar) ?>"
                                width="80"
                                alt="Cover Buku"
                            >

                        <?php else: ?>

                            -

                        <?php endif; ?>

                    </td>



                    <!-- NAMA BUKU -->

                    <td>

                        <?= htmlspecialchars(
                            $row->nama_buku
                        ) ?>

                    </td>



                    <!-- PENCIPTA -->

                    <td>

                        <?= htmlspecialchars(
                            $row->pencipta
                        ) ?>

                    </td>



                    <!-- TANGGAL RILIS -->

                    <td>

                        <?= date(
                            'd-m-Y',
                            strtotime($row->tanggal_rilis)
                        ) ?>

                    </td>



                    <!-- STOK -->

                    <td>

                        <?php if ($row->stok > 0): ?>

                            <span
                                style="
                                    color: green;
                                    font-weight: bold;
                                "
                            >

                                <?= $row->stok ?>

                            </span>

                        <?php else: ?>

                            <span
                                style="
                                    color: red;
                                    font-weight: bold;
                                "
                            >

                                Habis

                            </span>

                        <?php endif; ?>

                    </td>



                    <!-- AKSI -->

                    <td>


                        <!-- EDIT -->

                        <a
                            class="btn btn-edit"
                            href="../controllers/c_buku.php?aksi=edit&kode_buku=<?= $row->kode_buku ?>"
                        >
                            Edit
                        </a>



                        <!-- HAPUS -->

                        <a
                            class="btn btn-hapus"
                            onclick="return confirm('Yakin hapus buku ini?')"
                            href="../controllers/c_buku.php?aksi=hapus&kode_buku=<?= $row->kode_buku ?>"
                        >
                            Hapus
                        </a>


                    </td>


                </tr>


                <?php endforeach; ?>


            <?php else: ?>


                <tr>

                    <td
                        colspan="7"
                        style="text-align:center;"
                    >

                        Data buku belum ada

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