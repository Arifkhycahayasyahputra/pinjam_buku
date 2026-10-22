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

    <title>Edit Buku</title>

    <link rel="stylesheet" href="/pinjam_buku/asset/edit_buku.css?v=6">

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
     CONTAINER
====================================================== -->

<div class="container">

    <h2>✏️ Edit Buku</h2>

    <p>Perbarui data buku</p>


    <!-- =================================================
         FORM EDIT BUKU
         (path absolut supaya tetap jalan di URL /admin/buku/edit)
    ================================================== -->

    <form
        action="/pinjam_buku/controllers/c_buku.php?aksi=update"
        method="post"
    >

        <!-- KODE BUKU (tersembunyi) -->
        <input
            type="hidden"
            name="kode_buku"
            value="<?= htmlspecialchars($data->kode_buku ?? '') ?>"
        >


        <!-- NAMA BUKU -->
        <div class="form-group">
            <label for="nama_buku">Nama Buku</label>
            <input
                type="text"
                id="nama_buku"
                name="nama_buku"
                value="<?= htmlspecialchars($data->nama_buku ?? '') ?>"
                required
            >
        </div>


        <!-- PENCIPTA -->
        <div class="form-group">
            <label for="pencipta">Pencipta</label>
            <input
                type="text"
                id="pencipta"
                name="pencipta"
                value="<?= htmlspecialchars($data->pencipta ?? '') ?>"
                required
            >
        </div>


        <!-- TANGGAL RILIS + STOK (sebaris) -->
        <div class="form-row">

            <div class="form-group">
                <label for="tanggal_rilis">Tanggal Rilis</label>
                <input
                    type="date"
                    id="tanggal_rilis"
                    name="tanggal_rilis"
                    value="<?= htmlspecialchars($data->tanggal_rilis ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="stok">Stok Buku</label>
                <input
                    type="number"
                    id="stok"
                    name="stok"
                    min="0"
                    value="<?= (int) ($data->stok ?? 0) ?>"
                    required
                >
            </div>

        </div>


        <!-- LINK GAMBAR -->
        <div class="form-group">
            <label for="gambar">Link Gambar (URL)</label>
            <input
                type="text"
                id="gambar"
                name="gambar"
                value="<?= htmlspecialchars($data->gambar ?? '') ?>"
                placeholder="https://example.com/cover.jpg"
            >
        </div>


        <!-- =================================================
             AKSI
        ================================================== -->

        <div class="aksi">

            <a href="/pinjam_buku/admin/buku" class="btn btn-batal">
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