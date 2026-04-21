<!-- Fungsinya untuk menampilkan halaman yang sedang aktif di navbar -->
<?php $current_page = basename($_SERVER['PHP_SELF'], '.php'); ?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-color-1 border-bottom shadow-sm" style="border-color: #e5e7eb !important;">
    <div class="container">

        <!-- Logo -->
        <div class="navbar-brand fw-bold text-color-2">
            <i class="bi bi-trophy-fill me-1"></i>
            <span class="text-color-2">Gymku</span>
        </div>

        <!-- Tombol toggle untuk mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" style="border-color: rgba(29,36,43,0.12) !important;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Konten navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">

                <!-- Tombol Login -->
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-color-2 rounded-pill px-3 <?= $current_page === 'login' ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>controllers/auth/login.php">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                </li>

                <!-- Tombol Regist -->
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-color-2 rounded-pill px-3 <?= $current_page === 'regist' ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>controllers/auth/regist.php">
                        <i class="bi bi-person-plus-fill me-1"></i> Regist
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
