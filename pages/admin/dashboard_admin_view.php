<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-warning fw-bold mb-0">Dashboard Admin</h4>
            <small class="text-white-50">
                Selamat datang, <?= escape(current_user()['name']) ?>
            </small>
        </div>
        <span class="text-white-50 small"><?= date('d F Y') ?></span>
    </div>

    <?php show_flash(); ?>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-primary bg-opacity-25">
                        <i class="bi bi-people-fill fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $summary['total_members'] ?></div>
                        <div class="small text-white-50">Total Member</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-success bg-opacity-25">
                        <i class="bi bi-patch-check-fill fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $summary['active_memberships'] ?></div>
                        <div class="small text-white-50">Membership Aktif</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-warning bg-opacity-25">
                        <i class="bi bi-currency-dollar fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= format_rupiah($summary['income_today']) ?></div>
                        <div class="small text-white-50">Pendapatan Hari Ini</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-info bg-opacity-25">
                        <i class="bi bi-box-arrow-in-right fs-4 text-info"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $summary['checkins_today'] ?></div>
                        <div class="small text-white-50">Check-in Hari Ini</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Row 2: Ringkasan + Aksi Cepat -->
    <div class="row g-3">

        <div class="col-md-6">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body p-4">
                    <h6 class="text-white-50 mb-3">
                        <i class="bi bi-graph-up me-2"></i>Ringkasan Bulan Ini
                    </h6>
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between border-bottom border-secondary pb-2">
                            <span class="text-white-50 small">Pendapatan</span>
                            <span class="fw-bold text-warning"><?= format_rupiah($summary['income_this_month']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom border-secondary pb-2">
                            <span class="text-white-50 small">Paket Tersedia</span>
                            <span class="fw-bold text-white"><?= $summary['active_packages'] ?> Paket Aktif</span>
                        </div>
                        <div class="d-flex justify-content-between pt-1">
                            <span class="text-white-50 small">Membership Kedaluwarsa</span>
                            <span class="fw-bold text-danger"><?= $summary['expired_memberships'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body p-4">
                    <h6 class="text-white-50 mb-3">
                        <i class="bi bi-lightning-fill me-2"></i>Aksi Cepat
                    </h6>
                    <div class="d-grid gap-2">
                        <a href="<?= BASE_URL ?>controllers/admin/registrations_admin.php"
                            class="btn btn-outline-warning btn-sm text-start text-white">
                            <i class="bi bi-people me-2"></i>Kelola Member
                        </a>
                        <a href="<?= BASE_URL ?>controllers/admin/packages_admin.php"
                            class="btn btn-outline-warning btn-sm text-start text-white">
                            <i class="bi bi-tags me-2"></i>Kelola Paket
                        </a>
                        <a href="<?= BASE_URL ?>controllers/admin/payments_admin.php"
                            class="btn btn-outline-warning btn-sm text-start text-white">
                            <i class="bi bi-credit-card me-2"></i>Data Pembayaran
                        </a>
                        <a href="<?= BASE_URL ?>controllers/admin/attendance_admin.php"
                            class="btn btn-outline-warning btn-sm text-start text-white">
                            <i class="bi bi-calendar-check me-2"></i>Data Absensi
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>