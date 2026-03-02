<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-warning fw-bold mb-0">Paket Gym</h4>
            <small class="text-white-50">Pilih paket yang sesuai dan mulai latihan sekarang</small>
        </div>
    </div>

    <?php show_flash(); ?>

    <?php if (empty($packages)): ?>
        <div class="alert alert-warning text-dark-50">Belum ada paket tersedia saat ini.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($packages as $i => $pkg): ?>
                <?php $is_featured = $i === 1; ?>
                <div class="col-md-4">
                    <div class="card text-white h-100 bg-secondary bg-opacity-10
                                <?= $is_featured ? 'border border-warning border-2 shadow-lg' : 'border border-secondary' ?>"
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
                                <h5 class="fw-bold mb-0"><?= escape($pkg['name']) ?></h5>
                                <span class="badge bg-warning text-dark">
                                    <?= $pkg['day_duration'] ?> Hari
                                </span>
                            </div>

                            <!-- Harga -->
                            <div class="mb-3">
                                <span class="text-white-50 small">Rp</span>
                                <span class="fs-2 fw-bold">
                                    <?= number_format($pkg['price'], 0, ',', '.') ?>
                                </span>
                                <span class="text-white-50 small">/ <?= $pkg['day_duration'] ?> hari</span>
                            </div>

                            <hr class="border-secondary">

                            <!-- Fitur -->
                            <ul class="list-unstyled flex-grow-1 d-flex flex-column gap-2 mb-4">
                                <li class="d-flex align-items-center gap-2 small">
                                    <i class="bi bi-check-circle-fill text-warning"></i>
                                    Akses gym selama <?= $pkg['day_duration'] ?> hari
                                </li>
                                <li class="d-flex align-items-center gap-2 small">
                                    <i class="bi bi-check-circle-fill text-warning"></i>
                                    Semua peralatan tersedia
                                </li>
                                <li class="d-flex align-items-center gap-2 small">
                                    <i class="bi bi-check-circle-fill text-warning"></i>
                                    Loker & ruang ganti
                                </li>
                                <?php if ($pkg['day_duration'] >= 60): ?>
                                    <li class="d-flex align-items-center gap-2 small">
                                        <i class="bi bi-check-circle-fill text-warning"></i>
                                        Konsultasi dengan trainer
                                    </li>
                                <?php endif; ?>
                                <?php if ($pkg['day_duration'] >= 90): ?>
                                    <li class="d-flex align-items-center gap-2 small">
                                        <i class="bi bi-check-circle-fill text-warning"></i>
                                        Program latihan personal
                                    </li>
                                    <li class="d-flex align-items-center gap-2 small">
                                        <i class="bi bi-check-circle-fill text-warning"></i>
                                        Analisis progress bulanan
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <!-- Tombol Daftar — langsung ke checkout -->
                            <a href="<?= BASE_URL ?>controllers/member/checkout_member.php?id=<?= $pkg['id_package'] ?>"
                               class="btn fw-bold w-100 <?= $is_featured ? 'btn-warning text-dark' : 'btn-outline-warning' ?>">
                                <i class="bi bi-cart-plus me-1"></i> Daftar Sekarang
                            </a>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>