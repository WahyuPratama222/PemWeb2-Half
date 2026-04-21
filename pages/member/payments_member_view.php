<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-color-2 fw-bold mb-0">Riwayat Pembayaran</h4>
            <small class="text-muted-dark">Daftar semua transaksi yang Anda lakukan</small>
        </div>
    </div>

    <?php show_flash(); ?>

    <!-- Table Card -->
    <div class="card bg-color-1 border border-secondary text-color-4 h-100">
        <div class="card-body">

            <?php if (empty($payments)): ?>
                <div class="text-center py-5 text-muted-dark">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    <p class="mb-0">Belum ada riwayat pembayaran.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table mb-0 align-middle text-nowrap" style="--bs-table-bg: transparent;">
                        <thead class="border-bottom border-secondary">
                            <tr>
                                <th class="py-3 text-color-2">Tanggal & Waktu</th>
                                <th class="py-3 text-color-2">Paket Langganan</th>
                                <th class="py-3 text-center text-color-2">Metode</th>
                                <th class="py-3 text-end text-color-2">Total Bayar</th>
                                <th class="py-3 text-center text-color-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $p): ?>
                                <tr class="border-bottom border-secondary">
                                    <td class="py-3">
                                        <div class="fw-medium text-color-4 small">
                                            <?= date('d M Y', strtotime($p['payment_date'])) ?>
                                        </div>
                                        <div class="text-muted-dark" style="font-size:.75rem;">
                                            <i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($p['payment_date'])) ?>
                                            WIB
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-bold text-color-4 small"><?= escape($p['package_name']) ?></div>
                                        <div class="text-muted-dark" style="font-size:.75rem;">
                                            Aktif s/d <span
                                                class="text-color-2"><?= date('d M Y', strtotime($p['expiry_date'])) ?></span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="small text-muted-dark">
                                            <i class="bi bi-wallet2 me-1"></i><?= escape($p['payment_method']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 text-end">
                                        <span class="fw-bold text-color-2 small"><?= format_rupiah($p['amount']) ?></span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <?php if ($p['payment_status'] === 'Lunas'): ?>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Lunas
                                            </span>
                                        <?php elseif ($p['payment_status'] === 'Belum Lunas'): ?>
                                            <span class="badge bg-color-2" style="color: #fff;">
                                                <i class="bi bi-hourglass-split me-1"></i>Pending
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-color-3" style="color: #fff;">
                                                <i class="bi bi-x-circle me-1"></i>Gagal
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <span class="text-muted-dark small">Menampilkan <span class="text-color-2"><?= count($payments) ?></span> transaksi terakhir</span>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

