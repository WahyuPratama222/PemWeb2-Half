<div class="container py-5">

    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-color-4">Selesaikan <span class="text-color-2">Pembayaran</span></h2>
        <p class="text-muted-dark">Langkah terakhir untuk mengaktifkan paket membership Anda.</p>
    </div>

    <?php show_flash(); ?>

    <div class="row g-4 justify-content-center">

        <!-- Kiri: Form Metode Pembayaran -->
        <div class="col-lg-7">
            <div class="card bg-color-1 border border-secondary text-color-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-color-4">
                        <i class="bi bi-credit-card me-2 text-color-2"></i>Pilih Metode Pembayaran
                    </h5>

                    <form method="POST"
                          action="<?= BASE_URL ?>controllers/member/checkout_member.php?id=<?= $id_package ?>&extra_days=<?= $extra_days ?>"
                          id="formCheckout">

                        <!-- Tanggal Mulai -->
                        <div class="mb-4">
                            <label class="form-label text-color-2 small fw-semibold">Tanggal Mulai</label>
                            <input type="date" name="start_date"
                                   class="form-control bg-color-1 text-color-4 border-secondary"
                                   value="<?= date('Y-m-d') ?>"
                                   min="<?= date('Y-m-d') ?>" required>
                        </div>

                        <label class="form-label text-color-2 small fw-semibold mb-3">Metode Pembayaran</label>

                        <div class="row g-3">

                            <!-- Transfer Bank -->
                            <div class="col-sm-6">
                                <input type="radio" class="btn-check" name="payment_method"
                                       value="Transfer Bank" id="pm_bank" required>
                                <label class="btn btn-outline-color-3 w-100 text-start py-3 px-3" for="pm_bank">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-bank2 fs-5"></i>
                                        <div>
                                            <div class="fw-semibold">Transfer Bank</div>
                                            <div class="small opacity-75">BCA, Mandiri, BNI, BRI</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Tunai -->
                            <div class="col-sm-6">
                                <input type="radio" class="btn-check" name="payment_method"
                                       value="Tunai" id="pm_cash" required>
                                <label class="btn btn-outline-color-3 w-100 text-start py-3 px-3" for="pm_cash">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-cash-coin fs-5"></i>
                                        <div>
                                            <div class="fw-semibold">Tunai / Cash</div>
                                            <div class="small opacity-75">Bayar di resepsionis</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- QRIS -->
                            <div class="col-sm-6">
                                <input type="radio" class="btn-check" name="payment_method"
                                       value="QRIS" id="pm_qris" required>
                                <label class="btn btn-outline-color-3 w-100 text-start py-3 px-3" for="pm_qris">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-qr-code fs-5"></i>
                                        <div>
                                            <div class="fw-semibold">QRIS</div>
                                            <div class="small opacity-75">Scan dengan aplikasi apa saja</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- E-Wallet -->
                            <div class="col-sm-6">
                                <input type="radio" class="btn-check" name="payment_method"
                                       value="E-Wallet" id="pm_ewallet" required>
                                <label class="btn btn-outline-color-3 w-100 text-start py-3 px-3" for="pm_ewallet">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-phone fs-5"></i>
                                        <div>
                                            <div class="fw-semibold">E-Wallet</div>
                                            <div class="small opacity-75">OVO, ShopeePay, LinkAja</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                        </div><!-- end row methods -->

                        <div class="mt-4 p-3 rounded-3 border border-secondary bg-color-1 bg-opacity-50">
                            <p class="mb-0 small text-muted-dark">
                                <i class="bi bi-info-circle text-color-2 me-1"></i>
                                Status pembayaran awal <strong class="text-color-2">Belum Lunas</strong>.
                                Admin akan mengonfirmasi pembayaranmu segera.
                            </p>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Kanan: Ringkasan Pesanan -->
        <div class="col-lg-4">
            <div class="card border border-color-2 border-2 text-color-4 h-100"
                 style="background: linear-gradient(180deg, #232a31, #20262d);">
                <div class="card-body p-4 d-flex flex-column">

                    <h5 class="fw-bold text-color-4 mb-1"><?= escape($package['name']) ?></h5>
                    <span class="badge bg-color-2 mb-3" style="width:fit-content; color: #fff;">
                        <?= $total_days ?> Hari <?= $extra_days > 0 ? '(+'.$extra_days.' Hari)' : '' ?>
                    </span>

                    <!-- Harga -->
                    <div class="mb-3">
                        <span class="text-muted-dark small">Rp</span>
                        <span class="fs-2 fw-bold text-color-4">
                            <?= number_format($total_price, 0, ',', '.') ?>
                        </span>
                        <span class="text-muted-dark small">/ <?= $total_days ?> hari</span>
                    </div>

                    <hr class="border-secondary">

                    <!-- Fitur -->
                    <ul class="list-unstyled flex-grow-1 d-flex flex-column gap-2 mb-4">
                        <li class="d-flex align-items-center gap-2 small">
                            <i class="bi bi-check-circle-fill text-color-2"></i>
                            Akses gym selama <?= $total_days ?> hari
                        </li>
                        <li class="d-flex align-items-center gap-2 small">
                            <i class="bi bi-check-circle-fill text-color-2"></i>
                            Semua peralatan tersedia
                        </li>
                        <li class="d-flex align-items-center gap-2 small">
                            <i class="bi bi-check-circle-fill text-color-2"></i>
                            Loker & ruang ganti
                        </li>
                        <?php if ($package['day_duration'] >= 60): ?>
                            <li class="d-flex align-items-center gap-2 small">
                                <i class="bi bi-check-circle-fill text-color-2"></i>
                                Konsultasi dengan trainer
                            </li>
                        <?php endif; ?>
                        <?php if ($package['day_duration'] >= 90): ?>
                            <li class="d-flex align-items-center gap-2 small">
                                <i class="bi bi-check-circle-fill text-color-2"></i>
                                Program latihan personal
                            </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Tombol -->
                    <button type="submit" form="formCheckout"
                            class="btn btn-color-2 fw-bold w-100 mb-2">
                        <i class="bi bi-lock-fill me-1"></i> Bayar Sekarang
                    </button>
                    <a href="<?= BASE_URL ?>controllers/member/packages_member.php"
                       class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left me-1"></i> Batal & Kembali
                    </a>

                </div>
            </div>
        </div>

    </div>
</div>

