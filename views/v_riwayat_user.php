<?php

session_start();

require_once "../models/m_riwayat.php";
require_once "../models/m_pinjam.php";


// =====================================================
// CEK LOGIN
// =====================================================

if (!isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit;
}


$riwayat = new m_riwayat();
$pinjam  = new m_pinjam();

$data_riwayat = $riwayat->tampil_data();

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Riwayat Peminjaman</title>


<link
    rel="stylesheet"
    href="/pinjam_buku/asset/v_riwayatuser.css?v=3"
>

</head>


<body>


<div class="container">


<!-- =====================================================
     HEADER
====================================================== -->

<div class="header">


    <h2>
        📖 Riwayat Peminjaman Buku
    </h2>


    <p>
        Semua data aktivitas peminjaman & pengembalian buku
    </p>


    <div class="menu">


        <!-- KEMBALI DASHBOARD -->

        <a
            href="/pinjam_buku/dashboard"
            class="btn dashboard"
        >

            🏠 Kembali ke Dashboard

        </a>


        <!-- BUTTON TEMA -->

        <button
            type="button"
            id="theme-toggle"
            class="btn theme-toggle"
            aria-label="Ganti tema"
            title="Ganti tema"
        >
            🌙
        </button>


    </div>


</div>



<!-- =====================================================
     TABLE
====================================================== -->

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

</tr>

</thead>



<tbody>


<?php if (!empty($data_riwayat)): ?>


<?php $no = 1; ?>


<?php foreach ($data_riwayat as $row): ?>


<?php

/* =====================================================
   DATA PEMINJAMAN
===================================================== */

$kode_buku = (int)$row->kode_buku;

$id_pengguna = (int)$_SESSION['id_pengguna'];


$tanggal_pinjam = mysqli_real_escape_string(
    $pinjam->koneksi,
    $row->tanggal_peminjaman
);



/* =====================================================
   CARI TOTAL DENDA
===================================================== */

$sql_denda = "

    SELECT

        p.id_pinjam,

        COALESCE(
            SUM(d.jumlah_denda),
            0
        ) AS total_denda,

        COUNT(d.id_denda) AS jumlah_denda,

        SUM(
            CASE
                WHEN d.status_pembayaran = 'belum_lunas'
                THEN 1
                ELSE 0
            END
        ) AS belum_lunas

    FROM pinjam p

    LEFT JOIN denda d
        ON p.id_pinjam = d.id_pinjam

    WHERE p.kode_buku = '$kode_buku'

    AND p.id_pengguna = '$id_pengguna'

    AND p.tanggal_pinjam = '$tanggal_pinjam'

    GROUP BY p.id_pinjam

    ORDER BY p.id_pinjam DESC

    LIMIT 1

";


$q_denda = mysqli_query(
    $pinjam->koneksi,
    $sql_denda
);



/* =====================================================
   DEFAULT
===================================================== */

$total_denda = 0;

$status_denda = 'Tidak ada denda';



/* =====================================================
   AMBIL HASIL DENDA
===================================================== */

if ($q_denda) {

    $data_denda = mysqli_fetch_object($q_denda);


    if ($data_denda) {

        $total_denda = (float)$data_denda->total_denda;


        if ($total_denda > 0) {

            if ((int)$data_denda->belum_lunas > 0) {

                $status_denda = 'belum_lunas';

            } else {

                $status_denda = 'lunas';

            }

        }

    }

}

?>


<tr>


    <!-- =================================================
         NO
    ================================================== -->

    <td>

        <?= $no++ ?>

    </td>



    <!-- =================================================
         NAMA BUKU
    ================================================== -->

    <td>

        <?= htmlspecialchars(
            $row->nama_buku
        ) ?>

    </td>



    <!-- =================================================
         NAMA PEMINJAM
    ================================================== -->

    <td>

        <?= htmlspecialchars(
            $row->nama_peminjam
        ) ?>

    </td>



    <!-- =================================================
         TANGGAL PINJAM
    ================================================== -->

    <td>

        <?= htmlspecialchars(
            $row->tanggal_peminjaman
        ) ?>

    </td>



    <!-- =================================================
         TANGGAL KEMBALI
    ================================================== -->

    <td>

        <?= htmlspecialchars(
            $row->tanggal_pengembalian
        ) ?>

    </td>



    <!-- =================================================
         JUMLAH
    ================================================== -->

    <td>

        <?= htmlspecialchars(
            $row->jumlah_pinjam
        ) ?>

    </td>



    <!-- =================================================
         DENDA
    ================================================== -->

    <td>

        <?php if ($total_denda > 0): ?>

            <strong>

                Rp
                <?= number_format(
                    $total_denda,
                    0,
                    ',',
                    '.'
                ) ?>

            </strong>

        <?php else: ?>

            Rp 0

        <?php endif; ?>

    </td>



    <!-- =================================================
         STATUS DENDA
    ================================================== -->

    <td>


        <?php if ($status_denda === 'belum_lunas'): ?>


            <span class="status-denda belum-lunas">

                Belum Lunas

            </span>


        <?php elseif ($status_denda === 'lunas'): ?>


            <span class="status-denda lunas">

                Lunas

            </span>


        <?php else: ?>


            <span class="status-denda tidak-ada">

                Tidak Ada Denda

            </span>


        <?php endif; ?>


    </td>


</tr>


<?php endforeach; ?>


<?php else: ?>


<tr>

    <td
        colspan="8"
        class="empty"
    >

        Belum ada riwayat peminjaman

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

    © <?= date('Y'); ?> Sistem Perpustakaan Digital

</div>


</div>



<!-- =====================================================
     THEME GLOBAL
====================================================== -->

<script src="/pinjam_buku/asset/theme.js"></script>


</body>

</html>