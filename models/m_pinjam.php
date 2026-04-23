<?php
include_once "m_koneksi.php";

class m_pinjam{

    public $koneksi;

    function __construct(){
        $db = new m_koneksi();
        $this->koneksi = $db->koneksi;
    }


    // TAMBAH PINJAM
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


    // TAMPIL PINJAM BERDASARKAN ID
    function tampil_pinjam_by_id($id_pinjam){

        $sql = "SELECT * FROM pinjam
                WHERE id_pinjam='$id_pinjam'";

        $q = mysqli_query($this->koneksi,$sql);

        return mysqli_fetch_object($q);
    }


    // TAMPIL SEMUA BUKU DIPINJAM
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


    // KEMBALIKAN BUKU
    function kembalikan_buku($id_pinjam){

        $tanggal_kembali = date("Y-m-d");

        $sql = "UPDATE pinjam
                SET status='dikembalikan',
                    tanggal_kembali='$tanggal_kembali'
                WHERE id_pinjam='$id_pinjam'";

        return mysqli_query($this->koneksi,$sql);
    }


    // REQUEST PINJAM
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

    $sql = "UPDATE pinjam
            SET status='dipinjam',
                tanggal_kembali='$tanggal_kembali'
            WHERE id_pinjam='$id_pinjam'";

    return mysqli_query($this->koneksi,$sql);
}
}
?>