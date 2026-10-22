<?php

session_start();


// =====================================================
// CEK LOGIN
// =====================================================

if (!isset($_SESSION['role'])) {
    header("Location: /pinjam_buku/index.php");
    exit;
}


// =====================================================
// CEK ROLE ADMIN
// =====================================================

if ($_SESSION['role'] !== 'admin') {
    header("Location: /pinjam_buku/dashboard");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Pengguna</title>

    <link rel="stylesheet" href="/pinjam_buku/asset/pengguna_tambah.css?v=5">

</head>

<body>

<!-- =====================================================
     BUTTON TEMA
====================================================== -->

<button
    type="button"
    id="theme-toggle"
    class="theme-toggle"
    aria-label="Ganti tema"
    title="Ganti tema"
>
    🌙
</button>


<!-- =====================================================
     REGISTER CARD
====================================================== -->

<div class="register-card">

    <h2>📚 Tambah Pengguna</h2>

    <p>Perpustakaan - Sistem Peminjaman Buku</p>


    <!-- =================================================
         FORM
         (path absolut supaya tetap jalan di URL /admin/user/tambah)
    ================================================== -->

    <form
        method="POST"
        action="/pinjam_buku/controllers/c_pengguna.php?aksi=tambah"
    >

        <!-- USERNAME -->
        <div class="form-group">
            <label class="field-label" for="nama_pengguna">Username</label>
            <input
                class="field"
                type="text"
                id="nama_pengguna"
                name="nama_pengguna"
                placeholder="Masukkan username"
                required
            >
        </div>


        <!-- EMAIL -->
        <div class="form-group">
            <label class="field-label" for="email">Email</label>
            <input
                class="field"
                type="email"
                id="email"
                name="email"
                placeholder="nama@email.com"
                required
            >
        </div>


        <!-- JENIS KELAMIN -->
        <div class="form-group">
            <span class="field-label">Jenis Kelamin</span>

            <div class="radio-group">

                <label class="radio-option">
                    <input
                        type="radio"
                        name="jenis_kelamin"
                        value="Laki-laki"
                        required
                    >
                    Laki-laki
                </label>

                <label class="radio-option">
                    <input
                        type="radio"
                        name="jenis_kelamin"
                        value="Perempuan"
                        required
                    >
                    Perempuan
                </label>

            </div>
        </div>


        <!-- TANGGAL LAHIR -->
        <div class="form-group">
            <label class="field-label" for="tanggal_lahir_pengguna">Tanggal Lahir</label>
            <input
                class="field"
                type="date"
                id="tanggal_lahir_pengguna"
                name="tanggal_lahir_pengguna"
                required
            >
        </div>


        <!-- ALAMAT -->
        <div class="form-group">
            <label class="field-label" for="alamat">Alamat</label>
            <textarea
                class="field"
                id="alamat"
                name="alamat"
                rows="3"
                placeholder="Masukkan alamat lengkap"
                required
            ></textarea>
        </div>


        <!-- PASSWORD -->
        <div class="form-group">
            <label class="field-label" for="password">Password</label>
            <input
                class="field"
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                required
            >
        </div>


        <!-- ROLE -->
        <input type="hidden" name="role" value="user">


        <!-- =================================================
             AKSI
        ================================================== -->

        <div class="aksi">

            <a href="/pinjam_buku/admin/user" class="btn btn-batal">
                Batal
            </a>

            <button type="submit" name="tambah" class="btn btn-simpan">
                Simpan
            </button>

        </div>

    </form>

</div>


<!-- =====================================================
     GLOBAL THEME
====================================================== -->

<script src="/pinjam_buku/asset/theme.js"></script>

</body>
</html>