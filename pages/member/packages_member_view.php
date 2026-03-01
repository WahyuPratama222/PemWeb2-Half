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

                            <!-- Tombol Daftar -->
                            <button class="btn fw-bold w-100 <?= $is_featured ? 'btn-warning text-dark' : 'btn-outline-warning' ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalDaftar"
                                    data-id="<?= $pkg['id_package'] ?>"
                                    data-name="<?= escape($pkg['name']) ?>"
                                    data-price="<?= $pkg['price'] ?>"
                                    data-duration="<?= $pkg['day_duration'] ?>">
                                <i class="bi bi-cart-plus me-1"></i> Daftar Sekarang
                            </button>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<!-- Modal Konfirmasi Daftar -->
<div class="modal fade" id="modalDaftar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark border border-secondary text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">Konfirmasi Pendaftaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>actions/register_package.php">
                <input type="hidden" name="id_package" id="modalPackageId">
                <div class="modal-body">

                    <!-- Info Paket -->
                    <div class="p-3 rounded-3 border border-warning border-opacity-25 bg-warning bg-opacity-10 mb-3">
                        <div class="fw-bold text-warning fs-6" id="modalPackageName"></div>
                        <div class="small text-white-50 mt-1">
                            <span id="modalPackageDuration"></span> hari
                            · Rp <span id="modalPackagePrice"></span>
                        </div>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="mb-3">
                        <label class="form-label text-warning small">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="startDate"
                               class="form-control bg-dark text-white border-secondary"
                               value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" required>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="mb-3">
                        <label class="form-label text-warning small">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select bg-dark text-white border-secondary" required>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>

                    <div class="small text-white-50">
                        <i class="bi bi-info-circle me-1"></i>
                        Status pembayaran awal: <strong class="text-warning">Belum Lunas</strong>.
                        Admin akan konfirmasi pembayaranmu.
                    </div>

                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Isi data modal saat tombol daftar diklik
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalDaftar');
    modal.addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        document.getElementById('modalPackageId').value       = btn.dataset.id;
        document.getElementById('modalPackageName').textContent    = btn.dataset.name;
        document.getElementById('modalPackageDuration').textContent = btn.dataset.duration;
        document.getElementById('modalPackagePrice').textContent   = parseInt(btn.dataset.price).toLocaleString('id-ID');
    });
});
</script>