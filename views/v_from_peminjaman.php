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
// CEK ID PENGGUNA
// =====================================================
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: /pinjam_buku/");
    exit;
}

// =====================================================
// PANGGIL MODEL BUKU
// =====================================================
include "../models/m_buku.php";

$buku = new m_buku();

// =====================================================
// AMBIL KODE BUKU
// =====================================================
$kode_buku = $_GET['kode_buku'] ?? '';

if ($kode_buku === '') {
    header("Location: /pinjam_buku/buku");
    exit;
}

// =====================================================
// AMBIL DATA BUKU
// =====================================================
$data = $buku->tampil_data_by_kode($kode_buku);

// =====================================================
// CEK DATA
// =====================================================
if (!$data) {
    echo "<script>
            alert('Data buku tidak ditemukan.');
            window.location='/pinjam_buku/buku';
          </script>";
    exit;
}

$stok = (int) $data->stok;

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Form Pinjam Buku</title>

    <link rel="stylesheet" href="/pinjam_buku/asset/form_pinjam.css?v=5">
</head>

<body>

<!-- BUTTON TEMA -->
<button
    type="button"
    id="theme-toggle"
    class="theme-toggle"
    aria-label="Ganti tema"
    title="Ganti tema"
>🌙</button>


<main class="container">

    <!-- PANEL KIRI -->
    <aside class="form-side">

        <div class="form-side-icon">✓</div>

        <h2>📚 Form Peminjaman Buku</h2>

        <p>
            Silakan isi tanggal dan jumlah buku yang ingin
            kamu pinjam.
        </p>

    </aside>


    <!-- FORM PEMINJAMAN -->
    <form
        class="form-main"
        action="/pinjam_buku/controllers/c_pinjam.php?aksi=pinjam"
        method="POST"
    >

        <h3 class="form-title">Detail Peminjaman</h3>

        <!-- Data tersembunyi -->
        <input type="hidden" name="kode_buku" value="<?= htmlspecialchars($data->kode_buku) ?>">
        <input type="hidden" name="id_pengguna" value="<?= htmlspecialchars($_SESSION['id_pengguna']) ?>">


        <!-- NAMA BUKU -->
        <div class="field">
            <label for="nama_buku">Nama Buku</label>
            <input
                type="text"
                id="nama_buku"
                value="<?= htmlspecialchars($data->nama_buku) ?>"
                readonly
            >
        </div>


        <!-- STOK + JUMLAH -->
        <div class="field-row">

            <div class="field">
                <label for="stok">Stok Tersedia</label>
                <input
                    type="text"
                    id="stok"
                    value="<?= $stok ?>"
                    readonly
                >
            </div>

            <div class="field">
                <label for="jumlah_pinjam">Jumlah Pinjam</label>
                <input
                    type="number"
                    id="jumlah_pinjam"
                    name="jumlah_pinjam"
                    min="1"
                    max="<?= $stok ?>"
                    value="1"
                    required
                >
            </div>

        </div>

        <p class="field-hint">
            <?= $stok > 0
                ? 'Maksimal ' . $stok . ' buku untuk sekali pinjam.'
                : 'Stok buku ini sedang habis.' ?>
        </p>


        <!-- TANGGAL PINJAM -->
        <div class="field">
            <label for="tanggal_pinjam">Tanggal Pinjam</label>
            <input
                type="date"
                id="tanggal_pinjam"
                name="tanggal_pinjam"
                value="<?= date('Y-m-d') ?>"
                required
            >
        </div>


        <!-- TOMBOL -->
        <div class="form-actions">

            <a href="/pinjam_buku/buku" class="btn-batal">Batal</a>

            <button
                type="submit"
                name="pinjam"
                class="btn-submit"
                <?= $stok < 1 ? 'disabled' : '' ?>
            >Ajukan Peminjaman</button>

        </div>

    </form>

</main>


<!-- GLOBAL THEME -->
<script src="/pinjam_buku/asset/theme.js"></script>

</body>
</html>