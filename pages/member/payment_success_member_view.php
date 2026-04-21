<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <?php show_flash(); ?>

            <div class="card border border-secondary text-color-4"
                 style="background: linear-gradient(180deg, #232a31, #20262d);">
                <div class="card-body p-4 p-md-5">

                    <!-- Icon & Judul -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center
                                    rounded-circle bg-color-2 bg-opacity-10 mb-3"
                             style="width:72px;height:72px; color: #fff;">
                            <i class="bi bi-receipt-cutoff text-color-2 fs-2"></i>
                        </div>
                        <h3 class="fw-bold text-color-4 mb-1">
                            Menunggu <span class="text-color-2">Pembayaran</span>
                        </h3>
                        <p class="text-muted-dark small">Selesaikan pembayaran Anda segera.</p>
                    </div>

                    <!-- Countdown -->
                    <div class="p-3 mb-4 rounded-3 border text-center"
                         style="border-color: rgba(255,82,82,0.3) !important; background: rgba(255,82,82,0.08);">
                        <div class="small text-uppercase fw-semibold mb-1" style="color:#ff5252;letter-spacing:1px;">
                            Batas Waktu Pembayaran
                        </div>
                        <div id="countdown-timer" class="fw-bold font-monospace fs-4" style="color:#ff5252;">
                            <i class="bi bi-clock"></i> 23:59:59
                        </div>
                    </div>

                    <!-- Detail Transaksi -->
                    <div class="p-3 mb-4 rounded-3 bg-color-1 bg-opacity-50 border border-secondary">
                        <div class="d-flex justify-content-between py-2 border-bottom border-secondary">
                            <span class="text-muted-dark small">Order ID</span>
                            <span class="fw-semibold small">
                                #REG-<?= str_pad($reg_id, 5, '0', STR_PAD_LEFT) ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom border-secondary">
                            <span class="text-muted-dark small">Paket Membership</span>
                            <span class="fw-semibold small"><?= escape($transaction['package_name']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                            <span class="text-muted-dark small">Metode Bayar</span>
                            <span class="badge bg-color-2 text-color-4 fw-bold">
                                <?= escape($transaction['payment_method']) ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3 mt-1">
                            <span class="text-muted-dark">Total Pembayaran</span>
                            <span class="fs-4 fw-bold text-color-3">
                                <?= format_rupiah($transaction['amount']) ?>
                            </span>
                        </div>
                    </div>

                    <!-- Nomor Virtual Account (untuk E-Wallet) -->
                    <?php if ($payment_method === 'E-Wallet'): ?>
                        <div class="p-3 mb-4 rounded-3 border text-center"
                             style="border: 1px dashed rgba(245,179,1,0.5); background: rgba(245,179,1,0.05);">
                            <div class="text-muted-dark small text-uppercase mb-2" style="letter-spacing:1px;">
                                Nomor Tujuan Transfer
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <span id="va-number" class="font-monospace fw-bold fs-4 text-color-4" style="letter-spacing:2px;">
                                    <?= escape($virt_account) ?>
                                </span>
                                <button type="button" onclick="copyVA()" id="btnCopy"
                                        class="btn btn-color-2 btn-sm text-color-4 fw-bold px-3">
                                    <i class="bi bi-clipboard" id="copyIcon"></i>
                                </button>
                            </div>
                            <div id="copy-toast" class="small text-success fw-semibold mt-2" style="opacity:0;transition:opacity .3s;">
                                <i class="bi bi-check-circle me-1"></i>Tersalin ke clipboard!
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Instruksi Pembayaran -->
                    <?php if (!empty($instructions)): ?>
                        <div class="mb-4">
                            <h6 class="text-color-4 fw-bold mb-3">
                                <i class="bi bi-info-circle text-color-3 me-2"></i>Cara Pembayaran
                            </h6>
                            <ol class="ps-3 d-flex flex-column gap-2">
                                <?php foreach ($instructions as $inst): ?>
                                    <li class="text-muted-dark small" style="line-height:1.7;">
                                        <?= $inst ?>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    <?php endif; ?>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2">
                        <a href="<?= BASE_URL ?>controllers/member/dashboard_member.php"
                           class="btn btn-color-2 text-color-4 fw-bold">
                            <i class="bi bi-check-circle me-1"></i> Saya Sudah Bayar
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="bi bi-printer me-1"></i> Cetak Instruksi
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
// Countdown timer 24 jam
(function () {
    var seconds = 60 * 60 * 24 - 1;
    var display  = document.getElementById('countdown-timer');
    setInterval(function () {
        var h = Math.floor(seconds / 3600);
        var m = Math.floor((seconds % 3600) / 60);
        var s = seconds % 60;
        display.innerHTML =
            '<i class="bi bi-clock"></i> ' +
            String(h).padStart(2, '0') + ':' +
            String(m).padStart(2, '0') + ':' +
            String(s).padStart(2, '0');
        if (--seconds < 0) seconds = 60 * 60 * 24 - 1;
    }, 1000);
})();

// Copy VA
function copyVA() {
    var text = document.getElementById('va-number').innerText.trim();
    navigator.clipboard.writeText(text).then(function () {
        var toast  = document.getElementById('copy-toast');
        var icon   = document.getElementById('copyIcon');
        icon.className = 'bi bi-clipboard-check';
        toast.style.opacity = '1';
        setTimeout(function () {
            toast.style.opacity = '0';
            icon.className = 'bi bi-clipboard';
        }, 2500);
    });
}
</script>

