<?php

session_start();


// =========================================================
// MODEL
// =========================================================

include "../models/m_denda.php";

$denda = new m_denda();


// =========================================================
// CEK LOGIN
// =========================================================

if (!isset($_SESSION['role'])) {

    header(
        "Location: /pinjam_buku/"
    );

    exit;
}


// =========================================================
// HANYA USER
// =========================================================

if ($_SESSION['role'] !== 'user') {

    header(
        "Location: /pinjam_buku/admin"
    );

    exit;
}


// =========================================================
// CEK ID USER
// =========================================================

$id_pengguna =
    $_SESSION['id_pengguna'] ?? 0;


$id_pengguna =
    (int)$id_pengguna;


if ($id_pengguna <= 0) {

    echo "<script>

            alert(
                'Session pengguna tidak ditemukan. Silakan login kembali.'
            );

            window.location='/pinjam_buku/';

          </script>";

    exit;
}


// =========================================================
// PROSES BAYAR
// =========================================================

if (isset($_POST['bayar_denda'])) {


    $id_denda =
        $_POST['id_denda'] ?? 0;


    $id_denda =
        (int)$id_denda;


    if ($id_denda <= 0) {

        echo "<script>

                alert(
                    'Denda tidak valid.'
                );

                window.location=
                    '/pinjam_buku/denda';

              </script>";

        exit;
    }


    // =====================================================
    // BAYAR DENDA
    // =====================================================

    $hasil =
        $denda->bayar_denda_user(

            $id_denda,

            $id_pengguna

        );


    // =====================================================
    // BERHASIL
    // =====================================================

    if ($hasil) {

        echo "<script>

                alert(
                    'Pembayaran denda berhasil dikonfirmasi.'
                );

                window.location=
                    '/pinjam_buku/denda';

              </script>";

    }


    // =====================================================
    // GAGAL
    // =====================================================

    else {

        echo "<script>

                alert(
                    'Denda tidak dapat dibayar. Pastikan denda tersebut milik akun kamu dan masih belum lunas.'
                );

                window.location=
                    '/pinjam_buku/denda';

              </script>";
    }


    exit;
}


// =========================================================
// AKSI TIDAK VALID
// =========================================================

header(
    "Location: /pinjam_buku/denda"
);

exit;

?>