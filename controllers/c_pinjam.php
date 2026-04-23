<?php
session_start();

require_once "../models/m_buku.php";
require_once "../models/m_pinjam.php";

$buku = new m_buku();
$pinjam = new m_pinjam();

$aksi = $_GET['aksi'] ?? '';

if($aksi=="pinjam"){

    $kode_buku = $_POST['kode_buku'];
    $id_pengguna = $_POST['id_pengguna'];
    $tgl_pinjam = $_POST['tanggal_pinjam'];
    $jumlah_pinjam = $_POST['jumlah_pinjam'];

    $data_buku = $buku->tampil_data_by_kode($kode_buku);

    if(!$data_buku){
        die("Buku tidak ditemukan");
    }

    $stok_lama = $data_buku->stok;

    if($jumlah_pinjam > $stok_lama){

        echo "<script>
        alert('Stok tidak cukup');
        window.history.back();
        </script>";

        exit;
    }

    // REQUEST PINJAM (STATUS PENDING)
    $pinjam->request_pinjam(
        $kode_buku,
        $id_pengguna,
        $tgl_pinjam,
        $jumlah_pinjam
    );

    echo "<script>
    alert('Pengajuan peminjaman berhasil, menunggu verifikasi admin');
    window.location='../views/v_dasbord_user.php';
    </script>";
}
?>