<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Perpustakaan</title>

    <!-- CSS LOGIN -->
    <link rel="stylesheet" href="/pinjam_buku/asset/login.css?v=3">
</head>

<body>

    <div class="login-card">

        <!-- TOMBOL LIGHT / DARK MODE -->
        <button
            type="button"
            id="theme-toggle"
            class="theme-toggle"
            aria-label="Ganti tema">
            🌙
        </button>


        <!-- JUDUL -->
        <h2>📚 Perpustakaan</h2>

        <p>Sistem Peminjaman Buku</p>


        <!-- FORM LOGIN -->
        <form
            method="POST"
            action="/pinjam_buku/controllers/c_login.php">

            <input
                type="text"
                name="username_email"
                placeholder="Username atau Email"
                autocomplete="username"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                autocomplete="current-password"
                required
            >

            <button
                type="submit"
                name="login">
                Masuk
            </button>

        </form>


        <!-- LINK PENDAFTARAN -->
        <div class="register-link">
            Belum punya akun?

            <a href="/pinjam_buku/daftar">
                Daftar di sini
            </a>
        </div>


        <!-- FOOTER -->
        <div class="footer">
            © <?= date('Y'); ?> Perpustakaan
        </div>

    </div>


    <!-- JAVASCRIPT -->
   <script src="/pinjam_buku/asset/theme.js"></script>

</body>

</html>

