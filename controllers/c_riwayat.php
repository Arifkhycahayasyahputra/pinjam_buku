<?php
// Mulai session
session_start();

// Proteksi: hanya admin yang boleh akses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Panggil model riwayat
require_once "../models/m_riwayat.php";

// Buat object
$riwayat = new m_riwayat();

// Ambil aksi dari URL
$aksi = $_GET['aksi'] ?? '';


if($aksi == "hapus" && isset($_GET['id_riwayat'])){

    // Ambil id riwayat dari URL
    $id_riwayat = $_GET['id_riwayat'];

    // Validasi sederhana (biar tidak kosong)
    if(empty($id_riwayat)){
        echo "<script>alert('ID tidak valid');history.back();</script>";
        exit;
    }

    // Jalankan fungsi hapus di model
    $hapus = $riwayat->hapus_data($id_riwayat);

    // Cek hasil hapus
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


// Ambil semua data riwayat
$data_riwayat = $riwayat->tampil_data();

?>