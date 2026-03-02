<?php 
$title = "Riwayat Pembayaran - Gymku";
require_once __DIR__ . '/../../layouts/header.php'; 
?>

<div class="d-flex">
    <?php require_once __DIR__ . '/../../components/sidebar_member.php'; ?>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4 bg-dark text-white" style="min-height: 100vh; overflow-y: auto;">
        
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-warning"><i class="bi bi-receipt me-2"></i>Riwayat Pembayaran</h4>
                <p class="text-white-50 small mb-0">Daftar semua transaksi yang Anda lakukan</p>
            </div>
        </div>

        <?php show_flash(); ?>

        <!-- Table Card -->
        <div class="card bg-black border-secondary shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle text-nowrap">
                        <thead class="border-bottom border-secondary" style="background-color: #1f242b;">
                            <tr>
                                <th class="text-white-50 fw-normal py-3 ps-4" style="border-top-left-radius: 1rem;">Tanggal & Waktu</th>
                                <th class="text-white-50 fw-normal py-3 text-start">Paket Langganan</th>
                                <th class="text-white-50 fw-normal py-3 text-center">Metode</th>
                                <th class="text-white-50 fw-normal py-3 text-end">Total Bayar</th>
                                <th class="text-white-50 fw-normal py-3 text-center pe-4" style="border-top-right-radius: 1rem;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($payments)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-white-50 border-0">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 mt-3"></i>
                                        <p class="mb-3">Belum ada riwayat pembayaran.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($payments as $p): ?>
                                    <tr class="border-bottom border-secondary">
                                        <td class="ps-4 py-3">
                                            <div class="fw-medium text-white"><?= date('d M Y', strtotime($p['payment_date'])) ?></div>
                                            <div class="text-white-50" style="font-size: 0.8rem;"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($p['payment_date'])) ?> WIB</div>
                                        </td>
                                        <td class="text-start py-3">
                                            <div class="fw-bold text-white"><?= escape($p['package_name']) ?></div>
                                            <div class="text-white-50" style="font-size: 0.8rem;">
                                                Aktif s/d <span class="text-warning"><?= date('d M Y', strtotime($p['expiry_date'])) ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center py-3">
                                            <span class="badge border border-secondary text-white fw-normal bg-dark px-2 py-1">
                                                <i class="bi bi-wallet2 me-1"></i><?= escape($p['payment_method']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end py-3 fw-bold text-warning fs-5">
                                            <?= format_rupiah($p['amount']) ?>
                                        </td>
                                        <td class="text-center pe-4 py-3">
                                            <?php if ($p['payment_status'] === 'Lunas'): ?>
                                                <span class="badge bg-success bg-opacity-25 text-success border border-success fw-medium px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i>Lunas</span>
                                            <?php elseif ($p['payment_status'] === 'Belum Lunas'): ?>
                                                <span class="badge bg-warning bg-opacity-25 text-warning border border-warning fw-medium px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger bg-opacity-25 text-danger border border-danger fw-medium px-3 py-2 rounded-pill"><i class="bi bi-x-circle me-1"></i>Gagal</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if (!empty($payments)): ?>
            <div class="card-footer bg-transparent border-top border-secondary py-3 px-4 d-flex justify-content-between align-items-center rounded-bottom-4">
                <span class="text-white-50 small">Menampilkan <?= count($payments) ?> transaksi terakhir</span>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
