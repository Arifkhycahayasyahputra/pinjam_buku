<?php

// Mulai session
session_start();


// =========================================================
// Panggil model pengguna
// =========================================================

include "../models/m_pengguna.php";


// Buat object
$pengguna = new m_pengguna();


// =========================================================
// CEK TOMBOL LOGIN
// =========================================================

if (isset($_POST['login'])) {

    // Ambil input
    $username_email = trim($_POST['username_email'] ?? '');
    $password       = trim($_POST['password'] ?? '');


    // =====================================================
    // CEK INPUT
    // =====================================================

    if ($username_email === '' || $password === '') {

        echo "<script>
                alert('Username/Email dan Password wajib diisi!');
                window.location='/pinjam_buku/';
              </script>";

        exit;
    }


    // =====================================================
    // PROSES LOGIN
    // =====================================================

    $data = $pengguna->login(
        $username_email,
        $password
    );


    // =====================================================
    // LOGIN BERHASIL
    // =====================================================

    if ($data) {

        // Simpan session
        $_SESSION['id_pengguna']   = $data->id_pengguna;
        $_SESSION['nama_pengguna'] = $data->nama_pengguna;
        $_SESSION['role']          = $data->role;


        // =================================================
        // ADMIN
        // =================================================

        if ($data->role == "admin") {

            header(
                "Location: /pinjam_buku/admin"
            );

            exit;

        }


        // =================================================
        // USER
        // =================================================

        else {

            header(
                "Location: /pinjam_buku/dashboard"
            );

            exit;

        }


    }


    // =====================================================
    // LOGIN GAGAL
    // =====================================================

    else {

        echo "<script>

                alert(
                    'Username/Email atau Password salah!'
                );

                window.location='/pinjam_buku/';

              </script>";

        exit;
    }

}

?>