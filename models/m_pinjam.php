<?php
// menghubungkan ke file koneksi database
include_once "m_koneksi.php";

// class untuk mengelola data peminjaman buku
class m_pinjam{

    public $koneksi;

    // constructor → otomatis dijalankan saat class dipanggil
    function __construct(){
        $db = new m_koneksi();
        $this->koneksi = $db->koneksi;
    }


    function tambah_pinjam($kode_buku,$id_pengguna,$tanggal_pinjam,$tanggal_kembali,$jumlah_pinjam){

        
        $tanggal_kembali = ($tanggal_kembali == NULL) ? "NULL" : "'$tanggal_kembali'";

        $sql = "INSERT INTO pinjam
                (id_pinjam, kode_buku, id_pengguna, tanggal_pinjam, tanggal_kembali, status, jumlah_pinjam)
                VALUES(
                    NULL,
                    '$kode_buku',
                    '$id_pengguna',
                    '$tanggal_pinjam',
                    $tanggal_kembali,
                    'dipinjam',
                    '$jumlah_pinjam'
                )";

        return mysqli_query($this->koneksi,$sql);
    }



  
    function tampil_pinjam_by_id($id_pinjam){

        $sql = "SELECT * FROM pinjam
                WHERE id_pinjam='$id_pinjam'";

        $q = mysqli_query($this->koneksi,$sql);

        // ambil 1 data dalam bentuk object
        return mysqli_fetch_object($q);
    }



    
    function tampil_buku_dipinjam(){

        $sql = "SELECT 
                    pinjam.*,
                    buku.nama_buku,
                    pengguna.nama_pengguna
                FROM pinjam
                JOIN buku ON pinjam.kode_buku = buku.kode_buku
                JOIN pengguna ON pinjam.id_pengguna = pengguna.id_pengguna
                WHERE pinjam.status='dipinjam'";

        $q = mysqli_query($this->koneksi,$sql);

        $data=[];

        
        while($d=mysqli_fetch_object($q)){
            $data[]=$d;
        }

        return $data;
    }


    function kembalikan_buku($id_pinjam){

        // ambil tanggal hari ini otomatis
        $tanggal_kembali = date("Y-m-d");

        $sql = "UPDATE pinjam
                SET status='dikembalikan',
                    tanggal_kembali='$tanggal_kembali'
                WHERE id_pinjam='$id_pinjam'";

        return mysqli_query($this->koneksi,$sql);
    }



    function request_pinjam($kode_buku,$id_pengguna,$tanggal_pinjam,$jumlah_pinjam){

        $sql = "INSERT INTO pinjam
                (id_pinjam, kode_buku, id_pengguna, tanggal_pinjam, tanggal_kembali, status, jumlah_pinjam)
                VALUES(
                    NULL,
                    '$kode_buku',
                    '$id_pengguna',
                    '$tanggal_pinjam',
                    NULL,
                    'pending',
                    '$jumlah_pinjam'
                )";

        return mysqli_query($this->koneksi,$sql);
    }


    function tampil_pending(){

        $sql = "SELECT 
                    pinjam.*,
                    buku.nama_buku,
                    pengguna.nama_pengguna
                FROM pinjam
                JOIN buku ON pinjam.kode_buku = buku.kode_buku
                JOIN pengguna ON pinjam.id_pengguna = pengguna.id_pengguna
                WHERE pinjam.status='pending'";

        $q = mysqli_query($this->koneksi,$sql);

        $data = [];

        
        while($d = mysqli_fetch_object($q)){
            $data[] = $d;
        }

        return $data;
    }


    function verifikasi_pinjam($id_pinjam,$tanggal_kembali){

        // admin menentukan tanggal kembali
        $sql = "UPDATE pinjam
                SET status='dipinjam',
                    tanggal_kembali='$tanggal_kembali'
                WHERE id_pinjam='$id_pinjam'";

        return mysqli_query($this->koneksi,$sql);
    }
}
?>