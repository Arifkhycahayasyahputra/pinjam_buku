<?php

session_start();


/*
==========================================================
CEK LOGIN
==========================================================
*/

if (!isset($_SESSION['role'])) {

    header(
        "Location: ../index.php"
    );

    exit;
}


/*
==========================================================
HALAMAN INI KHUSUS ADMIN
==========================================================
*/

if ($_SESSION['role'] !== 'admin') {

    header(
        "Location: v_dasbord_user.php"
    );

    exit;
}


/*
==========================================================
LOAD MODEL
==========================================================
*/

require_once "../models/m_riwayat.php";
require_once "../models/m_pinjam.php";
require_once "../models/m_denda.php";


$riwayat = new m_riwayat();

$pinjam = new m_pinjam();

$denda = new m_denda();


/*
==========================================================
AMBIL DATA RIWAYAT
==========================================================
*/

$data_riwayat =
    $riwayat->tampil_data();

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Riwayat Peminjaman</title>


<link
    rel="stylesheet"
    href="/pinjam_buku/asset/riwayat_peminjaman.css?v=3"
>


<style>



</style>

</head>


<body>


<div class="container">


<!--
==========================================================
HEADER
==========================================================
-->

<div class="header">

    <h2>
        📖 Riwayat Peminjaman Buku
    </h2>

    <p>
        Semua data aktivitas peminjaman & pengembalian buku
    </p>


    <div class="menu">


        <!-- KEMBALI KE DASHBOARD -->

        <a
            href="/pinjam_buku/admin"
            class="btn dashboard"
        >

            🏠 Kembali ke Dashboard

        </a>


        <!-- TOMBOL LIGHT / DARK MODE -->

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


<!--
==========================================================
TABLE
==========================================================
-->

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

    <th>Denda</th>

    <th>Status Denda</th>

    <th>Aksi</th>

</tr>

</thead>


<tbody>


<?php if (!empty($data_riwayat)): ?>


<?php

$no = 1;


foreach ($data_riwayat as $row):


/*
==========================================================
CARI ID PINJAM
==========================================================
*/

$kode_buku =
    mysqli_real_escape_string(
        $pinjam->koneksi,
        $row->kode_buku
    );


$tanggal_pinjam =
    mysqli_real_escape_string(
        $pinjam->koneksi,
        $row->tanggal_peminjaman
    );


$sql_pinjam = "

    SELECT
        id_pinjam

    FROM pinjam

    WHERE kode_buku='$kode_buku'

    AND tanggal_pinjam='$tanggal_pinjam'

    ORDER BY id_pinjam DESC

    LIMIT 1

";


$q_pinjam = mysqli_query(
    $pinjam->koneksi,
    $sql_pinjam
);


$data_id_pinjam = false;


if ($q_pinjam) {

    $data_id_pinjam =
        mysqli_fetch_object(
            $q_pinjam
        );

}


$id_pinjam =

    $data_id_pinjam

        ? (int) $data_id_pinjam->id_pinjam

        : 0;


/*
==========================================================
AMBIL DATA DENDA
==========================================================
*/

$data_denda = [];

$total_denda = 0;

$ada_belum_lunas = false;


if ($id_pinjam > 0) {


    /*
    ------------------------------------------------------
    AMBIL SEMUA DENDA PADA PEMINJAMAN INI
    ------------------------------------------------------
    */

    $data_denda =

        $denda->tampil_by_pinjam(
            $id_pinjam
        );


    /*
    ------------------------------------------------------
    HITUNG TOTAL DENDA
    ------------------------------------------------------
    */

    $total_denda =

        $denda->total_denda(
            $id_pinjam
        );


    /*
    ------------------------------------------------------
    CEK STATUS DENDA
    ------------------------------------------------------
    */

    foreach ($data_denda as $item) {


        if (
            $item->status_pembayaran
            === 'belum_lunas'
        ) {

            $ada_belum_lunas = true;

            break;

        }

    }

}

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
        $row->nama_peminjam
    ) ?>

</td>


<!-- TANGGAL PINJAM -->

<td>

    <?= htmlspecialchars(
        $row->tanggal_peminjaman
    ) ?>

</td>


<!-- TANGGAL KEMBALI -->

<td>

    <?= htmlspecialchars(
        $row->tanggal_pengembalian
    ) ?>

</td>


<!-- JUMLAH -->

<td>

    <?= htmlspecialchars(
        $row->jumlah_pinjam
    ) ?>

</td>


<!-- DENDA -->

<td>


<?php if (!empty($data_denda)): ?>


    <?php foreach ($data_denda as $item): ?>


        <div class="denda-item">

            <strong>

                <?= htmlspecialchars(
                    $item->nama_kategori
                ) ?>

            </strong>

            :

            Rp

            <?= number_format(
                (float) $item->jumlah_denda,
                0,
                ',',
                '.'
            ) ?>

        </div>


    <?php endforeach; ?>


    <hr>


    <strong>

        Total:

        Rp

        <?= number_format(
            (float) $total_denda,
            0,
            ',',
            '.'
        ) ?>

    </strong>


<?php else: ?>


    Rp 0


<?php endif; ?>


</td>


<!-- STATUS DENDA -->

<td>


<?php if ($ada_belum_lunas): ?>


    <span class="status-belum">

        Belum Lunas

    </span>


<?php elseif (!empty($data_denda)): ?>


    <span class="status-lunas">

        Lunas

    </span>


<?php else: ?>


    <span class="status-tidak-ada">

        Tidak Ada Denda

    </span>


<?php endif; ?>


</td>


<!-- AKSI -->

<td>


<?php if ($id_pinjam > 0): ?>


    <!-- TAMBAH DENDA -->

    <a
        href="/pinjam_buku/admin/denda?id_pinjam=<?= $id_pinjam ?>"
        class="btn-denda"
    >

        + Denda

    </a>


    <br>


    <!-- TOMBOL BAYAR DENDA ADMIN -->

    <?php foreach ($data_denda as $item): ?>


        <?php

        if (
            $item->status_pembayaran
            === 'belum_lunas'
        ):

        ?>


            <a
                href="../controllers/c_denda.php?aksi=bayar&id_denda=<?= (int) $item->id_denda ?>"
                class="btn-bayar"

                onclick="
                    return confirm(
                        'Tandai denda ini sebagai lunas?'
                    )
                "
            >

                💵 Bayar

                <?= htmlspecialchars(
                    $item->nama_kategori
                ) ?>

            </a>


        <?php endif; ?>


    <?php endforeach; ?>


<?php endif; ?>


<!-- HAPUS RIWAYAT -->

<a
    href="../controllers/c_riwayat.php?aksi=hapus&id_riwayat=<?= (int) $row->id_riwayat ?>"

    onclick="
        return confirm(
            'Yakin ingin menghapus riwayat ini?'
        )
    "

    style="
        display:inline-block;
        background:red;
        color:white;
        padding:6px 10px;
        border-radius:5px;
        text-decoration:none;
        margin-top:5px;
    "
>

    Hapus

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

        Belum ada riwayat peminjaman

    </td>

</tr>


<?php endif; ?>


</tbody>

</table>

</div>


<!--
==========================================================
FOOTER
==========================================================
-->

<div class="footer">

    © <?= date('Y'); ?>
    Sistem Perpustakaan Digital

</div>


</div>


<!-- =====================================================
     GLOBAL THEME
====================================================== -->

<script src="/pinjam_buku/asset/theme.js"></script>


</body>

</html>