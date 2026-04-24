<?php
// Mulai session (WAJIB untuk keamanan admin)
session_start();

// Proteksi: hanya admin yang boleh akses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Panggil model
include "../models/m_pinjam.php";
include "../models/m_buku.php";

// Buat object
$pinjam = new m_pinjam();
$buku   = new m_buku();


$id_pinjam        = $_POST['id_pinjam'];
$tanggal_kembali  = $_POST['tanggal_kembali'];

$data_pinjam = $pinjam->tampil_pinjam_by_id($id_pinjam);

// Validasi jika data tidak ada
if(!$data_pinjam){
    die("Data pinjaman tidak ditemukan");
}


$kode_buku     = $data_pinjam->kode_buku;
$jumlah_pinjam = $data_pinjam->jumlah_pinjam;

$data_buku = $buku->tampil_data_by_kode($kode_buku);

// Validasi buku
if(!$data_buku){
    die("Data buku tidak ditemukan");
}

// Karena ini proses ACC → stok dikurangi
$stok_baru = $data_buku->stok - $jumlah_pinjam;

// Validasi stok (biar tidak minus)
if($stok_baru < 0){
    echo "<script>
    alert('Stok tidak mencukupi untuk diverifikasi!');
    window.history.back();
    </script>";
    exit;
}


$buku->update_stok($kode_buku, $stok_baru);


// Ubah dari pending → dipinjam + set tanggal kembali
$pinjam->verifikasi_pinjam($id_pinjam, $tanggal_kembali);


echo "<script>
alert('Peminjaman berhasil diverifikasi');
window.location='../views/verif_admin.php';
</script>";
?>