<?php

session_start();


// =========================================================
// MODEL
// =========================================================

require_once "../models/m_denda.php";

$denda = new m_denda();


// Ambil aksi
$aksi = $_GET['aksi'] ?? '';


// =========================================================
// CEK ADMIN
// =========================================================

if (
    !isset($_SESSION['role'])
    ||
    $_SESSION['role'] != 'admin'
) {

    echo "<script>

            alert(
                'Anda tidak memiliki akses!'
            );

            window.location=
                '/pinjam_buku/';

          </script>";

    exit;
}


// =========================================================
// TAMBAH DENDA MANUAL
// =========================================================

if ($aksi == 'tambah') {


    $id_pinjam =
        $_POST['id_pinjam'] ?? '';


    $kategori =
        trim(
            $_POST['kategori'] ?? ''
        );


    $jumlah_denda =
        $_POST['jumlah_denda'] ?? '';


    $keterangan =
        trim(
            $_POST['keterangan'] ?? ''
        );


    // =====================================================
    // VALIDASI
    // =====================================================

    if (
        empty($id_pinjam)
        ||
        empty($kategori)
        ||
        empty($jumlah_denda)
    ) {

        echo "<script>

                alert(
                    'Data denda belum lengkap!'
                );

                history.back();

              </script>";

        exit;
    }


    // =====================================================
    // SESUAIKAN KATEGORI
    // =====================================================

    $kategori_database = '';


    if ($kategori == 'Rusak') {

        $kategori_database =
            'Buku Rusak';

    }

    elseif ($kategori == 'Hilang') {

        $kategori_database =
            'Buku Hilang';

    }

    elseif ($kategori == 'Buku Rusak') {

        $kategori_database =
            'Buku Rusak';

    }

    elseif ($kategori == 'Buku Hilang') {

        $kategori_database =
            'Buku Hilang';

    }

    else {

        echo "<script>

                alert(
                    'Kategori denda tidak valid!'
                );

                history.back();

              </script>";

        exit;
    }


    // =====================================================
    // BERSIHKAN NOMINAL
    // =====================================================

    $jumlah_denda =
        preg_replace(
            '/[^0-9]/',
            '',
            $jumlah_denda
        );


    $jumlah_denda =
        (float)$jumlah_denda;


    if ($jumlah_denda <= 0) {

        echo "<script>

                alert(
                    'Nominal denda harus lebih dari 0!'
                );

                history.back();

              </script>";

        exit;
    }


    // =====================================================
    // CARI KATEGORI
    // =====================================================

    $data_kategori =
        $denda->cari_kategori(
            $kategori_database
        );


    if (!$data_kategori) {

        echo "<script>

                alert(
                    'Kategori $kategori_database belum tersedia di database!'
                );

                history.back();

              </script>";

        exit;
    }


    // =====================================================
    // SIMPAN DENDA
    // =====================================================

    $hasil =
        $denda->tambah_denda(

            $id_pinjam,

            $data_kategori->id_kategori_denda,

            0,

            $jumlah_denda,

            $keterangan

        );


    // =====================================================
    // BERHASIL
    // =====================================================

    if ($hasil) {

        echo "<script>

                alert(
                    'Denda $kategori berhasil ditambahkan!\\n\\nStatus: Belum Lunas'
                );

                window.location=
                    '/pinjam_buku/admin/riwayat';

              </script>";

    }

    else {

        echo "<script>

                alert(
                    'Gagal menambahkan denda!'
                );

                history.back();

              </script>";
    }


    exit;
}


// =========================================================
// ADMIN BAYAR / TANDAI LUNAS
// =========================================================

if ($aksi == 'bayar') {


    $id_denda =
        $_GET['id_denda'] ?? '';


    if (empty($id_denda)) {

        echo "<script>

                alert(
                    'ID denda tidak ditemukan!'
                );

                history.back();

              </script>";

        exit;
    }


    $hasil =
        $denda->bayar_denda(
            $id_denda
        );


    if ($hasil) {

        echo "<script>

                alert(
                    'Denda berhasil ditandai sebagai lunas!'
                );

                window.location=
                    '/pinjam_buku/admin/riwayat';

              </script>";

    }

    else {

        echo "<script>

                alert(
                    'Denda belum dibayar atau gagal memperbarui status!'
                );

                history.back();

              </script>";
    }


    exit;
}

?>