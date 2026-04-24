<?php
session_start();

include "../models/m_pengguna.php";

$pengguna = new m_pengguna();

$_SESSION['nama_pengguna'] = $data_user->nama_pengguna;

if (isset($_POST['login'])) {

    $username_email = trim($_POST['username_email']);
    $password       = trim($_POST['password']);

    $data = $pengguna->login($username_email, $password);

    if ($data) {

        $_SESSION['id_pengguna']   = $data->id_pengguna;
        $_SESSION['nama_pengguna'] = $data->nama_pengguna;
        $_SESSION['role']          = $data->role;

        if ($data->role == "admin") {
            header("Location:../views/v_dasbord_admin.php");
        } else {
            header("Location:../views/v_dasbord_user.php");
        }
        exit;

    } else {

        echo "<script>
                alert('Username/Email atau Password salah!');
                window.location='../index.php';
              </script>";
        exit;
    }
}
?>