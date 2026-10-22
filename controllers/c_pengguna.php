<?php

// =========================================================
// Panggil model pengguna
// =========================================================

require_once "../models/m_pengguna.php";


// Buat object
$user = new m_pengguna();


// =========================================================
// AMBIL AKSI
// =========================================================

$aksi = $_GET['aksi'] ?? '';


// =========================================================
// HAPUS
// =========================================================

if ($aksi === "hapus") {


    $id =
        $_GET['id'] ?? '';


    $user->hapus_data($id);


    header(
        "Location: /pinjam_buku/admin/user"
    );

    exit;
}


// =========================================================
// FORM TAMBAH USER
// =========================================================

if (
    $aksi === "tambah"
    &&
    $_SERVER['REQUEST_METHOD'] === 'GET'
) {


    include "../views/v_tambah_pengguna.php";

    exit;
}


// =========================================================
// PROSES TAMBAH USER
// =========================================================

if (
    $aksi === "tambah"
    &&
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {


    $user->tambah_data(

        $_POST['nama_pengguna'],

        $_POST['email'],

        $_POST['jenis_kelamin'],

        $_POST['tanggal_lahir_pengguna'],

        $_POST['alamat'],

        $_POST['password'],

        $_POST['role']

    );


    header(
        "Location: /pinjam_buku/admin/user"
    );

    exit;
}


// =========================================================
// FORM EDIT USER
// =========================================================

if ($aksi === "edit") {


    $users =
        $user->tampil_data_by_id(
            $_GET['id']
        );


    include "../views/v_edit_pengguna.php";

    exit;
}


// =========================================================
// UPDATE USER
// =========================================================

if ($aksi === "update") {


    $user->ubah_data(

        $_POST['id_user'],

        $_POST['nama_pengguna'],

        $_POST['email'],

        $_POST['jenis_kelamin'],

        $_POST['tanggal_lahir_pengguna'],

        $_POST['alamat'],

        $_POST['password'],

        $_POST['role']

    );


    header(
        "Location: /pinjam_buku/admin/user"
    );

    exit;
}


// =========================================================
// DATA USER
// =========================================================

$pengguna =
    $user->tampil_data();


// Tampilkan view
include "../views/v_data_user.php";

?>