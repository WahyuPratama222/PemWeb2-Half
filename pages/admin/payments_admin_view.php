<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-color-2 fw-bold mb-0">Data Pembayaran</h4>
            <small class="text-muted-dark">Melihat data pembayaran member</small>
        </div>
    </div>

    <?php show_flash(); ?>

    <!-- Stat ringkas -->
    <div class="row g-3 mb-4">
        <?php
        $total = count($payments);
        $belum = count(array_filter($payments, fn($p) => $p['payment_status'] === 'Belum Lunas'));
        $lunas = count(array_filter($payments, fn($p) => $p['payment_status'] === 'Lunas'));
        $total_nominal = array_sum(array_column(
            array_filter($payments, fn($p) => $p['payment_status'] === 'Lunas'),
            'amount'
        ));
        ?>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-color-1 border border-secondary text-color-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-primary bg-opacity-25">
                        <i class="bi bi-receipt fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $total ?></div>
                        <div class="small text-muted-dark">Total Transaksi</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-color-1 border border-secondary text-color-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-color-2 bg-opacity-25">
                        <i class="bi bi-hourglass-split fs-4 text-color-2"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $belum ?></div>
                        <div class="small text-muted-dark">Belum Lunas</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-color-1 border border-secondary text-color-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-success bg-opacity-25">
                        <i class="bi bi-check-circle fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $lunas ?></div>
                        <div class="small text-muted-dark">Lunas</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-color-1 border border-secondary text-color-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-info bg-opacity-25">
                        <i class="bi bi-cash-stack fs-4 text-color-3"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold" style="font-size:1rem !important;">
                            <?= format_rupiah($total_nominal) ?>
                        </div>
                        <div class="small text-muted-dark">Total Pemasukan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <!-- List Pembayaran -->
    <div class="card bg-color-1 border border-secondary text-color-4">
        <div class="card-body px-4 py-2">

            <?php if (empty($payments)): ?>
                <div class="text-center py-5 text-muted-dark">
                    <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                    Belum ada data pembayaran.
                </div>
            <?php else: ?>
                <?php foreach ($payments as $i => $p): ?>
                    <?php
                    $method_icon = match ($p['payment_method']) {
                        'Transfer Bank' => 'bi-bank',
                        'QRIS' => 'bi-qr-code',
                        'E-Wallet' => 'bi-wallet2',
                        'Tunai' => 'bi-cash',
                        default => 'bi-credit-card',
                    };
                    ?>
                    <div
                        class="d-flex align-items-center gap-4 py-3 <?= $i < count($payments) - 1 ? 'border-bottom border-secondary' : '' ?>">

                        <!-- Avatar + Nama -->
                        <div style="min-width: 200px;" class="d-flex align-items-center gap-2">
                            <span
                                class="bg-color-2 rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="color: #fff;"
                                style="width:30px;height:30px;font-size:.75rem;">
                                <?= strtoupper(substr($p['member_name'], 0, 1)) ?>
                            </span>
                            <div>
                                <div class="fw-semibold small"><?= escape($p['member_name']) ?></div>
                                <div class="text-muted-dark" style="font-size:.72rem;"><?= escape($p['member_email']) ?></div>
                            </div>
                        </div>

                        <!-- Paket -->
                        <div style="min-width: 130px;">
                            <span class="badge bg-color-2" style="color: #fff;"><?= escape($p['package_name']) ?></span>
                        </div>

                        <!-- Nominal -->
                        <div style="min-width: 110px;">
                            <span class="small fw-bold text-color-2"><?= format_rupiah((float) $p['amount']) ?></span>
                        </div>

                        <!-- Metode + Tanggal -->
                        <div class="flex-grow-1">
                            <div class="small text-color-4"><i
                                    class="bi <?= $method_icon ?> me-1"></i><?= escape($p['payment_method']) ?></div>
                            <div class="text-muted-dark" style="font-size:.72rem;">
                                <?= date('d M Y', strtotime($p['payment_date'])) ?></div>
                        </div>

                        <!-- Status -->
                        <div style="min-width: 90px;" class="text-center">
                            <?php if ($p['payment_status'] === 'Lunas'): ?>
                                <span class="badge bg-success">Lunas</span>
                            <?php else: ?>
                                <span class="badge bg-color-3" style="color: #fff;">Belum Lunas</span>
                            <?php endif; ?>
                        </div>

                        <!-- Aksi -->
                        <div style="min-width: 110px;" class="text-end">
                            <?php if ($p['payment_status'] === 'Belum Lunas'): ?>
                                <button class="btn btn-success btn-sm" onclick="openModal(
                                    <?= $p['id_payment'] ?>,
                                    '<?= escape($p['member_name']) ?>',
                                    '<?= escape($p['package_name']) ?>',
                                    '<?= format_rupiah((float) $p['amount']) ?>'
                                )">
                                    <i class="bi bi-check-lg me-1"></i>Konfirmasi
                                </button>
                            <?php else: ?>
                                <span class="text-muted-dark small">€”</span>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

</div>

<!-- •••••••••••••••••••••••••••••• -->
<!-- Modal Konfirmasi               -->
<!-- •••••••••••••••••••••••••••••• -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-color-1 border border-secondary text-color-4">

            <div class="modal-header border-secondary">
                <h6 class="modal-title fw-bold">
                    <i class="bi bi-check-circle text-success me-2"></i>Konfirmasi Pembayaran
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted-dark small mb-3">Pastikan bukti pembayaran sudah diverifikasi sebelum konfirmasi.</p>
                <div class="p-3 rounded-3 bg-color-1 border border-secondary d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted-dark small">Member</span>
                        <span class="small fw-semibold" id="modal-member"></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted-dark small">Paket</span>
                        <span class="small fw-semibold" id="modal-paket"></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted-dark small">Nominal</span>
                        <span class="small fw-bold text-color-2" id="modal-nominal"></span>
                    </div>
                </div>
                <div class="mt-3 p-3 rounded-3 bg-success bg-opacity-10 border border-success border-opacity-25">
                    <div class="small text-success">
                        <i class="bi bi-info-circle me-1"></i>
                        Status pembayaran †’ <strong>Lunas</strong> &
                        membership member †’ <strong>Aktif</strong>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="<?= BASE_URL ?>actions/confirm_payment_admin.php">
                    <input type="hidden" name="payment_id" id="modal-payment-id">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-check-lg me-1"></i>Ya, Konfirmasi
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    function openModal(paymentId, member, paket, nominal) {
        document.getElementById('modal-payment-id').value = paymentId;
        document.getElementById('modal-member').textContent = member;
        document.getElementById('modal-paket').textContent = paket;
        document.getElementById('modal-nominal').textContent = nominal;
        new bootstrap.Modal(document.getElementById('modalKonfirmasi')).show();
    }
</script>



