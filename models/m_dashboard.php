<?php

// Panggil koneksi database
include_once "m_koneksi.php";


class m_dashboard
{

    // Variabel koneksi
    public $koneksi;


    // Constructor
    function __construct()
    {

        $db = new m_koneksi();

        $this->koneksi = $db->koneksi;
    }


    /*
    ==========================================================
    TOTAL BUKU
    ==========================================================
    */

    function total_buku()
    {

        $sql = "SELECT COUNT(*) AS total
                FROM buku";

        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$q) {

            die(
                "Error total buku: "
                . mysqli_error($this->koneksi)
            );
        }


        $data = mysqli_fetch_assoc($q);

        return $data['total'];
    }


    /*
    ==========================================================
    TOTAL USER
    ==========================================================
    */

    function total_user()
    {

        $sql = "SELECT COUNT(*) AS total
                FROM pengguna
                WHERE role='user'";

        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$q) {

            die(
                "Error total user: "
                . mysqli_error($this->koneksi)
            );
        }


        $data = mysqli_fetch_assoc($q);

        return $data['total'];
    }


    /*
    ==========================================================
    TOTAL PENDING
    ==========================================================
    */

    function total_pending()
    {

        $sql = "SELECT COUNT(*) AS total
                FROM pinjam
                WHERE status='pending'";

        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$q) {

            die(
                "Error total pending: "
                . mysqli_error($this->koneksi)
            );
        }


        $data = mysqli_fetch_assoc($q);

        return $data['total'];
    }


    /*
    ==========================================================
    TOTAL SEDANG DIPINJAM
    ==========================================================
    */

    function total_pinjam()
    {

        $sql = "SELECT COUNT(*) AS total
                FROM pinjam
                WHERE status='dipinjam'";

        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$q) {

            die(
                "Error total pinjam: "
                . mysqli_error($this->koneksi)
            );
        }


        $data = mysqli_fetch_assoc($q);

        return $data['total'];
    }


    /*
    ==========================================================
    TOTAL DIKEMBALIKAN
    ==========================================================
    */

    function total_kembali()
    {

        $sql = "SELECT COUNT(*) AS total
                FROM pinjam
                WHERE status='dikembalikan'";

        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$q) {

            die(
                "Error total kembali: "
                . mysqli_error($this->koneksi)
            );
        }


        $data = mysqli_fetch_assoc($q);

        return $data['total'];
    }

}

?>