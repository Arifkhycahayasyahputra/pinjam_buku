<?php
include_once "m_koneksi.php";

class m_dashboard{

    public $koneksi;

    function __construct(){
        $db = new m_koneksi();
        $this->koneksi = $db->koneksi;
    }

    function total_buku(){
        $sql = "SELECT COUNT(*) as total FROM buku";
        $q = mysqli_query($this->koneksi,$sql);
        return mysqli_fetch_assoc($q)['total'];
    }

    function total_user(){
        $sql = "SELECT COUNT(*) as total FROM pengguna WHERE role='user'";
        $q = mysqli_query($this->koneksi,$sql);
        return mysqli_fetch_assoc($q)['total'];
    }

    function total_pending(){
        $sql = "SELECT COUNT(*) as total FROM pinjam WHERE status='pending'";
        $q = mysqli_query($this->koneksi,$sql);
        return mysqli_fetch_assoc($q)['total'];
    }

    function total_pinjam(){
        $sql = "SELECT COUNT(*) as total FROM pinjam WHERE status='dipinjam'";
        $q = mysqli_query($this->koneksi,$sql);
        return mysqli_fetch_assoc($q)['total'];
    }

    function total_kembali(){
        $sql = "SELECT COUNT(*) as total FROM pinjam WHERE status='dikembalikan'";
        $q = mysqli_query($this->koneksi,$sql);
        return mysqli_fetch_assoc($q)['total'];
    }

}
?>