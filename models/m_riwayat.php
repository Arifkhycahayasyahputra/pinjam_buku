<?php
// menghubungkan ke file koneksi database
include_once "m_koneksi.php";

// class untuk mengelola data riwayat peminjaman
class m_riwayat {

    public $koneksi;

    // constructor → otomatis dijalankan saat class dipanggil
    function __construct(){
        $db = new m_koneksi();
        $this->koneksi = $db->koneksi;
    }

    function tambah_data(
        $nama_buku,
        $nama_peminjam,
        $tgl_pinjam,
        $tgl_kembali,
        $kode_buku,
        $jumlah_pinjam
    ){

        // query insert data ke tabel riwayat
        $sql = "INSERT INTO riwayat_peminjaman
                (
                    nama_buku,
                    nama_peminjam,
                    tanggal_peminjaman,
                    tanggal_pengembalian,
                    kode_buku,
                    jumlah_pinjam
                )
                VALUES
                (
                    '$nama_buku',
                    '$nama_peminjam',
                    '$tgl_pinjam',
                    '$tgl_kembali',
                    '$kode_buku',
                    '$jumlah_pinjam'
                )";

        return mysqli_query($this->koneksi,$sql);
    }

    function tampil_data(){

        // ambil semua data riwayat, urutkan dari terbaru
        $sql = "SELECT * FROM riwayat_peminjaman
                ORDER BY id_riwayat DESC";

        $q = mysqli_query($this->koneksi,$sql);

        $data=[];

        while($d=mysqli_fetch_object($q)){
            $data[]=$d;
        }

        return $data;
    }

    function hapus_data($id_riwayat){

        // amankan input dari SQL Injection sederhana
        $id_riwayat = mysqli_real_escape_string($this->koneksi, $id_riwayat);

        // query hapus data berdasarkan ID
        $sql = "DELETE FROM riwayat_peminjaman
                WHERE id_riwayat='$id_riwayat'";

        return mysqli_query($this->koneksi,$sql);
    }
}
?>