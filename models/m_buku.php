<?php

// Panggil koneksi database
include_once "m_koneksi.php";

class m_buku {

    // Variabel untuk menyimpan koneksi
    private $koneksi;


    // Constructor
    public function __construct() {

        $db = new m_koneksi();

        $this->koneksi = $db->koneksi;
    }



    /*
    ==========================================================
    TAMBAH DATA BUKU
    ==========================================================
    */

    function tambah_data(
        $gambar,
        $nama,
        $tgl,
        $pencipta,
        $stok,
        $denda_per_hari = 'Rp 1.000'
    ) {

        // Pastikan stok angka
        $stok = (int)$stok;

        // Amankan data
        $gambar = mysqli_real_escape_string(
            $this->koneksi,
            $gambar
        );

        $nama = mysqli_real_escape_string(
            $this->koneksi,
            $nama
        );

        $tgl = mysqli_real_escape_string(
            $this->koneksi,
            $tgl
        );

        $pencipta = mysqli_real_escape_string(
            $this->koneksi,
            $pencipta
        );

        $denda_per_hari = mysqli_real_escape_string(
            $this->koneksi,
            $denda_per_hari
        );


        $sql = "INSERT INTO buku
                (
                    gambar,
                    nama_buku,
                    tanggal_rilis,
                    pencipta,
                    stok,
                    denda_per_hari
                )
                VALUES
                (
                    '$gambar',
                    '$nama',
                    '$tgl',
                    '$pencipta',
                    '$stok',
                    '$denda_per_hari'
                )";


        return mysqli_query(
            $this->koneksi,
            $sql
        );
    }




    /*
    ==========================================================
    TAMPIL SEMUA DATA BUKU
    ==========================================================
    */

    function tampil_data() {

        $sql = "SELECT *
                FROM buku
                ORDER BY kode_buku DESC";

        $q = mysqli_query(
            $this->koneksi,
            $sql
        );

        $data = [];

        while($d = mysqli_fetch_object($q)) {

            $data[] = $d;
        }

        return $data;
    }



    /*
    ==========================================================
    TAMPIL BUKU BERDASARKAN KODE
    ==========================================================
    */

    function tampil_data_by_kode($kode) {

        $kode = mysqli_real_escape_string(
            $this->koneksi,
            $kode
        );

        $q = mysqli_query(
            $this->koneksi,
            "SELECT *
             FROM buku
             WHERE kode_buku='$kode'"
        );

        return mysqli_fetch_object($q);
    }



    /*
    ==========================================================
    UPDATE DATA BUKU
    ==========================================================
    */

    function update_data(
        $kode,
        $gambar,
        $nama,
        $tgl,
        $pencipta,
        $stok,
        $denda_per_hari = 'Rp 1.000'
    ) {

        $stok = (int)$stok;

        $kode = mysqli_real_escape_string(
            $this->koneksi,
            $kode
        );

        $gambar = mysqli_real_escape_string(
            $this->koneksi,
            $gambar
        );

        $nama = mysqli_real_escape_string(
            $this->koneksi,
            $nama
        );

        $tgl = mysqli_real_escape_string(
            $this->koneksi,
            $tgl
        );

        $pencipta = mysqli_real_escape_string(
            $this->koneksi,
            $pencipta
        );

        $denda_per_hari = mysqli_real_escape_string(
            $this->koneksi,
            $denda_per_hari
        );


        $sql = "UPDATE buku SET

                    gambar='$gambar',

                    nama_buku='$nama',

                    tanggal_rilis='$tgl',

                    pencipta='$pencipta',

                    stok='$stok',

                    denda_per_hari='$denda_per_hari'

                WHERE kode_buku='$kode'";


        return mysqli_query(
            $this->koneksi,
            $sql
        );
    }



    /*
    ==========================================================
    UPDATE STOK
    ==========================================================
    */

    function update_stok(
        $kode_buku,
        $stok_baru
    ) {

        $stok_baru = (int)$stok_baru;

        $kode_buku = mysqli_real_escape_string(
            $this->koneksi,
            $kode_buku
        );


        $sql = "UPDATE buku

                SET stok='$stok_baru'

                WHERE kode_buku='$kode_buku'";


        return mysqli_query(
            $this->koneksi,
            $sql
        );
    }

    function hapus_data($kode) {

    $kode = mysqli_real_escape_string(
        $this->koneksi,
        $kode
    );

    try {

        return mysqli_query(
            $this->koneksi,
            "DELETE FROM buku
             WHERE kode_buku='$kode'"
        );

    } catch (mysqli_sql_exception $e) {

        // Buku masih dipakai di tabel pinjam
        return false;
    }
}

}

?>