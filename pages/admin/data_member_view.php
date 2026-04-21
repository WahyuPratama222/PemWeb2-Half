<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-color-2 fw-bold mb-0">Data Member</h4>
            <small class="text-muted-dark">Semua member terdaftar beserta status membership terakhirnya</small>
        </div>
    </div>

    <?php show_flash(); ?>

    <div class="d-flex flex-column gap-3">

        <?php if (empty($members)): ?>
            <div class="card bg-color-1 border border-secondary text-color-4">
                <div class="card-body text-center py-5 text-muted-dark">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada member terdaftar.
                </div>
            </div>

        <?php else: ?>
            <?php foreach ($members as $m): ?>
                <?php
                $has_membership = !empty($m['id_registration']);
                $status = $m['status'] ?? null;
                $gender_icon = $m['gender'] === 'Laki-Laki' ? 'bi-gender-male' : 'bi-gender-female';
                $gender_color = $m['gender'] === 'Laki-Laki' ? 'text-color-4' : 'text-color-3';
                $days_remaining = ($has_membership && $status === 'active')
                    ? calculateDaysRemaining($m['expiry_date'])
                    : null;
                ?>
                <div class="card bg-color-1 border border-secondary text-color-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-4 flex-wrap">

                            <!-- Avatar + Nama & Email -->
                            <div style="min-width: 200px;">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="bg-color-2 rounded-circle d-flex align-items-center
                                        justify-content-center fw-bold flex-shrink-0" style="color: #fff;"
                                        style="width:36px;height:36px;font-size:.85rem;">
                                        <?= strtoupper(substr($m['member_name'], 0, 1)) ?>
                                    </span>
                                    <div>
                                        <div class="fw-bold small"><?= escape($m['member_name']) ?></div>
                                        <div class="text-muted-dark" style="font-size:.75rem;"><?= escape($m['email']) ?></div>
                                        <div class="text-muted-dark" style="font-size:.7rem;">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            Bergabung <?= date('d M Y', strtotime($m['joined_at'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div style="min-width: 50px;" class="text-center">
                                <i class="bi <?= $gender_icon ?> fs-5 <?= $gender_color ?>"></i>
                                <div class="text-muted-dark" style="font-size:.7rem;"><?= escape($m['gender']) ?></div>
                            </div>

                            <!-- Paket -->
                            <div style="min-width: 160px;">
                                <?php if ($has_membership): ?>
                                    <span class="badge bg-color-2" style="color: #fff;"><?= escape($m['package_name']) ?></span>
                                    <div class="small text-color-2 fw-bold"><?= format_rupiah((float) $m['price']) ?></div>
                                    <div class="text-muted-dark" style="font-size:.7rem;"><?= $m['day_duration'] ?> hari</div>
                                <?php else: ?>
                                    <span class="badge bg-color-1">Belum Daftar Paket</span>
                                    <div class="text-muted-dark mt-1" style="font-size:.72rem;">
                                        <i class="bi bi-info-circle me-1"></i>Belum pernah membeli paket
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Tanggal Membership -->
                            <div class="flex-grow-1">
                                <?php if ($has_membership): ?>
                                    <div class="small text-muted-dark">Mulai:
                                        <span class="text-color-4"><?= format_date($m['start_date']) ?></span>
                                    </div>
                                    <div class="small text-muted-dark">Berakhir:
                                        <span class="text-color-4"><?= format_date($m['expiry_date']) ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="text-muted-dark small">€” Tidak ada data membership €”</div>
                                <?php endif; ?>
                            </div>

                            <!-- Hari Tersisa -->
                            <div style="min-width: 80px;" class="text-center">
                                <?php if ($status === 'active' && $days_remaining !== null): ?>
                                    <div class="fs-5 fw-bold <?= $days_remaining <= 7 ? 'text-color-3' : 'text-success' ?>">
                                        <?= $days_remaining ?>
                                    </div>
                                    <div class="small text-muted-dark">hari tersisa</div>
                                <?php else: ?>
                                    <span class="text-muted-dark small">€”</span>
                                <?php endif; ?>
                            </div>

                            <!-- Status -->
                            <div style="min-width: 100px;" class="text-center">
                                <?php if (!$has_membership): ?>
                                    <span class="badge bg-color-1">Tidak Ada</span>
                                <?php else: ?>
                                    <span class="badge <?= getStatusBadgeClass($status) ?>">
                                        <?= match ($status) {
                                            'active' => 'Aktif',
                                            'expired' => 'Expired',
                                            'pending' => 'Pending',
                                            'cancelled' => 'Dibatalkan',
                                            default => $status
                                        } ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>

