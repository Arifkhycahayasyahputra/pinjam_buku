<?php
require_once "../models/m_pengguna.php";

$user = new m_pengguna();
$aksi = $_GET['aksi'] ?? '';




if ($aksi === "hapus") {
    $user->hapus_data($_GET['id']);
    header("Location: ../views/v_data_user.php");
    exit;
}



if ($aksi === "tambah" && $_SERVER['REQUEST_METHOD'] === 'GET') {
    include "../views/v_tambah_pengguna.php";
    exit;
}


if ($aksi === "tambah" && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $user->tambah_data(
        $_POST['nama_pengguna'],
        $_POST['email'],
        $_POST['jenis_kelamin'],
        $_POST['tanggal_lahir_pengguna'],
        $_POST['alamat'],
        $_POST['password'],
        $_POST['role']
    );

    header("Location: ../views/v_data_user.php");
    exit;
}


if ($aksi === "edit") {
    $users = $user->tampil_data_by_id($_GET['id']);
    include "../views/v_edit_pengguna.php";
    exit;
}


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

    header("Location: ../views/v_data_user.php");
    exit;
}


$pengguna = $user->tampil_data();
include "../views/v_data_user.php";
