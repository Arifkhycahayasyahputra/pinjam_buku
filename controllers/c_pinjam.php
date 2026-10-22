<?php

// Mulai session
session_start();


// =========================================================
// Panggil model
// =========================================================

require_once "../models/m_buku.php";
require_once "../models/m_pinjam.php";


// Buat object
$buku   = new m_buku();
$pinjam = new m_pinjam();


// =========================================================
// AMBIL AKSI
// =========================================================

$aksi = $_GET['aksi'] ?? '';


// =========================================================
// PROSES PINJAM
// =========================================================

if ($aksi == "pinjam") {


    // =====================================================
    // AMBIL DATA FORM
    // =====================================================

    $kode_buku     = $_POST['kode_buku'] ?? '';
    $id_pengguna   = $_POST['id_pengguna'] ?? '';
    $tgl_pinjam    = $_POST['tanggal_pinjam'] ?? '';
    $jumlah_pinjam = $_POST['jumlah_pinjam'] ?? 0;


    // Ubah jumlah ke integer
    $jumlah_pinjam = (int)$jumlah_pinjam;


    // =====================================================
    // AMBIL DATA BUKU
    // =====================================================

    $data_buku =
        $buku->tampil_data_by_kode(
            $kode_buku
        );


    // =====================================================
    // CEK BUKU
    // =====================================================

    if (!$data_buku) {

        echo "<script>

                alert('Buku tidak ditemukan.');

                window.location='/pinjam_buku/buku';

              </script>";

        exit;
    }


    // =====================================================
    // STOK
    // =====================================================

    $stok_lama =
        (int)$data_buku->stok;


    // =====================================================
    // VALIDASI JUMLAH
    // =====================================================

    if ($jumlah_pinjam <= 0) {

        echo "<script>

                alert('Jumlah pinjaman tidak valid.');

                history.back();

              </script>";

        exit;
    }


    // =====================================================
    // VALIDASI STOK
    // =====================================================

    if ($jumlah_pinjam > $stok_lama) {

        echo "<script>

                alert('Stok tidak cukup.');

                history.back();

              </script>";

        exit;
    }


    // =====================================================
    // TARIF DENDA
    // =====================================================

    $tarif_denda =
        $data_buku->denda_per_hari
        ?? 'Rp 0';


    // =====================================================
    // REQUEST PEMINJAMAN
    // =====================================================

    $hasil =
        $pinjam->request_pinjam(

            $kode_buku,

            $id_pengguna,

            $tgl_pinjam,

            $jumlah_pinjam

        );


    // =====================================================
    // BERHASIL
    // =====================================================

    if ($hasil) {

        echo "<script>

                alert(
                    'Pengajuan peminjaman berhasil!\\n\\n' +

                    'Denda keterlambatan: " .
                    addslashes($tarif_denda) .
                    " per hari per buku.\\n\\n' +

                    'Menunggu verifikasi admin.'
                );

                window.location='/pinjam_buku/dashboard';

              </script>";

        exit;

    }


    // =====================================================
    // GAGAL
    // =====================================================

    else {

        echo "<script>

                alert(
                    'Gagal mengajukan peminjaman'
                );

                history.back();

              </script>";

        exit;
    }

}

?>