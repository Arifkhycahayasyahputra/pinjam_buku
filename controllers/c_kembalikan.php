<?php
session_start();

// Menghubungkan ke model yang dibutuhkan
require_once "../models/m_pinjam.php";
require_once "../models/m_buku.php";
require_once "../models/m_riwayat.php";

// Membuat objek dari masing-masing model
$pinjam = new m_pinjam();
$buku   = new m_buku();
$riwayat = new m_riwayat();

// Mengambil id pinjam dari URL
$id_pinjam = $_GET['id_pinjam'];


$data_pinjam = $pinjam->tampil_pinjam_by_id($id_pinjam);

/* ==============================
   CEK DATA ADA ATAU TIDAK
============================== */
if(!$data_pinjam){

    // Jika data tidak ditemukan
    echo "<script>
    alert('Data tidak ditemukan');
    window.location='../views/sedang_dipinjam.php';
    </script>";
    exit;
}


// Hanya user yang meminjam yang boleh mengembalikan
if($_SESSION['id_pengguna'] != $data_pinjam->id_pengguna){

    echo "<script>
    alert('Anda tidak berhak mengembalikan buku ini!');
    window.location='../views/sedang_dipinjam.php';
    </script>";
    exit;
}


$kode_buku     = $data_pinjam->kode_buku;
$jumlah_pinjam = $data_pinjam->jumlah_pinjam;


$data_buku = $buku->tampil_data_by_kode($kode_buku);


// Stok lama + jumlah yang dikembalikan
$stok_baru = $data_buku->stok + $jumlah_pinjam;


$buku->update_stok($kode_buku,$stok_baru);


// Mengubah status menjadi "dikembalikan"
$pinjam->kembalikan_buku($id_pinjam);


// Data riwayat disimpan setelah buku dikembalikan
$riwayat->tambah_data(
    $data_buku->nama_buku,              // Nama buku
    $_SESSION['nama_pengguna'],         // Nama user
    $data_pinjam->tanggal_pinjam,       // Tanggal pinjam
    date("Y-m-d"),                      // Tanggal kembali (hari ini)
    $kode_buku,                         // Kode buku
    $jumlah_pinjam                      // Jumlah pinjam
);

echo "<script>
alert('Buku berhasil dikembalikan');
window.location='../views/sedang_dipinjam.php';
</script>";
?>