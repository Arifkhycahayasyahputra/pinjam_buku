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

require_once "../models/m_riwayat.php";


$riwayat =
    new m_riwayat();


// =========================================================
// AKSI
// =========================================================

$aksi =
    $_GET['aksi'] ?? '';


// =========================================================
// HAPUS RIWAYAT
// =========================================================

if (
    $aksi == "hapus"
    &&
    isset($_GET['id_riwayat'])
) {


    $id_riwayat =
        $_GET['id_riwayat'];


    // Validasi
    if (empty($id_riwayat)) {

        echo "<script>

                alert(
                    'ID tidak valid'
                );

                history.back();

              </script>";

        exit;
    }


    // Hapus
    $hapus =
        $riwayat->hapus_data(
            $id_riwayat
        );


    if ($hapus) {

        echo "<script>

                alert(
                    'Riwayat berhasil dihapus'
                );

                window.location=
                    '/pinjam_buku/admin/riwayat';

              </script>";

    }

    else {

        echo "<script>

                alert(
                    'Gagal menghapus riwayat'
                );

                window.location=
                    '/pinjam_buku/admin/riwayat';

              </script>";
    }


    exit;
}


// =========================================================
// DATA RIWAYAT
// =========================================================

$data_riwayat =
    $riwayat->tampil_data();

?>