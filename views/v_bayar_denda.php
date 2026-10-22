<?php

session_start();


// =========================================================
// CEK LOGIN
// =========================================================

if (!isset($_SESSION['role'])) {

    header("Location: /pinjam_buku/index.php");
    exit;
}


// =========================================================
// HANYA USER
// =========================================================

if ($_SESSION['role'] !== 'user') {

    header("Location: /pinjam_buku/admin");
    exit;
}


require_once "../models/m_denda.php";

$denda_model = new m_denda();


// =========================================================
// SESSION USER
// =========================================================

$id_pengguna = $_SESSION['id_pengguna'] ?? 0;

$id_pengguna = (int) $id_pengguna;


if ($id_pengguna <= 0) {

    header("Location: /pinjam_buku/index.php");
    exit;
}


// =========================================================
// AMBIL ID DENDA
// =========================================================

$id_denda = $_GET['id_denda'] ?? 0;

$id_denda = (int) $id_denda;


if ($id_denda <= 0) {

    echo "<script>
            alert('Denda tidak ditemukan.');
            window.location='/pinjam_buku/denda';
          </script>";

    exit;
}


// =========================================================
// AMBIL HANYA DENDA MILIK USER
// =========================================================

$data_denda = null;

$semua_denda =
    $denda_model->tampil_denda_user(
        $id_pengguna
    );


foreach ($semua_denda as $data) {

    if ((int) $data->id_denda === $id_denda) {

        $data_denda = $data;

        break;
    }
}


// =========================================================
// CEK DENDA
// =========================================================

if (!$data_denda) {

    echo "<script>
            alert('Denda tidak ditemukan atau denda tersebut bukan milik akun kamu.');
            window.location='/pinjam_buku/denda';
          </script>";

    exit;
}


// =========================================================
// JIKA SUDAH LUNAS
// =========================================================

if ($data_denda->status_pembayaran === 'lunas') {

    echo "<script>
            alert('Denda ini sudah lunas.');
            window.location='/pinjam_buku/denda';
          </script>";

    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bayar Denda - Perpustakaan</title>

    <link rel="stylesheet" href="/pinjam_buku/asset/denda_bayar.css?v=3">

</head>

<body>


<!-- =====================================================
     NAVBAR
====================================================== -->

<nav class="navbar">

    <!-- LOGO -->
    <a href="/pinjam_buku/dashboard" class="navbar-logo">

        <span class="logo-icon">📚</span>

        <span class="logo-text">Perpustakaan</span>

    </a>


    <!-- MENU -->
    <div class="nav-menu">

        <a href="/pinjam_buku/denda" class="nav-link active">
            💰
            <span>Denda</span>
        </a>

        <!-- BUTTON TEMA -->
        <button
            type="button"
            id="theme-toggle"
            class="theme-toggle"
            aria-label="Ganti tema"
            title="Ganti tema"
        >
            🌙
        </button>

    </div>

</nav>


<!-- =====================================================
     FORM PEMBAYARAN
====================================================== -->

<main class="payment-container">

    <div class="payment-card">


        <!-- =================================================
             HEADER
        ================================================== -->

        <div class="payment-header">

            <span class="payment-icon">💳</span>

            <h1>Bayar Denda</h1>

            <p>Konfirmasi pembayaran denda kamu</p>

        </div>


        <!-- =================================================
             DETAIL BUKU
        ================================================== -->

        <div class="payment-book">

            <?php if (!empty($data_denda->gambar)): ?>

                <img
                    src="<?= htmlspecialchars($data_denda->gambar) ?>"
                    alt="<?= htmlspecialchars($data_denda->nama_buku) ?>"
                >

            <?php else: ?>

                <div class="book-placeholder">📖</div>

            <?php endif; ?>


            <div class="book-info">

                <span>Buku</span>

                <h3>
                    <?= htmlspecialchars($data_denda->nama_buku) ?>
                </h3>

                <p>
                    Jenis Denda:

                    <strong>
                        <?= htmlspecialchars($data_denda->nama_kategori) ?>
                    </strong>
                </p>

            </div>

        </div>


        <!-- =================================================
             TOTAL DENDA
        ================================================== -->

        <div class="payment-total">

            <div>
                <span>Total Denda</span>
                <small>Jumlah yang harus dibayar</small>
            </div>

            <strong>
                Rp
                <?= number_format(
                    (float) $data_denda->jumlah_denda,
                    0,
                    ',',
                    '.'
                ) ?>
            </strong>

        </div>


        <!-- =================================================
             FORM PEMBAYARAN
             (path absolut supaya tetap jalan di URL /denda/bayar)
        ================================================== -->

        <form
            action="/pinjam_buku/controllers/c_bayar_denda.php"
            method="POST"
            onsubmit="return konfirmasiBayar();"
        >

            <input
                type="hidden"
                name="id_denda"
                value="<?= (int) $data_denda->id_denda ?>"
            >


            <!-- NAMA PENGGUNA + METODE (sebaris) -->
            <div class="form-row">

                <div class="form-group">
                    <label for="nama_pengguna">Nama Pengguna</label>
                    <input
                        type="text"
                        id="nama_pengguna"
                        value="<?= htmlspecialchars($_SESSION['nama_pengguna'] ?? '') ?>"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label for="metode_pembayaran">Metode Pembayaran</label>
                    <select
                        id="metode_pembayaran"
                        name="metode_pembayaran"
                        required
                    >
                        <option value="">-- Pilih Metode Pembayaran --</option>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer">Transfer</option>
                    </select>
                </div>

            </div>


            <!-- KETERANGAN -->
            <div class="form-group">
                <label for="keterangan_pembayaran">Keterangan Pembayaran</label>
                <textarea
                    id="keterangan_pembayaran"
                    name="keterangan_pembayaran"
                    rows="4"
                    placeholder="Contoh: Saya sudah melakukan pembayaran denda."
                ></textarea>
            </div>


            <!-- KONFIRMASI -->
            <label class="checkbox-confirm">

                <input type="checkbox" required>

                <span>
                    Saya menyatakan bahwa pembayaran denda
                    ini benar-benar telah dilakukan.
                </span>

            </label>


            <!-- ACTION -->
            <div class="payment-actions">

                <a href="/pinjam_buku/denda" class="btn-cancel">
                    ← Batal
                </a>

                <button
                    type="submit"
                    name="bayar_denda"
                    class="btn-confirm"
                >
                    💳 Konfirmasi Pembayaran
                </button>

            </div>

        </form>

    </div>

</main>


<!-- =====================================================
     JAVASCRIPT KONFIRMASI
====================================================== -->

<script>

function konfirmasiBayar()
{
    return confirm(
        "Apakah kamu yakin pembayaran denda ini sudah dilakukan?"
    );
}

</script>


<!-- =====================================================
     GLOBAL THEME
====================================================== -->

<script src="/pinjam_buku/asset/theme.js"></script>

</body>
</html>