<?php
include_once "m_koneksi.php";

class m_buku {
    private $koneksi;

    public function __construct() {
        $db = new m_koneksi();
        $this->koneksi = $db->koneksi;
    }

    
    function tambah_data($gambar, $nama, $tgl, $pencipta, $stok) {

        $stok = (int)$stok; 

        $sql = "INSERT INTO buku 
                (gambar, nama_buku, tanggal_rilis, pencipta, stok) 
                VALUES 
                ('$gambar', '$nama', '$tgl', '$pencipta', '$stok')";

        return mysqli_query($this->koneksi, $sql);
    }

    
    function hapus_data($kode) {
        return mysqli_query($this->koneksi, "DELETE FROM buku WHERE kode_buku='$kode'");
    }

    
    function tampil_data() {

        $sql = "SELECT * FROM buku ORDER BY kode_buku DESC";

        $q = mysqli_query($this->koneksi, $sql);

        $data = [];

        while($d = mysqli_fetch_object($q)) {
            $data[] = $d;
        }

        return $data;
    }

    function tampil_data_by_kode($kode) {
        $kode = mysqli_real_escape_string($this->koneksi, $kode);

        $q = mysqli_query($this->koneksi,
            "SELECT * FROM buku WHERE kode_buku='$kode'");

        return mysqli_fetch_object($q);
    }

    function update_data($kode, $gambar, $nama, $tgl, $pencipta, $stok) {

        $stok = (int)$stok;

        $sql = "UPDATE buku SET 
                    gambar='$gambar',
                    nama_buku='$nama',
                    tanggal_rilis='$tgl',
                    pencipta='$pencipta',
                    stok='$stok'
                WHERE kode_buku='$kode'";

        return mysqli_query($this->koneksi, $sql);
    }

    
    function update_stok($kode_buku,$stok_baru){

        $stok_baru = (int)$stok_baru;

        $sql = "UPDATE buku 
                SET stok='$stok_baru'
                WHERE kode_buku='$kode_buku'";

        return mysqli_query($this->koneksi,$sql);
    }
}
?>