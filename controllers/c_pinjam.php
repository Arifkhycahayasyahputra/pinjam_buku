<?php
// Mulai session
session_start();

// Panggil model buku dan pinjam
require_once "../models/m_buku.php";
require_once "../models/m_pinjam.php";

// Buat object
$buku   = new m_buku();
$pinjam = new m_pinjam();

// Ambil aksi dari URL
$aksi = $_GET['aksi'] ?? '';

/* ================= PROSES PINJAM ================= */
if($aksi == "pinjam"){

    // Ambil data dari form
    $kode_buku     = $_POST['kode_buku'];
    $id_pengguna   = $_POST['id_pengguna'];
    $tgl_pinjam    = $_POST['tanggal_pinjam'];
    $jumlah_pinjam = $_POST['jumlah_pinjam'];

    // Ambil data buku berdasarkan kode
    $data_buku = $buku->tampil_data_by_kode($kode_buku);

    // Validasi: jika buku tidak ditemukan
    if(!$data_buku){
        die("Buku tidak ditemukan");
    }

    // Ambil stok lama
    $stok_lama = $data_buku->stok;

    // Validasi: jika jumlah pinjam melebihi stok
    if($jumlah_pinjam > $stok_lama){

        echo "<script>
        alert('Stok tidak cukup');
        window.history.back();
        </script>";

        exit;
    }

    
    // Status = pending (menunggu verifikasi admin)
    $pinjam->request_pinjam(
        $kode_buku,
        $id_pengguna,
        $tgl_pinjam,
        $jumlah_pinjam
    );

    // Notifikasi berhasil
    echo "<script>
    alert('Pengajuan peminjaman berhasil, menunggu verifikasi admin');
    window.location='../views/v_dasbord_user.php';
    </script>";
}
?>