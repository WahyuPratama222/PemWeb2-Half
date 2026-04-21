<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-color-2 fw-bold mb-0">Dashboard Admin</h4>
            <small class="text-muted-dark">
                Selamat datang, <?= escape(current_user()['name']) ?>
            </small>
        </div>
        <span class="text-muted-dark small"><?= date('d F Y') ?></span>
    </div>

    <?php show_flash(); ?>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-4">
            <div class="card bg-color-1 border border-secondary text-color-4 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-primary bg-opacity-25">
                        <i class="bi bi-people-fill fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $summary['total_members'] ?></div>
                        <div class="small text-muted-dark">Total Member</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card bg-color-1 border border-secondary text-color-4 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-success bg-opacity-25">
                        <i class="bi bi-patch-check-fill fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $summary['active_memberships'] ?></div>
                        <div class="small text-muted-dark">Membership Aktif</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card bg-color-1 border border-secondary text-color-4 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-color-2 bg-opacity-25">
                        <i class="bi bi-currency-dollar fs-4 text-color-2"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= format_rupiah($summary['income_today']) ?></div>
                        <div class="small text-muted-dark">Pendapatan Hari Ini</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Row 2: Ringkasan + Aksi Cepat -->
    <div class="row g-3">

        <div class="col-md-6">
            <div class="card bg-color-1 border border-secondary text-color-4 h-100">
                <div class="card-body p-4">
                    <h6 class="text-muted-dark mb-3">
                        <i class="bi bi-graph-up me-2"></i>Ringkasan Bulan Ini
                    </h6>
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between border-bottom border-secondary pb-2">
                            <span class="text-muted-dark small">Pendapatan</span>
                            <span
                                class="fw-bold text-color-2"><?= format_rupiah($summary['income_this_month']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom border-secondary pb-2">
                            <span class="text-muted-dark small">Paket Tersedia</span>
                            <span class="fw-bold text-color-4"><?= $summary['active_packages'] ?> Paket Aktif</span>
                        </div>
                        <div class="d-flex justify-content-between pt-1">
                            <span class="text-muted-dark small">Membership Kedaluwarsa</span>
                            <span class="fw-bold text-color-3"><?= $summary['expired_memberships'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-color-1 border border-secondary text-color-4 h-100">
                <div class="card-body p-4">
                    <h6 class="text-muted-dark mb-3">
                        <i class="bi bi-hourglass-split me-2"></i>Pembayaran Pending
                    </h6>

                            <?php if (empty($pending_payments)): ?>
                        <div class="text-center py-3 text-muted-dark">
                            <i class="bi bi-check-circle fs-3 d-block mb-2 text-success"></i>
                            <small>Semua pembayaran sudah lunas</small>
                        </div>
                            <?php else: ?>
                        <div class="d-flex flex-column gap-0">
                                    <?php foreach ($pending_payments as $i => $pp): ?>
                                <div
                                    class="d-flex align-items-center gap-3 py-2 <?= $i < count($pending_payments) - 1 ? 'border-bottom border-secondary' : '' ?>">
                                    <span
                                        class="bg-color-2 rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                        style="width:30px;height:30px;font-size:.75rem; color: #fff;">
                                                <?= strtoupper(substr($pp['member_name'], 0, 1)) ?>
                                    </span>
                                    <div class="flex-grow-1">
                                        <div class="small fw-semibold"><?= escape($pp['member_name']) ?></div>
                                        <div class="text-muted-dark" style="font-size:.72rem;"><?= escape($pp['package_name']) ?>
                                        </div>
                                    </div>
                                    <div class="text-color-2 fw-bold small"><?= format_rupiah((float) $pp['amount']) ?></div>
                                </div>
                                    <?php endforeach; ?>
                        </div>
                        <div class="mt-3">
                            <a href="<?= BASE_URL ?>controllers/admin/payments_admin.php"
                                class="btn btn-outline-color-2 btn-sm rounded-pill px-3">
                                <i class="bi bi-arrow-right me-1"></i>Lihat Semua
                            </a>
                        </div>
                            <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

</div>

