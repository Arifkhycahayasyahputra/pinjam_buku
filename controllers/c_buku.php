<?php

// =========================================================
// Panggil model buku
// =========================================================

include "../models/m_buku.php";


// Buat object
$buku = new m_buku();


// =========================================================
// AMBIL AKSI
// =========================================================

$aksi = $_GET['aksi'] ?? '';


// =========================================================
// PROSES
// =========================================================

if ($aksi != "") {


    // =====================================================
    // EDIT DATA BUKU
    // =====================================================

    if ($aksi == "edit") {

        $kode =
            $_GET['kode_buku'] ?? '';


        if ($kode != "") {

            $data =
                $buku->tampil_data_by_kode(
                    $kode
                );


            include_once
                '../views/v_edit_buku.php';

        }

        else {

            echo "Kode buku tidak ditemukan!";
        }


        exit;
    }



    // =====================================================
    // TAMBAH DATA BUKU
    // =====================================================

    if (
        $aksi == "tambah"
        &&
        isset($_POST['nama_buku'])
    ) {


        $nama =
            $_POST['nama_buku'];


        $gambar =
            $_POST['gambar'] ?? '';


        $tanggal =
            $_POST['tanggal_rilis'] ?? null;


        $pencipta =
            $_POST['pencipta'];


        $stok =
            $_POST['stok'];


        if (empty($tanggal)) {

            $tanggal = null;
        }


        $query =
            $buku->tambah_data(

                $gambar,

                $nama,

                $tanggal,

                $pencipta,

                $stok

            );


        if ($query) {

            echo "<script>

                    alert(
                        'Data berhasil ditambahkan'
                    );

                    window.location=
                        '/pinjam_buku/admin/buku';

                  </script>";

        }

        else {

            echo "<script>

                    alert(
                        'Data gagal ditambahkan'
                    );

                    window.location=
                        '/pinjam_buku/admin/buku';

                  </script>";
        }


        exit;
    }



    // =====================================================
    // UPDATE DATA BUKU
    // =====================================================

    if (
        $aksi == "update"
        &&
        isset($_POST['kode_buku'])
    ) {


        $kode =
            $_POST['kode_buku'];


        $nama =
            $_POST['nama_buku'];


        $gambar =
            $_POST['gambar'] ?? '';


        $tanggal =
            $_POST['tanggal_rilis'] ?? null;


        $pencipta =
            $_POST['pencipta'];


        $stok =
            $_POST['stok'];


        if (empty($tanggal)) {

            $tanggal = null;
        }


        $query =
            $buku->update_data(

                $kode,

                $gambar,

                $nama,

                $tanggal,

                $pencipta,

                $stok

            );


        if ($query) {

            echo "<script>

                    alert(
                        'Data berhasil diupdate'
                    );

                    window.location=
                        '/pinjam_buku/admin/buku';

                  </script>";

        }

        else {

            echo "<script>

                    alert(
                        'Data gagal diupdate'
                    );

                    window.location=
                        '/pinjam_buku/admin/buku';

                  </script>";
        }


        exit;
    }



    // =====================================================
    // HAPUS DATA BUKU
    // =====================================================

    if ($aksi == "hapus") {


        $kode =
            $_GET['kode_buku'] ?? '';


        $result =
            $buku->hapus_data(
                $kode
            );


        if ($result) {

            echo "<script>

                    alert(
                        'Data berhasil dihapus'
                    );

                    window.location=
                        '/pinjam_buku/admin/buku';

                  </script>";

        }

        else {

            echo "<script>

                    alert(
                        'Data gagal dihapus (mungkin buku masih dipinjam)'
                    );

                    window.location=
                        '/pinjam_buku/admin/buku';

                  </script>";
        }


        exit;
    }

}

else {

    $data_buku =
        $buku->tampil_data();
}

?>