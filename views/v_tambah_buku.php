<?php

session_start();


// =====================================================
// CEK LOGIN
// =====================================================

if (!isset($_SESSION['role'])) {

    header("Location: /pinjam_buku/");
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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Buku</title>


    <link
        rel="stylesheet"
        href="/pinjam_buku/asset/v_tambah_buku.css?v=4"
    >

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


    <h2>
        📚 Tambah Buku
    </h2>


    <p>
        Masukkan data buku baru ke sistem
    </p>



    <!-- =================================================
         FORM TAMBAH BUKU
    ================================================== -->

    <form
        action="/pinjam_buku/controllers/c_buku.php?aksi=tambah"
        method="post"
    >


        <!-- NAMA BUKU -->

        <label>
            Nama Buku
        </label>

        <input
            type="text"
            name="nama_buku"
            required
        >



        <!-- PENCIPTA -->

        <label>
            Pencipta
        </label>

        <input
            type="text"
            name="pencipta"
            required
        >



        <!-- TANGGAL RILIS -->

        <label>
            Tanggal Rilis
        </label>

        <input
            type="date"
            name="tanggal_rilis"
            required
        >



        <!-- STOK -->

        <label>
            Stok Buku
        </label>

        <input
            type="number"
            name="stok"
            min="0"
            required
        >



        <!-- GAMBAR -->

        <label>
            Link Gambar (URL)
        </label>

        <input
            type="text"
            name="gambar"
            placeholder="https://example.com/cover.jpg"
        >



        <!-- =================================================
             AKSI
        ================================================== -->

        <div class="aksi">


            <button
                type="submit"
                class="btn btn-simpan"
            >

                💾 Simpan

            </button>



            <a
                href="/pinjam_buku/admin/buku"
                class="btn btn-batal"
            >

                ❌ Batal

            </a>


        </div>


    </form>


</div>



<!-- =====================================================
     GLOBAL THEME
====================================================== -->

<script src="/pinjam_buku/asset/theme.js"></script>


</body>

</html>