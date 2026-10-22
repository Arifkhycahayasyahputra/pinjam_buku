<?php

// menghubungkan ke file koneksi database
include_once "m_koneksi.php";


class m_pinjam{

    public $koneksi;


    // constructor
    function __construct(){

        $db = new m_koneksi();

        $this->koneksi = $db->koneksi;
    }



    /*
    ==========================================================
    TAMBAH PINJAM
    ==========================================================
    */

    function tambah_pinjam(
        $kode_buku,
        $id_pengguna,
        $tanggal_pinjam,
        $tanggal_kembali,
        $jumlah_pinjam,
        $tarif_denda = null
    ){

        $kode_buku = mysqli_real_escape_string(
            $this->koneksi,
            $kode_buku
        );

        $id_pengguna = mysqli_real_escape_string(
            $this->koneksi,
            $id_pengguna
        );

        $tanggal_pinjam = mysqli_real_escape_string(
            $this->koneksi,
            $tanggal_pinjam
        );

        $jumlah_pinjam = (int)$jumlah_pinjam;


        if($tanggal_kembali == NULL){

            $tanggal_kembali_sql = "NULL";

        }else{

            $tanggal_kembali = mysqli_real_escape_string(
                $this->koneksi,
                $tanggal_kembali
            );

            $tanggal_kembali_sql = "'$tanggal_kembali'";
        }


        $sql = "INSERT INTO pinjam
                (
                    kode_buku,
                    id_pengguna,
                    tanggal_pinjam,
                    tanggal_kembali,
                    status,
                    jumlah_pinjam
                )

                VALUES
                (
                    '$kode_buku',
                    '$id_pengguna',
                    '$tanggal_pinjam',
                    $tanggal_kembali_sql,
                    'dipinjam',
                    '$jumlah_pinjam'
                )";


        return mysqli_query(
            $this->koneksi,
            $sql
        );
    }



    /*
    ==========================================================
    TAMPIL PINJAM BERDASARKAN ID
    ==========================================================
    */

    function tampil_pinjam_by_id($id_pinjam){

        $id_pinjam = mysqli_real_escape_string(
            $this->koneksi,
            $id_pinjam
        );


        $sql = "SELECT *

                FROM pinjam

                WHERE id_pinjam='$id_pinjam'";


        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        return mysqli_fetch_object($q);
    }



    /*
    ==========================================================
    TAMPIL BUKU YANG SEDANG DIPINJAM
    ==========================================================
    */

    function tampil_buku_dipinjam(){

        $sql = "SELECT

                    pinjam.*,

                    buku.nama_buku,

                    buku.denda_per_hari,

                    pengguna.nama_pengguna

                FROM pinjam

                JOIN buku

                    ON pinjam.kode_buku = buku.kode_buku

                JOIN pengguna

                    ON pinjam.id_pengguna = pengguna.id_pengguna

                WHERE pinjam.status='dipinjam'

                ORDER BY pinjam.id_pinjam DESC";


        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        $data = [];


        while($d = mysqli_fetch_object($q)){

            $data[] = $d;
        }


        return $data;
    }



    /*
    ==========================================================
    KEMBALIKAN BUKU
    ==========================================================
    */

    function kembalikan_buku($id_pinjam){

        $id_pinjam = mysqli_real_escape_string(
            $this->koneksi,
            $id_pinjam
        );


        $sql = "UPDATE pinjam

                SET status='dikembalikan'

                WHERE id_pinjam='$id_pinjam'";


        return mysqli_query(
            $this->koneksi,
            $sql
        );
    }



    /*
    ==========================================================
    REQUEST PINJAM
    ==========================================================
    */

    function request_pinjam(
        $kode_buku,
        $id_pengguna,
        $tanggal_pinjam,
        $jumlah_pinjam,
        $tarif_denda = null
    ){

        $kode_buku = mysqli_real_escape_string(
            $this->koneksi,
            $kode_buku
        );

        $id_pengguna = mysqli_real_escape_string(
            $this->koneksi,
            $id_pengguna
        );

        $tanggal_pinjam = mysqli_real_escape_string(
            $this->koneksi,
            $tanggal_pinjam
        );

        $jumlah_pinjam = (int)$jumlah_pinjam;


        $sql = "INSERT INTO pinjam

                (
                    kode_buku,
                    id_pengguna,
                    tanggal_pinjam,
                    tanggal_kembali,
                    status,
                    jumlah_pinjam
                )

                VALUES

                (
                    '$kode_buku',
                    '$id_pengguna',
                    '$tanggal_pinjam',
                    NULL,
                    'pending',
                    '$jumlah_pinjam'
                )";


        return mysqli_query(
            $this->koneksi,
            $sql
        );
    }



    /*
    ==========================================================
    TAMPIL DATA PENDING
    ==========================================================
    */

    function tampil_pending(){

        $sql = "SELECT

                    pinjam.*,

                    buku.nama_buku,

                    pengguna.nama_pengguna

                FROM pinjam

                JOIN buku

                    ON pinjam.kode_buku = buku.kode_buku

                JOIN pengguna

                    ON pinjam.id_pengguna = pengguna.id_pengguna

                WHERE pinjam.status='pending'

                ORDER BY pinjam.id_pinjam DESC";


        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        $data = [];


        while($d = mysqli_fetch_object($q)){

            $data[] = $d;
        }


        return $data;
    }



    /*
    ==========================================================
    VERIFIKASI PINJAM
    ==========================================================
    */

    function verifikasi_pinjam(
        $id_pinjam,
        $tanggal_kembali
    ){

        $id_pinjam = mysqli_real_escape_string(
            $this->koneksi,
            $id_pinjam
        );

        $tanggal_kembali = mysqli_real_escape_string(
            $this->koneksi,
            $tanggal_kembali
        );


        $sql = "UPDATE pinjam

                SET

                    status='dipinjam',

                    tanggal_kembali='$tanggal_kembali'

                WHERE id_pinjam='$id_pinjam'";


        return mysqli_query(
            $this->koneksi,
            $sql
        );
    }

}

?>