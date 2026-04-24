<?php
session_start();

require_once "../models/m_pinjam.php";
require_once "../models/m_buku.php";
require_once "../models/m_riwayat.php";

$pinjam = new m_pinjam();
$buku   = new m_buku();
$riwayat = new m_riwayat();

$id_pinjam = $_GET['id_pinjam'];

/* AMBIL DATA PINJAMAN */
$data_pinjam = $pinjam->tampil_pinjam_by_id($id_pinjam);

/* CEK DATA ADA */
if(!$data_pinjam){
    echo "<script>
    alert('Data tidak ditemukan');
    window.location='../views/sedang_dipinjam.php';
    </script>";
    exit;
}

/* CEK HAK AKSES (WAJIB) */
if($_SESSION['id_pengguna'] != $data_pinjam->id_pengguna){
    echo "<script>
    alert('Anda tidak berhak mengembalikan buku ini!');
    window.location='../views/sedang_dipinjam.php';
    </script>";
    exit;
}

/* AMBIL DATA */
$kode_buku     = $data_pinjam->kode_buku;
$jumlah_pinjam = $data_pinjam->jumlah_pinjam;

/* AMBIL DATA BUKU */
$data_buku = $buku->tampil_data_by_kode($kode_buku);

/* HITUNG STOK BARU */
$stok_baru = $data_buku->stok + $jumlah_pinjam;

/* UPDATE STOK */
$buku->update_stok($kode_buku,$stok_baru);

/* UPDATE STATUS PINJAM */
$pinjam->kembalikan_buku($id_pinjam);

/* MASUKKAN KE RIWAYAT */
$riwayat->tambah_data(
    $data_buku->nama_buku,
    $_SESSION['nama_pengguna'],
    $data_pinjam->tanggal_pinjam,
    date("Y-m-d"),
    $kode_buku,
    $jumlah_pinjam
);

echo "<script>
alert('Buku berhasil dikembalikan');
window.location='../views/sedang_dipinjam.php';
</script>";
?>