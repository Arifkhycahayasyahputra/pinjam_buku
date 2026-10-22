<?php

include_once "m_koneksi.php";


class m_denda
{

    public $koneksi;



    /*
    ==========================================================
    CONSTRUCTOR
    ==========================================================
    */

    function __construct()
    {

        $db = new m_koneksi();

        $this->koneksi = $db->koneksi;
    }



    /*
    ==========================================================
    CARI KATEGORI DENDA
    ==========================================================
    */

    function cari_kategori($nama_kategori)
    {

        $nama_kategori = mysqli_real_escape_string(
            $this->koneksi,
            $nama_kategori
        );


        $sql = "SELECT *
                FROM kategori_denda
                WHERE nama_kategori='$nama_kategori'
                AND status='aktif'
                LIMIT 1";


        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$q) {

            return false;
        }


        return mysqli_fetch_object($q);
    }



    /*
    ==========================================================
    TAMBAH DENDA
    ==========================================================
    */

    function tambah_denda(
        $id_pinjam,
        $id_kategori_denda,
        $jumlah_hari_terlambat,
        $jumlah_denda,
        $keterangan
    )
    {

        /*
        ------------------------------------------------------
        PASTIKAN ID BERUPA ANGKA
        ------------------------------------------------------
        */

        $id_pinjam = (int) $id_pinjam;

        $id_kategori_denda =
            (int) $id_kategori_denda;

        $jumlah_hari_terlambat =
            (int) $jumlah_hari_terlambat;



        /*
        ------------------------------------------------------
        PASTIKAN NOMINAL BERUPA ANGKA
        ------------------------------------------------------
        */

        $jumlah_denda =
            (float) $jumlah_denda;



        /*
        ------------------------------------------------------
        AMANKAN KETERANGAN
        ------------------------------------------------------
        */

        $keterangan = mysqli_real_escape_string(
            $this->koneksi,
            $keterangan
        );



        /*
        ------------------------------------------------------
        TANGGAL DENDA
        ------------------------------------------------------
        */

        $tanggal_denda =
            date("Y-m-d");



        /*
        ------------------------------------------------------
        INSERT DENDA
        ------------------------------------------------------

        SETIAP DENDA BARU SELALU:

        status_pembayaran = belum_lunas

        Tidak pernah otomatis menjadi lunas.
        ------------------------------------------------------
        */

        $sql = "INSERT INTO denda

                (
                    id_pinjam,
                    id_kategori_denda,
                    jumlah_hari_terlambat,
                    jumlah_denda,
                    status_pembayaran,
                    tanggal_denda,
                    tanggal_pembayaran,
                    keterangan
                )

                VALUES

                (
                    '$id_pinjam',
                    '$id_kategori_denda',
                    '$jumlah_hari_terlambat',
                    '$jumlah_denda',
                    'belum_lunas',
                    '$tanggal_denda',
                    NULL,
                    '$keterangan'
                )";


        return mysqli_query(
            $this->koneksi,
            $sql
        );
    }



    /*
    ==========================================================
    CEK DENDA TERLAMBAT
    ==========================================================
    */

    function cek_denda_terlambat($id_pinjam)
    {

        $id_pinjam = (int) $id_pinjam;


        $sql = "SELECT
                    denda.*
                FROM denda

                JOIN kategori_denda
                    ON denda.id_kategori_denda =
                       kategori_denda.id_kategori_denda

                WHERE denda.id_pinjam='$id_pinjam'

                AND kategori_denda.nama_kategori='Terlambat'

                LIMIT 1";


        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$q) {

            return false;
        }


        return mysqli_fetch_object($q);
    }



    /*
    ==========================================================
    TAMPIL DENDA BERDASARKAN PEMINJAMAN
    ==========================================================
    */

    function tampil_by_pinjam($id_pinjam)
    {

        $id_pinjam = (int) $id_pinjam;


        $sql = "SELECT
                    denda.*,
                    kategori_denda.nama_kategori

                FROM denda

                JOIN kategori_denda
                    ON denda.id_kategori_denda =
                       kategori_denda.id_kategori_denda

                WHERE denda.id_pinjam='$id_pinjam'

                ORDER BY denda.id_denda ASC";


        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        $data = [];


        if (!$q) {

            return $data;
        }


        while ($d = mysqli_fetch_object($q)) {

            $data[] = $d;
        }


        return $data;
    }



    /*
    ==========================================================
    TOTAL DENDA
    ==========================================================
    */

    function total_denda($id_pinjam)
    {

        $id_pinjam = (int) $id_pinjam;


        $sql = "SELECT

                    COALESCE(
                        SUM(jumlah_denda),
                        0
                    ) AS total

                FROM denda

                WHERE id_pinjam='$id_pinjam'";


        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$q) {

            return 0;
        }


        $data =
            mysqli_fetch_object($q);


        return (float) $data->total;
    }



    /*
    ==========================================================
    CEK APAKAH ADA DENDA BELUM LUNAS
    ==========================================================
    */

    function ada_denda_belum_lunas($id_pinjam)
    {

        $id_pinjam = (int) $id_pinjam;


        $sql = "SELECT
                    id_denda

                FROM denda

                WHERE id_pinjam='$id_pinjam'

                AND status_pembayaran='belum_lunas'

                LIMIT 1";


        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$q) {

            return false;
        }


        return mysqli_fetch_object($q);
    }



    /*
    ==========================================================
    TOTAL DENDA BELUM LUNAS MILIK PENGGUNA
    ==========================================================
    */

    function total_denda_belum_lunas_user($id_pengguna)
    {

        $id_pengguna = (int) $id_pengguna;


        $sql = "SELECT
                    COUNT(*) AS total

                FROM denda

                JOIN pinjam
                    ON denda.id_pinjam =
                       pinjam.id_pinjam

                WHERE pinjam.id_pengguna='$id_pengguna'

                AND denda.status_pembayaran='belum_lunas'";


        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$q) {

            return 0;
        }


        $data =
            mysqli_fetch_object($q);


        return (int) $data->total;
    }



    /*
    ==========================================================
    TAMPIL SEMUA DENDA BELUM LUNAS MILIK PENGGUNA
    ==========================================================
    */

    function tampil_denda_belum_lunas_user($id_pengguna)
    {

        $id_pengguna = (int) $id_pengguna;


        $sql = "SELECT

                    denda.*,

                    kategori_denda.nama_kategori,

                    pinjam.kode_buku,

                    pinjam.tanggal_pinjam,

                    buku.nama_buku

                FROM denda

                JOIN pinjam
                    ON denda.id_pinjam =
                       pinjam.id_pinjam

                JOIN kategori_denda
                    ON denda.id_kategori_denda =
                       kategori_denda.id_kategori_denda

                JOIN buku
                    ON pinjam.kode_buku =
                       buku.kode_buku

                WHERE pinjam.id_pengguna='$id_pengguna'

                AND denda.status_pembayaran='belum_lunas'

                ORDER BY denda.id_denda DESC";


        $q = mysqli_query(
            $this->koneksi,
            $sql
        );


        $data = [];


        if (!$q) {

            return $data;
        }


        while ($d = mysqli_fetch_object($q)) {

            $data[] = $d;
        }


        return $data;
    }



    /*
    ==========================================================
    BAYAR DENDA
    ==========================================================
    */

    function bayar_denda($id_denda)
    {

        $id_denda = (int) $id_denda;


        $tanggal =
            date("Y-m-d");


        /*
        ------------------------------------------------------
        HANYA DENDA BELUM LUNAS YANG BOLEH DIUBAH
        ------------------------------------------------------
        */

        $sql = "UPDATE denda

                SET

                    status_pembayaran='lunas',

                    tanggal_pembayaran='$tanggal'

                WHERE id_denda='$id_denda'

                AND status_pembayaran='belum_lunas'";


        $hasil = mysqli_query(
            $this->koneksi,
            $sql
        );


        if (!$hasil) {

            return false;
        }


        /*
        ------------------------------------------------------
        PASTIKAN ADA DATA YANG BENAR-BENAR BERUBAH
        ------------------------------------------------------
        */

        return mysqli_affected_rows(
            $this->koneksi
        ) > 0;
    }



    /*
    ==========================================================
    HAPUS DENDA
    ==========================================================
    */

    function hapus_denda($id_denda)
    {

        $id_denda = (int) $id_denda;


        $sql = "DELETE FROM denda

                WHERE id_denda='$id_denda'";


        return mysqli_query(
            $this->koneksi,
            $sql
        );
    }
