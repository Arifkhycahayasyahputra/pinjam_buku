<?php

session_start();

if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'admin'
) {
    header("Location: v_dasbord_user.php");
    exit;
}

$id_pinjam =
    $_GET['id_pinjam'] ?? '';

if (empty($id_pinjam)) {

    echo "<script>

        alert('ID peminjaman tidak ditemukan!');

        window.location='v_riwayat_peminjaman_buku.php';

    </script>";

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

<title>Tambah Denda</title>

<link
    rel="stylesheet"
    href="/pinjam_buku/asset/denda_admin.css?v=3"
>

</head>


<body>


<!-- =====================================================
     TOMBOL TEMA
===================================================== -->

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
===================================================== -->

<div class="container">


    <!-- =================================================
         JUDUL
    ================================================== -->

    <h2>
        💰 Tambah Denda Buku
    </h2>


    <!-- =================================================
         DESKRIPSI
    ================================================== -->

    <p>
        Tambahkan denda untuk buku yang mengalami
        kerusakan atau kehilangan.
    </p>


    <!-- =================================================
         FORM
    ================================================== -->

    <form
        action="../controllers/c_denda.php?aksi=tambah"
        method="POST"
    >


        <!-- ID PEMINJAMAN -->

        <div class="info">

            <p>

                ID Peminjaman:

                <strong>
                    #<?= htmlspecialchars($id_pinjam) ?>
                </strong>

            </p>

            <p>

                Denda
                <strong>terlambat</strong>
                dihitung otomatis oleh sistem.

            </p>

            <p>

                Form ini digunakan untuk denda
                <strong>rusak</strong>
                atau
                <strong>hilang</strong>.

            </p>

        </div>


        <!-- INPUT ID -->

        <input
            type="hidden"
            name="id_pinjam"
            value="<?= htmlspecialchars($id_pinjam) ?>"
        >


        <!-- JENIS DENDA -->

        <label>
            Jenis Denda
        </label>

        <select
            name="kategori"
            required
        >

            <option value="">
                -- Pilih Jenis Denda --
            </option>

            <option value="Rusak">
                Buku Rusak
            </option>

            <option value="Hilang">
                Buku Hilang
            </option>

        </select>


        <!-- NOMINAL -->

        <label>
            Nominal Denda
        </label>

        <input
            type="text"
            name="jumlah_denda"
            placeholder="Contoh: 10000"
            required
        >


        <!-- KETERANGAN -->

        <label>
            Keterangan
        </label>

        <textarea
            name="keterangan"
            placeholder="Contoh: Sampul buku rusak..."
        ></textarea>


        <!-- TOMBOL -->

        <button
            type="submit"
            class="btn"
        >
            💾 Simpan Denda
        </button>


    </form>


    <!-- =================================================
         KEMBALI
    ================================================== -->

    <a
        href="/pinjam_buku/admin/riwayat"
        class="back"
    >
        ← Kembali ke Riwayat
    </a>


</div>


<!-- =====================================================
     THEME JS
===================================================== -->

<script src="/pinjam_buku/asset/theme.js"></script>


</body>
</html>