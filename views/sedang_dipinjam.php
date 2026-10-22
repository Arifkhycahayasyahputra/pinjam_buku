<?php

include "../models/m_pinjam.php";

$pinjam = new m_pinjam();

$data_pinjam = $pinjam->tampil_buku_dipinjam();

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Buku Dipinjam</title>


    <link
        rel="stylesheet"
        href="/pinjam_buku/asset/dipinjam.css?v=3"
    >

</head>


<body>


<div class="container">


    <!-- =================================================
         HEADER
    ================================================== -->

    <div class="header">


        <!-- BAGIAN KIRI -->

        <div class="header-content">


            <h2>
                📚 Buku Sedang Dipinjam
            </h2>


            <p>
                Daftar buku yang saat ini masih dalam proses
                peminjaman.
            </p>


        </div>



        <!-- BAGIAN KANAN -->

        <div class="header-actions">


            <!-- KEMBALI DASHBOARD -->

            <a
                href="/pinjam_buku/dashboard"
                class="back-btn"
            >

                🏠 Kembali ke Dashboard

            </a>



            <!-- BUTTON TEMA -->

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



    <!-- =================================================
         TABLE
    ================================================== -->

    <div class="table-box">


        <table>


            <thead>

                <tr>

                    <th>No</th>

                    <th>Nama Buku</th>

                    <th>Nama Peminjam</th>

                    <th>Tanggal Pinjam</th>

                    <th>Batas Kembali</th>

                    <th>Jumlah</th>

                    <th>Denda/Hari</th>

                    <th>Status</th>

                    <th>Aksi</th>

                </tr>

            </thead>



            <tbody>


            <?php if (!empty($data_pinjam)): ?>


                <?php

                $no = 1;

                foreach ($data_pinjam as $row):

                ?>


                <tr>


                    <!-- NO -->

                    <td>

                        <?= $no++ ?>

                    </td>



                    <!-- NAMA BUKU -->

                    <td>

                        <?= htmlspecialchars(
                            $row->nama_buku
                        ) ?>

                    </td>



                    <!-- NAMA PEMINJAM -->

                    <td>

                        <?= htmlspecialchars(
                            $row->nama_pengguna
                        ) ?>

                    </td>



                    <!-- TANGGAL PINJAM -->

                    <td>

                        <?= htmlspecialchars(
                            $row->tanggal_pinjam
                        ) ?>

                    </td>



                    <!-- BATAS KEMBALI -->

                    <td>

                        <?= htmlspecialchars(
                            $row->tanggal_kembali
                        ) ?>

                    </td>



                    <!-- JUMLAH -->

                    <td>

                        <?= htmlspecialchars(
                            $row->jumlah_pinjam
                        ) ?>

                    </td>



                    <!-- DENDA PER HARI -->

                    <td>

                        <?= htmlspecialchars(
                            $row->denda_per_hari
                        ) ?>

                        / hari

                    </td>



                    <!-- STATUS -->

                    <td>


                        <span
                            class="status
                            <?= ($row->status == 'dipinjam')
                                ? 'pinjam'
                                : 'kembali'
                            ?>"
                        >

                            <?= ucfirst(
                                htmlspecialchars(
                                    $row->status
                                )
                            ) ?>

                        </span>


                    </td>



                    <!-- AKSI -->

                    <td>


                        <a
                            class="btn-kembali"
                            href="/pinjam_buku/controllers/c_kembalikan.php?id_pinjam=<?= urlencode($row->id_pinjam) ?>"
                        >

                            🔄 Kembalikan

                        </a>


                    </td>


                </tr>


                <?php endforeach; ?>


            <?php else: ?>


                <tr>


                    <td
                        colspan="9"
                        class="empty"
                    >

                        Tidak ada buku yang sedang dipinjam

                    </td>


                </tr>


            <?php endif; ?>


            </tbody>


        </table>


    </div>


</div>



<!-- =====================================================
     GLOBAL THEME
====================================================== -->

<script src="/pinjam_buku/asset/theme.js"></script>


</body>

</html>