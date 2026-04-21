<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-color-4 fw-bold mb-0">Paket Gym</h4>
            <small class="text-muted-dark">Pilih paket yang sesuai dan mulai latihan sekarang</small>
        </div>
    </div>

    <?php show_flash(); ?>

    <?php if (empty($packages)): ?>
        <div class="alert alert-warning text-muted-dark">Belum ada paket tersedia saat ini.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($packages as $i => $pkg): ?>
                <?php $is_featured = $i === 1; ?>
                <div class="col-md-4">
                    <div class="card text-color-4 h-100 bg-color-1
                                <?= $is_featured ? 'border border-color-2 border-2 shadow-lg' : 'border border-secondary' ?>"
                         style="<?= $is_featured ? 'transform: translateY(-6px);' : '' ?>">

                        <?php if ($is_featured): ?>
                            <div class="text-center py-1 bg-color-2 rounded-top"
                                 style="font-size:.7rem; font-weight:800; color:#fff;">
                                &#11088; PALING POPULER
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">

                            <!-- Nama + Badge Durasi -->
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h5 class="fw-bold mb-0"><?= escape($pkg['name']) ?></h5>
                                <span class="badge bg-color-3 text-color-4">
                                    <?= $pkg['day_duration'] ?> Hari
                                </span>
                            </div>

                            <!-- Harga -->
                            <div class="mb-3">
                                <span class="text-muted-dark small">Rp</span>
                                <span class="fs-2 fw-bold">
                                    <?= number_format($pkg['price'], 0, ',', '.') ?>
                                </span>
                                <span class="text-muted-dark small">/ <?= $pkg['day_duration'] ?> hari</span>
                            </div>

                            <hr class="border-secondary">

                            <!-- Fitur -->
                            <ul class="list-unstyled flex-grow-1 d-flex flex-column gap-2 mb-4">
                                <li class="d-flex align-items-center gap-2 small">
                                    <i class="bi bi-check-circle-fill text-color-3"></i>
                                    Akses gym selama <?= $pkg['day_duration'] ?> hari
                                </li>
                                <li class="d-flex align-items-center gap-2 small">
                                    <i class="bi bi-check-circle-fill text-color-3"></i>
                                    Semua peralatan tersedia
                                </li>
                                <li class="d-flex align-items-center gap-2 small">
                                    <i class="bi bi-check-circle-fill text-color-3"></i>
                                    Loker & ruang ganti
                                </li>
                                <?php if ($pkg['day_duration'] >= 60): ?>
                                    <li class="d-flex align-items-center gap-2 small">
                                        <i class="bi bi-check-circle-fill text-color-3"></i>
                                        Konsultasi dengan trainer
                                    </li>
                                <?php endif; ?>
                                <?php if ($pkg['day_duration'] >= 90): ?>
                                    <li class="d-flex align-items-center gap-2 small">
                                        <i class="bi bi-check-circle-fill text-color-3"></i>
                                        Program latihan personal
                                    </li>
                                    <li class="d-flex align-items-center gap-2 small">
                                        <i class="bi bi-check-circle-fill text-color-3"></i>
                                        Analisis progress bulanan
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <!-- Opsi Tambah Hari & Tombol Daftar -->
                            <form action="<?= BASE_URL ?>controllers/member/checkout_member.php" method="GET">
                                <input type="hidden" name="id" value="<?= $pkg['id_package'] ?>">
                                
                                <?php $price_per_day = ceil($pkg['price'] / $pkg['day_duration']); ?>
                                <div class="mb-3 p-3 rounded bg-color-1 border border-secondary shadow-sm">
                                    <label class="form-label text-color-4 small fw-bold mb-1">Tambah Hari (Opsional)</label>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <input type="number" name="extra_days" class="form-control form-control-sm bg-color-1 bg-opacity-25 text-color-4 border-secondary" min="0" value="0" style="width: 70px;" oninput="updateTotal(this, <?= $pkg['price'] ?>, <?= $price_per_day ?>, 'total_display_<?= $pkg['id_package'] ?>')">
                                        <small class="text-muted-dark">+ Rp <?= number_format($price_per_day, 0, ',', '.') ?> /hari</small>
                                    </div>
                                    <div class="small fw-bold text-color-4 d-flex justify-content-between align-items-center">
                                        <span>Total:</span>
                                        <span id="total_display_<?= $pkg['id_package'] ?>" class="text-color-3 fs-6">Rp <?= number_format($pkg['price'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                                <button type="submit" class="btn fw-bold w-100 <?= $is_featured ? 'btn-color-2' : 'btn-outline-color-2' ?>">
                                    <i class="bi bi-cart-plus me-1"></i> Daftar Sekarang
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<script>
function updateTotal(input, basePrice, pricePerDay, displayId) {
    let days = parseInt(input.value) || 0;
    if (days < 0) {
        days = 0;
        input.value = 0;
    }
    let total = basePrice + (days * pricePerDay);
    document.getElementById(displayId).innerText = 'Rp ' + total.toLocaleString('id-ID');
}
</script>

