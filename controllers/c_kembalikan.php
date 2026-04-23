<?php
require_once "../models/m_pinjam.php";
require_once "../models/m_buku.php";

$pinjam = new m_pinjam();
$buku   = new m_buku();


$id_pinjam = $_GET['id_pinjam'];


/* AMBIL DATA PINJAMAN */
$data_pinjam = $pinjam->tampil_pinjam_by_id($id_pinjam);

$kode_buku = $data_pinjam->kode_buku;
$jumlah_pinjam = $data_pinjam->jumlah_pinjam;


/* AMBIL DATA BUKU */
$data_buku = $buku->tampil_data_by_kode($kode_buku);

$stok_lama = $data_buku->stok;


/* HITUNG STOK BARU */
$stok_baru = $stok_lama + $jumlah_pinjam;


/* UPDATE STOK */
$buku->update_stok($kode_buku,$stok_baru);


/* UPDATE STATUS PINJAM */
$pinjam->kembalikan_buku($id_pinjam);


echo "<script>
alert('Buku berhasil dikembalikan');
window.location='../views/sedang_dipinjam.php';
</script>";
?>