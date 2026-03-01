<div class="container-fluid py-4">

    <!-- ── Header ── -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-warning fw-bold mb-0">Dashboard Member</h4>
            <small class="text-white-50">
                Selamat datang, <?= escape(current_user()['name']) ?>
            </small>
        </div>
        <span class="text-white-50"><?= date('d F Y') ?></span>
    </div>

    <?php show_flash(); ?>

    <!-- ── Stat Cards ── -->
    <div class="row g-3 mb-4">

        <!-- Status Membership -->
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 <?= $active_membership ? 'bg-success bg-opacity-25' : 'bg-danger bg-opacity-25' ?>">
                        <i class="bi bi-patch-check-fill fs-4 <?= $active_membership ? 'text-success' : 'text-danger' ?>"></i>
                    </div>
                    <div>
                        <div class="fs-5 fw-bold">
                            <?= $active_membership ? 'Aktif' : 'Tidak Aktif' ?>
                        </div>
                        <div class="small text-white-50">Status Membership</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hari Tersisa -->
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-warning bg-opacity-25">
                        <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $active_membership ? $days_remaining : '-' ?></div>
                        <div class="small text-white-50">Hari Tersisa</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Check-in Bulan Ini -->
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-info bg-opacity-25">
                        <i class="bi bi-calendar-check-fill fs-4 text-info"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $checkins_this_month ?></div>
                        <div class="small text-white-50">Check-in Bulan Ini</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Check-in -->
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-primary bg-opacity-25">
                        <i class="bi bi-person-check-fill fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $total_checkins ?></div>
                        <div class="small text-white-50">Total Check-in</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ── Membership Aktif + Paket Tersedia ── -->
    <div class="row g-3 mb-4">

        <!-- Info Membership Aktif -->
        <div class="col-md-5">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body">
                    <h6 class="text-white-50 mb-3">
                        <i class="bi bi-patch-check me-2"></i>Membership Aktif Saya
                    </h6>

                    <?php if ($active_membership): ?>
                        <div class="d-flex flex-column gap-2">

                            <div class="p-3 rounded-3 border border-success border-opacity-25 bg-success bg-opacity-10">
                                <div class="fw-bold text-warning fs-6 mb-1">
                                    <?= escape($active_membership['package_name']) ?>
                                </div>
                                <div class="small text-white-50 mb-2">
                                    <?= escape($active_membership['day_duration']) ?> hari
                                    · <?= format_rupiah((float)$active_membership['price']) ?>
                                </div>

                                <div class="d-flex justify-content-between small">
                                    <span class="text-white-50">Mulai</span>
                                    <span class="text-white"><?= format_date($active_membership['start_date']) ?></span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-white-50">Berakhir</span>
                                    <span class="text-white"><?= format_date($active_membership['expiry_date']) ?></span>
                                </div>
                                <div class="d-flex justify-content-between small mt-1">
                                    <span class="text-white-50">Sisa</span>
                                    <span class="fw-bold <?= $days_remaining <= 7 ? 'text-danger' : 'text-success' ?>">
                                        <?= $days_remaining ?> hari
                                    </span>
                                </div>

                                <!-- Progress bar hari tersisa -->
                                <?php
                                    $total_days = (int)$active_membership['day_duration'];
                                    $percent    = $total_days > 0
                                        ? max(0, min(100, round(($days_remaining / $total_days) * 100)))
                                        : 0;
                                    $bar_color  = $percent > 50 ? 'bg-success' : ($percent > 20 ? 'bg-warning' : 'bg-danger');
                                ?>
                                <div class="progress mt-2" style="height:6px;">
                                    <div class="progress-bar <?= $bar_color ?>"
                                         style="width: <?= $percent ?>%"></div>
                                </div>
                            </div>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-x-circle text-danger fs-1 mb-2 d-block"></i>
                            <p class="text-white-50 small mb-3">Kamu belum memiliki membership aktif.</p>
                            <a href="#paketGym" class="btn btn-warning btn-sm fw-bold text-dark">
                                <i class="bi bi-tags me-1"></i> Lihat Paket
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Riwayat Pendaftaran -->
        <div class="col-md-7">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body">
                    <h6 class="text-white-50 mb-3">
                        <i class="bi bi-clock-history me-2"></i>Riwayat Pendaftaran
                    </h6>

                    <?php if (empty($all_registrations)): ?>
                        <p class="text-white-50 small">Belum ada riwayat pendaftaran.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-dark table-sm table-borderless mb-0">
                                <thead>
                                    <tr class="text-white-50 small">
                                        <th>Paket</th>
                                        <th>Mulai</th>
                                        <th>Berakhir</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($all_registrations as $reg): ?>
                                        <tr>
                                            <td class="fw-semibold small"><?= escape($reg['package_name']) ?></td>
                                            <td class="small text-white-50"><?= format_date($reg['start_date']) ?></td>
                                            <td class="small text-white-50"><?= format_date($reg['expiry_date']) ?></td>
                                            <td>
                                                <?php
                                                    $badge = match($reg['status']) {
                                                        'active'    => ['bg-success', 'Aktif'],
                                                        'expired'   => ['bg-secondary', 'Kadaluarsa'],
                                                        'pending'   => ['bg-warning text-dark', 'Pending'],
                                                        'cancelled' => ['bg-danger', 'Dibatalkan'],
                                                        default     => ['bg-secondary', $reg['status']],
                                                    };
                                                ?>
                                                <span class="badge <?= $badge[0] ?>"><?= $badge[1] ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>

    <!-- ── Riwayat Check-in + Pembayaran Terakhir ── -->
    <div class="row g-3 mb-5">

        <!-- Riwayat Absensi Terakhir -->
        <div class="col-md-6">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body">
                    <h6 class="text-white-50 mb-3">
                        <i class="bi bi-calendar-week me-2"></i>5 Check-in Terakhir
                    </h6>

                    <?php if (empty($recent_attendance)): ?>
                        <p class="text-white-50 small">Belum ada data absensi.</p>
                    <?php else: ?>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            <?php foreach ($recent_attendance as $att): ?>
                                <li class="d-flex justify-content-between align-items-center
                                            border-bottom border-secondary pb-2">
                                    <div>
                                        <div class="small fw-semibold">
                                            <?= date('d M Y', strtotime($att['check_in'])) ?>
                                        </div>
                                        <div class="text-white-50" style="font-size:.75rem;">
                                            Check-in: <?= date('H:i', strtotime($att['check_in'])) ?>
                                            <?php if ($att['check_out']): ?>
                                                · Check-out: <?= date('H:i', strtotime($att['check_out'])) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Riwayat Pembayaran Terakhir -->
        <div class="col-md-6">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body">
                    <h6 class="text-white-50 mb-3">
                        <i class="bi bi-receipt me-2"></i>Pembayaran Terakhir
                    </h6>

                    <?php if (empty($recent_payments)): ?>
                        <p class="text-white-50 small">Belum ada riwayat pembayaran.</p>
                    <?php else: ?>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            <?php foreach ($recent_payments as $pay): ?>
                                <li class="d-flex justify-content-between align-items-center
                                            border-bottom border-secondary pb-2">
                                    <div>
                                        <div class="small fw-semibold"><?= escape($pay['package_name']) ?></div>
                                        <div class="text-white-50" style="font-size:.75rem;">
                                            <?= date('d M Y', strtotime($pay['payment_date'])) ?>
                                            · <?= escape($pay['payment_method']) ?>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="small fw-bold text-warning">
                                            <?= format_rupiah((float)$pay['amount']) ?>
                                        </div>
                                        <?php
                                            $badge = match($pay['payment_status']) {
                                                'Lunas'       => 'bg-success',
                                                'Belum Lunas' => 'bg-warning text-dark',
                                                'Gagal'       => 'bg-danger',
                                                default       => 'bg-secondary',
                                            };
                                        ?>
                                        <span class="badge <?= $badge ?> mt-1" style="font-size:.65rem;">
                                            <?= escape($pay['payment_status']) ?>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>

    <!-- ── Penawaran Paket Gym ── -->
    <div id="paketGym" class="mb-2">
        <h5 class="text-white fw-bold mb-1">
            <i class="bi bi-tags-fill text-warning me-2"></i>
            Paket <span class="text-warning">Gym</span> Tersedia
        </h5>
        <p class="text-white-50 small mb-4">Pilih paket yang sesuai dengan kebutuhanmu dan daftar sekarang.</p>
    </div>

    <?php if (empty($packages)): ?>
        <div class="alert alert-warning text-dark-50">Belum ada paket tersedia saat ini.</div>
    <?php else: ?>
        <div class="row g-3 pb-4">
            <?php foreach ($packages as $i => $pkg): ?>
                <?php $is_featured = $i === 1; /* paket tengah = featured */ ?>
                <div class="col-md-4">
                    <div class="card text-white h-100
                                bg-secondary bg-opacity-10 border
                                <?= $is_featured ? 'border-warning border-2 shadow-lg' : 'border-secondary' ?>"
                         style="<?= $is_featured ? 'transform: translateY(-6px);' : '' ?>">

                        <?php if ($is_featured): ?>
                            <div class="text-center py-1 bg-warning rounded-top"
                                 style="font-size:.7rem; font-weight:800; color:#111;">
                                ⭐ PALING POPULER
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">

                            <!-- Nama + Badge Durasi -->
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fw-bold mb-0"><?= escape($pkg['name']) ?></h6>
                                <span class="badge bg-warning text-dark" style="font-size:.7rem;">
                                    <?= $pkg['day_duration'] ?> Hari
                                </span>
                            </div>

                            <!-- Harga -->
                            <div class="mb-3">
                                <span class="text-white-50 small">Rp</span>
                                <span class="fs-3 fw-bold">
                                    <?= number_format($pkg['price'], 0, ',', '.') ?>
                                </span>
                                <span class="text-white-50 small">
                                    / <?= $pkg['day_duration'] ?> hari
                                </span>
                            </div>

                            <!-- Divider -->
                            <hr class="border-secondary my-2">

                            <!-- Fitur -->
                            <ul class="list-unstyled flex-grow-1 d-flex flex-column gap-2 mb-3">
                                <li class="d-flex align-items-center gap-2 small">
                                    <span class="text-warning fw-bold">✓</span>
                                    Akses gym selama <?= $pkg['day_duration'] ?> hari
                                </li>
                                <li class="d-flex align-items-center gap-2 small">
                                    <span class="text-warning fw-bold">✓</span>
                                    Semua peralatan tersedia
                                </li>
                                <li class="d-flex align-items-center gap-2 small">
                                    <span class="text-warning fw-bold">✓</span>
                                    Loker & ruang ganti
                                </li>
                                <?php if ($pkg['day_duration'] >= 60): ?>
                                    <li class="d-flex align-items-center gap-2 small">
                                        <span class="text-warning fw-bold">✓</span>
                                        Konsultasi dengan trainer
                                    </li>
                                <?php endif; ?>
                                <?php if ($pkg['day_duration'] >= 90): ?>
                                    <li class="d-flex align-items-center gap-2 small">
                                        <span class="text-warning fw-bold">✓</span>
                                        Program latihan personal
                                    </li>
                                    <li class="d-flex align-items-center gap-2 small">
                                        <span class="text-warning fw-bold">✓</span>
                                        Analisis progress bulanan
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <!-- Tombol Daftar -->
                            <a href="<?= BASE_URL ?>controllers/member/register_package.php?id=<?= $pkg['id_package'] ?>"
                               class="btn fw-bold w-100
                                      <?= $is_featured ? 'btn-warning text-dark' : 'btn-outline-warning' ?>">
                                <i class="bi bi-cart-plus me-1"></i> Daftar Sekarang
                            </a>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>