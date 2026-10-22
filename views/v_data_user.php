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

require_once "../models/m_pengguna.php";

$pengguna = new m_pengguna();
$data_pengguna = $pengguna->tampil_data();

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Data Pengguna | Admin</title>

    <link
        rel="stylesheet"
        href="/pinjam_buku/asset/data_user.css?v=3"
    >

</head>


<body>


<div class="container">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="top-bar">

        <h2>
            📚 Manajemen Data Pengguna
        </h2>

        <p>
            Kelola seluruh data pengguna sistem perpustakaan
        </p>


        <!-- =================================================
             MENU
        ================================================== -->

        <div class="menu">


            <!-- KEMBALI KE DASHBOARD -->

            <div class="btn-group">

                <a
                    href="/pinjam_buku/admin"
                    class="btn dashboard"
                >
                    🏠 Kembali ke Dashboard
                </a>

            </div>



            <!-- TAMBAH PENGGUNA -->

            <div class="btn-group">

                <a
                    href="/pinjam_buku/admin/user/tambah?aksi=tambah"
                    class="btn tambah"
                >
                    + Tambah
                </a>

            </div>



            <!-- =================================================
                 TOMBOL LIGHT / DARK MODE
            ================================================== -->

            <div class="btn-group">

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

    </div>



    <!-- =====================================================
         TABLE DATA PENGGUNA
    ====================================================== -->

    <div class="table-box">


        <table>


            <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        Nama
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Password
                    </th>

                    <th>
                        Tanggal Lahir
                    </th>

                    <th>
                        Role
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>



            <tbody>


                <?php if (!empty($data_pengguna)) : ?>


                    <?php $no = 1; ?>


                    <?php foreach ($data_pengguna as $row) : ?>


                        <tr>


                            <!-- NOMOR -->

                            <td>
                                <?= $no++; ?>
                            </td>



                            <!-- NAMA -->

                            <td>
                                <?= htmlspecialchars(
                                    $row->nama_pengguna
                                ); ?>
                            </td>



                            <!-- EMAIL -->

                            <td>
                                <?= htmlspecialchars(
                                    $row->email
                                ); ?>
                            </td>



                            <!-- PASSWORD -->

                            <td
                                style="
                                    font-size:11px;
                                    max-width:220px;
                                    word-break:break-all;
                                "
                            >
                                <?= htmlspecialchars(
                                    $row->password
                                ); ?>
                            </td>



                            <!-- TANGGAL LAHIR -->

                            <td>

                                <?= !empty(
                                    $row->tanggal_lahir_pengguna
                                )
                                    ? date(
                                        'd-m-Y',
                                        strtotime(
                                            $row->tanggal_lahir_pengguna
                                        )
                                    )
                                    : '-';
                                ?>

                            </td>



                            <!-- ROLE -->

                            <td>
                                <?= ucfirst(
                                    $row->role
                                ); ?>
                            </td>



                            <!-- AKSI -->

                            <td class="aksi">


                                <!-- EDIT -->

                                <a
                                    href="../controllers/c_pengguna.php?aksi=edit&id=<?= $row->id_pengguna; ?>"
                                    class="edit"
                                >
                                    Edit
                                </a>



                                <!-- HAPUS -->

                                <a
                                    href="../controllers/c_pengguna.php?aksi=hapus&id=<?= $row->id_pengguna; ?>"
                                    class="hapus"
                                    onclick="return confirm('Yakin ingin menghapus pengguna ini?');"
                                >
                                    Hapus
                                </a>


                            </td>


                        </tr>


                    <?php endforeach; ?>


                <?php else : ?>


                    <tr>

                        <td colspan="7">

                            Data pengguna belum ada

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