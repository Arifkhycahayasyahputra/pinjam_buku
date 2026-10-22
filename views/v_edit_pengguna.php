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

    <title>Edit Pengguna | Perpustakaan</title>

    <link rel="stylesheet" href="/pinjam_buku/asset/pengguna_edit.css?v=4">

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
     CARD
====================================================== -->

<div class="card">

    <h2>✏️ Edit Pengguna</h2>

    <p>Form Manajemen Pengguna</p>


    <!-- =================================================
         FORM
         (path absolut supaya tetap jalan di URL /admin/user/edit)
    ================================================== -->

    <form
        action="/pinjam_buku/controllers/c_pengguna.php?aksi=update"
        method="POST"
    >

        <!-- ID USER (tersembunyi) -->
        <input
            type="hidden"
            name="id_user"
            value="<?= htmlspecialchars($users->id_pengguna ?? '') ?>"
        >


        <!-- NAMA PENGGUNA -->
        <div class="form-group">
            <label class="field-label" for="nama_pengguna">Nama Pengguna</label>
            <input
                class="field"
                type="text"
                id="nama_pengguna"
                name="nama_pengguna"
                value="<?= htmlspecialchars($users->nama_pengguna ?? '') ?>"
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
                value="<?= htmlspecialchars($users->email ?? '') ?>"
                required
            >
        </div>


        <!-- JENIS KELAMIN + TANGGAL LAHIR (sebaris) -->
        <div class="form-row">

            <div class="form-group">
                <label class="field-label" for="jenis_kelamin">Jenis Kelamin</label>
                <select
                    class="field"
                    id="jenis_kelamin"
                    name="jenis_kelamin"
                    required
                >
                    <option value="">-- Pilih --</option>

                    <option
                        value="laki-laki"
                        <?= (($users->jenis_kelamin ?? '') == 'laki-laki') ? 'selected' : '' ?>
                    >
                        Laki-laki
                    </option>

                    <option
                        value="perempuan"
                        <?= (($users->jenis_kelamin ?? '') == 'perempuan') ? 'selected' : '' ?>
                    >
                        Perempuan
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label class="field-label" for="tanggal_lahir_pengguna">Tanggal Lahir</label>
                <input
                    class="field"
                    type="date"
                    id="tanggal_lahir_pengguna"
                    name="tanggal_lahir_pengguna"
                    value="<?= htmlspecialchars($users->tanggal_lahir_pengguna ?? '') ?>"
                    required
                >
            </div>

        </div>


        <!-- ALAMAT -->
        <div class="form-group">
            <label class="field-label" for="alamat">Alamat</label>
            <input
                class="field"
                type="text"
                id="alamat"
                name="alamat"
                value="<?= htmlspecialchars($users->alamat ?? '') ?>"
                required
            >
        </div>


        <!-- PASSWORD -->
        <div class="form-group">
            <label class="field-label" for="password">Password</label>
            <input
                class="field"
                type="password"
                id="password"
                name="password"
                placeholder="Kosongkan jika tidak diubah"
            >
        </div>


        <!-- ROLE -->
        <div class="form-group">
            <label class="field-label" for="role">Role</label>
            <select
                class="field"
                id="role"
                name="role"
                required
            >
                <option value="">-- Pilih Role --</option>

                <option
                    value="admin"
                    <?= (($users->role ?? '') == 'admin') ? 'selected' : '' ?>
                >
                    Admin
                </option>

                <option
                    value="user"
                    <?= (($users->role ?? '') == 'user') ? 'selected' : '' ?>
                >
                    User
                </option>
            </select>
        </div>


        <!-- =================================================
             AKSI
        ================================================== -->

        <div class="aksi">

            <a href="/pinjam_buku/admin/user" class="btn btn-batal">
                Batal
            </a>

            <button type="submit" class="btn btn-simpan">
                Simpan Perubahan
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