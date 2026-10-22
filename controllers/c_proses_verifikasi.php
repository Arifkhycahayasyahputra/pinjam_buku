<?php

// =========================================================
// SESSION
// =========================================================

session_start();


// =========================================================
// CEK ADMIN
// =========================================================

if (
    !isset($_SESSION['role'])
    ||
    $_SESSION['role'] !== 'admin'
) {

    header(
        "Location: /pinjam_buku/"
    );

    exit;
}


// =========================================================
// MODEL
// =========================================================

include "../models/m_pinjam.php";
include "../models/m_buku.php";


$pinjam =
    new m_pinjam();


$buku =
    new m_buku();


// =========================================================
// AMBIL DATA
// =========================================================

$id_pinjam =
    $_POST['id_pinjam'] ?? '';


$tanggal_kembali =
    $_POST['tanggal_kembali'] ?? '';


// =========================================================
// DATA PINJAMAN
// =========================================================

$data_pinjam =
    $pinjam->tampil_pinjam_by_id(
        $id_pinjam
    );


if (!$data_pinjam) {

    echo "<script>

            alert(
                'Data pinjaman tidak ditemukan'
            );

            window.location=
                '/pinjam_buku/admin/pengajuan';

          </script>";

    exit;
}


// =========================================================
// DATA BUKU
// =========================================================

$kode_buku =
    $data_pinjam->kode_buku;


$jumlah_pinjam =
    (int)$data_pinjam->jumlah_pinjam;


$data_buku =
    $buku->tampil_data_by_kode(
        $kode_buku
    );


if (!$data_buku) {

    echo "<script>

            alert(
                'Data buku tidak ditemukan'
            );

            window.location=
                '/pinjam_buku/admin/pengajuan';

          </script>";

    exit;
}


// =========================================================
// UPDATE STOK
// =========================================================

$stok_baru =
    (int)$data_buku->stok
    -
    $jumlah_pinjam;


if ($stok_baru < 0) {

    echo "<script>

            alert(
                'Stok tidak mencukupi untuk diverifikasi!'
            );

            history.back();

          </script>";

    exit;
}


$buku->update_stok(

    $kode_buku,

    $stok_baru

);


// =========================================================
// VERIFIKASI
// =========================================================

$pinjam->verifikasi_pinjam(

    $id_pinjam,

    $tanggal_kembali

);


// =========================================================
// SELESAI
// =========================================================

echo "<script>

        alert(
            'Peminjaman berhasil diverifikasi'
        );

        window.location=
            '/pinjam_buku/admin/pengajuan';

      </script>";

?>