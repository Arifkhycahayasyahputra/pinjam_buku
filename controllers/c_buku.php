<?php

include "../models/m_buku.php";

$buku = new m_buku();

try {
    $aksi = $_GET['aksi'] ?? '';

    if ($aksi != "") {

        
        if ($aksi == "edit") {
            $kode = $_GET['kode_buku'] ?? '';

            if ($kode != "") {
                $data = $buku->tampil_data_by_kode($kode);
                include_once '../views/v_edit_buku.php';
            } else {
                echo "Kode buku tidak ditemukan!";
            }

            exit;
        }

        
        if ($aksi == "tambah" && isset($_POST['nama_buku'])) {
            $nama     = $_POST['nama_buku'];
            $gambar   = $_POST['gambar'] ?? '';
            $tanggal  = $_POST['tanggal_rilis'] ?? null;
            $pencipta = $_POST['pencipta'];
            $stok     = $_POST['stok'];

            if (empty($tanggal)) $tanggal = null;

            $query = $buku->tambah_data(
                $gambar,
                $nama,
                $tanggal,
                $pencipta,
                $stok
            );

            if ($query) {
                echo "<script>alert('Data berhasil ditambahkan');window.location='../views/v_admin_buku.php'</script>";
            } else {
                echo "<script>alert('Data gagal ditambahkan');window.location='../views/v_admin_buku.php'</script>";
            }

            exit;
        }

        if ($aksi == "update" && isset($_POST['kode_buku'])) {
            $kode     = $_POST['kode_buku'];
            $nama     = $_POST['nama_buku'];
            $gambar   = $_POST['gambar'] ?? '';
            $tanggal  = $_POST['tanggal_rilis'] ?? null;
            $pencipta = $_POST['pencipta'];
            $stok     = $_POST['stok'];

            if (empty($tanggal)) $tanggal = null;

            $query = $buku->update_data(
                $kode,
                $gambar,
                $nama,
                $tanggal,
                $pencipta,
                $stok
            );

            if ($query) {
                echo "<script>alert('Data berhasil diupdate');window.location='../views/v_admin_buku.php'</script>";
            } else {
                echo "<script>alert('Data gagal diupdate');window.location='../views/v_admin_buku.php'</script>";
            }

            exit;
        }

        
        if ($aksi == "hapus") {
            $kode = $_GET['kode_buku'] ?? '';

            $result = $buku->hapus_data($kode);

            if ($result) {
                echo "<script>alert('Data berhasil dihapus');window.location='../views/v_admin_buku.php'</script>";
            } else {
                echo "<script>alert('Data gagal dihapus');window.location='../views/v_admin_buku.php'</script>";
            }

            exit;
        }

    } else {

        $data_buku = $buku->tampil_data();

    }

} catch (Exception $e) {
    echo $e->getMessage();
}
?>