<?php
session_start();

require_once "../models/m_riwayat.php";

$riwayat = new m_riwayat();

$aksi = $_GET['aksi'] ?? '';


if($aksi == "hapus" && isset($_GET['id_riwayat'])){

    $id_riwayat = $_GET['id_riwayat'];

    $hapus = $riwayat->hapus_data($id_riwayat);

    if($hapus){
        echo "<script>
        alert('Riwayat berhasil dihapus');
        window.location='../views/v_riwayat_peminjaman_buku.php';
        </script>";
    }else{
        echo "<script>
        alert('Gagal menghapus riwayat');
        window.location='../views/v_riwayat_peminjaman_buku.php';
        </script>";
    }

    exit;
}


$data_riwayat = $riwayat->tampil_data();
?>