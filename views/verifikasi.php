<?php

session_start();

if (!isset($_SESSION['role'])) {
    header("Location: /pinjam_buku/index.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: /pinjam_buku/dashboard");
    exit;
}

include "../models/m_pinjam.php";

$pinjam = new m_pinjam();

$id_pinjam = $_GET['id'];

$data = $pinjam->tampil_pinjam_by_id($id_pinjam);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Pinjaman</title>

    <link rel="stylesheet" href="/pinjam_buku/asset/verifikasi.css?v=4">

</head>

<body>

<div class="container">

    <!-- TOMBOL TEMA -->
    <button
        type="button"
        id="theme-toggle"
        class="theme-toggle"
        aria-label="Ganti tema"
        title="Ganti tema"
    >
        🌙
    </button>

    <h2>📚 Form Verifikasi Pinjaman</h2>

    <p>
        Periksa informasi peminjaman sebelum menentukan
        tanggal pengembalian buku.
    </p>


    <!-- (path absolut supaya tetap jalan di URL pretty) -->
    <form
        action="/pinjam_buku/controllers/c_proses_verifikasi.php"
        method="POST"
    >

        <input
            type="hidden"
            name="id_pinjam"
            value="<?= htmlspecialchars($data->id_pinjam) ?>"
        >


        <!-- INFORMASI PEMINJAMAN -->
        <div class="info-box">

            <p>
                <strong>Kode Buku:</strong>
                <?= htmlspecialchars($data->kode_buku) ?>
            </p>

            <p>
                <strong>Tanggal Pinjam:</strong>
                <?= htmlspecialchars($data->tanggal_pinjam) ?>
            </p>

            <p>
                <strong>Jumlah Pinjam:</strong>
                <?= htmlspecialchars($data->jumlah_pinjam) ?>
            </p>

        </div>


        <!-- TANGGAL KEMBALI -->
        <div class="form-group">
            <label class="field-label" for="tanggal_kembali">Tanggal Kembali</label>
            <input
                class="field"
                type="date"
                id="tanggal_kembali"
                name="tanggal_kembali"
                required
            >
        </div>


        <!-- AKSI -->
        <div class="aksi">

            <a href="/pinjam_buku/admin/pengajuan" class="btn btn-batal">
                Batal
            </a>

            <button type="submit" class="btn btn-simpan">
                Konfirmasi Verifikasi
            </button>

        </div>

    </form>

</div>

<script src="/pinjam_buku/asset/theme.js"></script>

</body>
</html>