/* =========================================================
   TAMPIL SEMUA DENDA MILIK USER
   - Belum lunas + lunas
   - Hanya milik user yang sedang login
========================================================= */

function tampil_denda_user($id_pengguna)
{
    $id_pengguna = (int) $id_pengguna;

    $sql = "SELECT
                denda.id_denda,
                denda.id_pinjam,
                denda.jumlah_hari_terlambat,
                denda.jumlah_denda,
                denda.status_pembayaran,
                denda.tanggal_denda,
                denda.tanggal_pembayaran,
                denda.keterangan,

                kategori_denda.nama_kategori,

                pinjam.kode_buku,
                pinjam.tanggal_pinjam,
                pinjam.tanggal_kembali,
                pinjam.status AS status_pinjam,

                buku.nama_buku,
                buku.gambar

            FROM denda

            INNER JOIN pinjam
                ON denda.id_pinjam = pinjam.id_pinjam

            INNER JOIN kategori_denda
                ON denda.id_kategori_denda =
                   kategori_denda.id_kategori_denda

            INNER JOIN buku
                ON pinjam.kode_buku = buku.kode_buku

            WHERE pinjam.id_pengguna = '$id_pengguna'

            ORDER BY denda.id_denda DESC";

    $q = mysqli_query($this->koneksi, $sql);

    $data = [];

    if (!$q) {
        return $data;
    }

    while ($d = mysqli_fetch_object($q)) {
        $data[] = $d;
    }

    return $data;
}


/* =========================================================
   BAYAR DENDA OLEH USER
   KEAMANAN:
   User hanya boleh membayar denda miliknya sendiri.
========================================================= */

function bayar_denda_user($id_denda, $id_pengguna)
{
    $id_denda = (int) $id_denda;
    $id_pengguna = (int) $id_pengguna;

    $tanggal = date("Y-m-d");

    /*
    ---------------------------------------------------------
    UPDATE HANYA JIKA:
    1. id_denda sesuai
    2. denda tersebut terhubung ke pinjam
    3. pinjam tersebut milik user yang sedang login
    4. status masih belum_lunas
    ---------------------------------------------------------
    */

    $sql = "UPDATE denda

            INNER JOIN pinjam
                ON denda.id_pinjam = pinjam.id_pinjam

            SET
                denda.status_pembayaran = 'lunas',
                denda.tanggal_pembayaran = '$tanggal'

            WHERE
                denda.id_denda = '$id_denda'

                AND pinjam.id_pengguna = '$id_pengguna'

                AND denda.status_pembayaran = 'belum_lunas'";

    $hasil = mysqli_query($this->koneksi, $sql);

    if (!$hasil) {
        return false;
    }

    /*
    ---------------------------------------------------------
    Pastikan memang ada denda yang berubah.
    ---------------------------------------------------------
    */

    return mysqli_affected_rows($this->koneksi) > 0;
}
}

?>