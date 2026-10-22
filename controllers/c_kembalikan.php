<?php

session_start();


// =========================================================
// MODEL
// =========================================================

require_once "../models/m_pinjam.php";
require_once "../models/m_buku.php";
require_once "../models/m_riwayat.php";
require_once "../models/m_denda.php";


$pinjam  = new m_pinjam();
$buku    = new m_buku();
$riwayat = new m_riwayat();
$denda   = new m_denda();


// =========================================================
// AMBIL ID PEMINJAMAN
// =========================================================

$id_pinjam =
    $_GET['id_pinjam'] ?? '';


if (empty($id_pinjam)) {

    echo "<script>

            alert(
                'ID peminjaman tidak ditemukan!'
            );

            window.location=
                '/pinjam_buku/dipinjam';

          </script>";

    exit;
}


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
                'Data tidak ditemukan'
            );

            window.location=
                '/pinjam_buku/dipinjam';

          </script>";

    exit;
}


// =========================================================
// CEK HAK USER
// =========================================================

if (
    !isset($_SESSION['id_pengguna'])
    ||
    $_SESSION['id_pengguna']
    !=
    $data_pinjam->id_pengguna
) {

    echo "<script>

            alert(
                'Anda tidak berhak mengembalikan buku ini!'
            );

            window.location=
                '/pinjam_buku/dipinjam';

          </script>";

    exit;
}


// =========================================================
// DATA PEMINJAMAN
// =========================================================

$kode_buku =
    $data_pinjam->kode_buku;


$jumlah_pinjam =
    (int)$data_pinjam->jumlah_pinjam;


// =========================================================
// DATA BUKU
// =========================================================

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
                '/pinjam_buku/dipinjam';

          </script>";

    exit;
}


// =========================================================
// HITUNG DENDA TERLAMBAT
// =========================================================

$denda_terlambat = 0;

$hari_terlambat = 0;


if (
    !empty($data_pinjam->tanggal_kembali)
) {

    $tanggal_hari_ini =
        new DateTime(
            date("Y-m-d")
        );


    $tanggal_batas =
        new DateTime(
            $data_pinjam->tanggal_kembali
        );


    if (
        $tanggal_hari_ini
        >
        $tanggal_batas
    ) {

        $selisih =
            $tanggal_batas->diff(
                $tanggal_hari_ini
            );


        $hari_terlambat =
            $selisih->days;


        // Ambil tarif
        $tarif_denda =
            preg_replace(
                '/[^0-9]/',
                '',
                $data_buku->denda_per_hari
            );


        $tarif_denda =
            (int)$tarif_denda;


        // Hitung denda
        $denda_terlambat =
            $hari_terlambat
            *
            $tarif_denda;
    }
}


// =========================================================
// SIMPAN DENDA TERLAMBAT
// =========================================================

if ($denda_terlambat > 0) {


    $kategori =
        $denda->cari_kategori(
            "Terlambat"
        );


    if ($kategori) {


        $sudah_ada =
            $denda->cek_denda_terlambat(
                $id_pinjam
            );


        if (!$sudah_ada) {


            $hasil_denda =
                $denda->tambah_denda(

                    $id_pinjam,

                    $kategori->id_kategori_denda,

                    $hari_terlambat,

                    $denda_terlambat,

                    "Denda keterlambatan pengembalian buku"

                );


            if (!$hasil_denda) {

                echo "<script>

                        alert(
                            'Gagal menyimpan denda keterlambatan'
                        );

                        window.location=
                            '/pinjam_buku/dipinjam';

                      </script>";

                exit;
            }
        }
    }
}


// =========================================================
// UPDATE STOK
// =========================================================

$stok_baru =
    (int)$data_buku->stok
    +
    $jumlah_pinjam;


$hasil_stok =
    $buku->update_stok(

        $kode_buku,

        $stok_baru

    );


if (!$hasil_stok) {

    echo "<script>

            alert(
                'Gagal memperbarui stok buku'
            );

            window.location=
                '/pinjam_buku/dipinjam';

          </script>";

    exit;
}


// =========================================================
// UBAH STATUS
// =========================================================

$hasil_kembali =
    $pinjam->kembalikan_buku(
        $id_pinjam
    );


if (!$hasil_kembali) {

    echo "<script>

            alert(
                'Gagal menyimpan data pengembalian'
            );

            window.location=
                '/pinjam_buku/dipinjam';

          </script>";

    exit;
}


// =========================================================
// SIMPAN RIWAYAT
// =========================================================

$riwayat->tambah_data(

    $data_buku->nama_buku,

    $_SESSION['nama_pengguna'],

    $data_pinjam->tanggal_pinjam,

    date("Y-m-d"),

    $kode_buku,

    $jumlah_pinjam

);


// =========================================================
// PESAN
// =========================================================

if ($denda_terlambat > 0) {


    $denda_format =
        "Rp " .
        number_format(
            $denda_terlambat,
            0,
            ',',
            '.'
        );


    echo "<script>

            alert(
                'Buku berhasil dikembalikan. Denda keterlambatan: $denda_format'
            );

            window.location=
                '/pinjam_buku/dipinjam';

          </script>";

}

else {


    echo "<script>

            alert(
                'Buku berhasil dikembalikan. Tidak ada denda keterlambatan.'
            );

            window.location=
                '/pinjam_buku/dipinjam';

          </script>";
}

?>