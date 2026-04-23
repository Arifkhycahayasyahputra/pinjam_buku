<?php
include "../models/m_pinjam.php";
include "../models/m_buku.php";

$pinjam = new m_pinjam();
$buku = new m_buku();

$id_pinjam = $_POST['id_pinjam'];
$tanggal_kembali = $_POST['tanggal_kembali'];

$data_pinjam = $pinjam->tampil_pinjam_by_id($id_pinjam);

$kode_buku = $data_pinjam->kode_buku;
$jumlah_pinjam = $data_pinjam->jumlah_pinjam;

$data_buku = $buku->tampil_data_by_kode($kode_buku);

$stok_baru = $data_buku->stok - $jumlah_pinjam;


// UPDATE STOK
$buku->update_stok($kode_buku,$stok_baru);


// UPDATE STATUS + TANGGAL KEMBALI
$pinjam->verifikasi_pinjam($id_pinjam,$tanggal_kembali);


echo "<script>
alert('Peminjaman berhasil diverifikasi');
window.location='../views/verif_admin.php';
</script>";
?>