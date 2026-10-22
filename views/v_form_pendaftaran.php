<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Akun Perpustakaan</title>

    <link rel="stylesheet" href="/pinjam_buku/asset/form_daftar.css?v=4">
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


<main class="register-card">

    <!-- PANEL KIRI -->
    <aside class="register-side">

        <div class="register-side-icon">👤</div>

        <h2>📚 Daftar Akun</h2>

        <p>Perpustakaan - Sistem Peminjaman Buku</p>

    </aside>


    <!-- AREA FORM -->
    <div class="register-main">

        <form
            class="register-form"
            method="POST"
            action="/pinjam_buku/controllers/c_pengguna.php?aksi=tambah"
        >

            <h3 class="form-title">Buat Akun</h3>


            <!-- USERNAME -->
            <div class="field">
                <label for="nama_pengguna">Username</label>
                <input
                    type="text"
                    id="nama_pengguna"
                    name="nama_pengguna"
                    placeholder="Masukkan username"
                    autocomplete="username"
                    required
                >
            </div>


            <!-- EMAIL -->
            <div class="field">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="nama@email.com"
                    autocomplete="email"
                    required
                >
            </div>


            <!-- JENIS KELAMIN + TANGGAL LAHIR -->
            <div class="field-row">

                <div class="field">
                    <span class="field-label" id="label-jk">Jenis Kelamin</span>

                    <div class="radio-group" role="radiogroup" aria-labelledby="label-jk">

                        <label>
                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="Laki-laki"
                                required
                            >
                            Laki-laki
                        </label>

                        <label>
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

                <div class="field">
                    <label for="tanggal_lahir_pengguna">Tanggal Lahir</label>
                    <input
                        type="date"
                        id="tanggal_lahir_pengguna"
                        name="tanggal_lahir_pengguna"
                        required
                    >
                </div>

            </div>


            <!-- ALAMAT -->
            <div class="field">
                <label for="alamat">Alamat</label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="3"
                    placeholder="Masukkan alamat lengkap"
                    required
                ></textarea>
            </div>


            <!-- PASSWORD -->
            <div class="field">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="new-password"
                    required
                >
            </div>


            <!-- ROLE -->
            <input type="hidden" name="role" value="user">


            <!-- TOMBOL -->
            <div class="form-actions">

                <button type="submit" name="tambah" class="btn-submit">Daftar</button>

            </div>

        </form>


        <!-- LINK LOGIN -->
        <div class="login-link">
            Sudah punya akun?
            <a href="/pinjam_buku/">Login di sini</a>
        </div>

    </div>

</main>


<!-- GLOBAL THEME -->
<script src="/pinjam_buku/asset/theme.js"></script>

</body>
</html>