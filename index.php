<?php
require_once __DIR__ . '/core/init.php';
$page_title = 'Beranda';
require_once __DIR__ . '/includes/header.php';
?>

<main class="container py-5">

    <!-- Hero -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold section-title">
            Selamat Datang di <span class="text-gradient">GymSystem</span> 💪
        </h1>
        <p class="text-muted lead mt-2">Platform manajemen gym terpadu untuk member dan admin.</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="auth/login.php" class="btn btn-primary-gym px-4">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </a>
            <a href="auth/regist.php" class="btn btn-outline-gym px-4">
                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
            </a>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-gym p-4 text-center h-100">
                <div class="icon-circle mx-auto">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h5 class="fw-bold section-title">Manajemen Member</h5>
                <p class="text-muted small">Kelola data member, paket, dan masa aktif keanggotaan dengan mudah.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-gym p-4 text-center h-100">
                <div class="icon-circle mx-auto">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h5 class="fw-bold section-title">Tracking Progress</h5>
                <p class="text-muted small">Pantau perkembangan fisik member secara berkala dan terstruktur.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-gym p-4 text-center h-100">
                <div class="icon-circle mx-auto">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h5 class="fw-bold section-title">Laporan Keuangan</h5>
                <p class="text-muted small">Rekap pendapatan harian dan bulanan secara otomatis dan akurat.</p>
            </div>
        </div>
    </div>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>