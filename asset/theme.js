document.addEventListener("DOMContentLoaded", function () {

    // Ambil tema yang tersimpan
    const savedTheme = localStorage.getItem("theme");

    // Terapkan tema saat halaman dibuka
    if (savedTheme === "dark") {
        document.body.classList.add("dark-mode");
    } else {
        document.body.classList.remove("dark-mode");
    }

    // Cari tombol tema
    const themeToggle = document.getElementById("theme-toggle");

    if (themeToggle) {

        // Atur icon sesuai tema
        themeToggle.textContent =
            savedTheme === "dark" ? "☀️" : "🌙";

        // Saat tombol ditekan
        themeToggle.addEventListener("click", function () {

            document.body.classList.toggle("dark-mode");

            if (document.body.classList.contains("dark-mode")) {

                localStorage.setItem("theme", "dark");
                themeToggle.textContent = "☀️";

            } else {

                localStorage.setItem("theme", "light");
                themeToggle.textContent = "🌙";

            }
        });
    }
});