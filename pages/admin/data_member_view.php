<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-warning fw-bold mb-0">Data Member</h4>
            <small class="text-white-50">Melihat data member gym</small>
        </div>
    </div>

    <?php show_flash(); ?>

    <!-- List Member -->
    <div class="d-flex flex-column gap-3">
        <?php if (empty($members)): ?>
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white">
                <div class="card-body text-center py-5 text-white-50">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada data member
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($members as $reg): ?>
                <?php
                $days_remaining = calculateDaysRemaining($reg['expiry_date']);
                $status_class = getStatusBadgeClass($reg['status']);
                $gender_icon = $reg['gender'] === 'Laki-Laki' ? 'bi-gender-male' : 'bi-gender-female';
                $gender_color = $reg['gender'] === 'Laki-Laki' ? 'text-info' : 'text-danger';
                ?>
                <div class="card bg-secondary bg-opacity-10 border border-secondary text-white">
                    <div class="card-body d-flex align-items-center gap-4">

                        <!-- Avatar + Nama & Email -->
                        <div style="min-width: 200px;">
                            <div class="d-flex align-items-center gap-2">
                                <span
                                    class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                    style="width:32px;height:32px;font-size:.8rem;">
                                    <?= strtoupper(substr($reg['member_name'], 0, 1)) ?>
                                </span>
                                <div>
                                    <div class="fw-bold small"><?= escape($reg['member_name']) ?></div>
                                    <div class="text-white-50" style="font-size:.75rem;"><?= escape($reg['email']) ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div style="min-width: 40px;" class="text-center">
                            <i class="bi <?= $gender_icon ?> fs-5 <?= $gender_color ?>"></i>
                            <div class="text-white-50" style="font-size:.7rem;"><?= escape($reg['gender']) ?></div>
                        </div>

                        <!-- Paket -->
                        <div style="min-width: 140px;">
                            <span class="badge bg-warning text-dark"><?= escape($reg['package_name']) ?></span>
                            <div class="small text-warning fw-bold mt-1"><?= format_rupiah($reg['price']) ?></div>
                        </div>

                        <!-- Tanggal -->
                        <div class="flex-grow-1">
                            <div class="small text-white-50">Mulai: <span
                                    class="text-white"><?= format_date($reg['start_date']) ?></span></div>
                            <div class="small text-white-50">Berakhir: <span
                                    class="text-white"><?= format_date($reg['expiry_date']) ?></span></div>
                        </div>

                        <!-- Hari Tersisa -->
                        <div style="min-width: 80px;" class="text-center">
                            <?php if ($reg['status'] === 'active'): ?>
                                <div class="fs-5 fw-bold <?= $days_remaining <= 7 ? 'text-danger' : 'text-success' ?>">
                                    <?= $days_remaining ?>
                                </div>
                                <div class="small text-white-50">hari tersisa</div>
                            <?php else: ?>
                                <span class="text-white-50 small">—</span>
                            <?php endif; ?>
                        </div>

                        <!-- Status -->
                        <div>
                            <span class="badge <?= $status_class ?>">
                                <?= match ($reg['status']) {
                                    'active' => 'Aktif',
                                    'expired' => 'Expired',
                                    'pending' => 'Pending',
                                    'cancelled' => 'Dibatalkan',
                                    default => $reg['status']
                                } ?>
                            </span>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</div>