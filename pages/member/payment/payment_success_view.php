<?php require_once __DIR__ . '/../../../layouts/header.php'; ?>

<!-- Dark mode theme konsisten persis dengan auth/package_view -->
<section class="success-modern">
    <div class="suc-container">
        
        <?php show_flash(); ?>

        <div class="suc-card">
            <div class="suc-icon">
                <i class="ti ti-receipt-2"></i>
            </div>
            
            <h2 class="suc-title">Menunggu <span>Pembayaran</span></h2>
            <p class="suc-desc">Selesaikan pembayaran Anda segera.</p>

            <div class="suc-countdown-box">
                <span class="countdown-label">Batas Waktu:</span>
                <strong id="countdown-timer"><i class="ti ti-clock"></i> 23:59:59</strong>
            </div>

            <div class="suc-details">
                <div class="suc-row">
                    <span class="suc-label">Order ID</span>
                    <span class="suc-val">#REG-<?= str_pad($transaction['id_registration'], 5, '0', STR_PAD_LEFT) ?></span>
                </div>
                <div class="suc-row">
                    <span class="suc-label">Paket Membership</span>
                    <span class="suc-val"><?= escape($transaction['package_name']) ?></span>
                </div>
                <div class="suc-row">
                    <span class="suc-label">Metode Bayar</span>
                    <span class="suc-val-highlight"><?= escape($transaction['payment_method']) ?></span>
                </div>
                <div class="suc-row suc-total">
                    <span class="suc-label">Total Pembayaran</span>
                    <span class="suc-val-price"><?= format_rupiah($transaction['amount']) ?></span>
                </div>
            </div>

            <?php if(in_array($payment_method, ['Dana', 'GoPay', 'E-Wallet'])): ?>
            <div class="suc-va-box">
                <span class="va-label">Nomor Virtual Account</span>
                <div class="va-display">
                    <span id="va-number"><?= $virt_account ?></span>
                    <button type="button" onclick="copyVA()" id="btnCopy" title="Salin Nomor">
                        <i class="ti ti-copy"></i>
                    </button>
                </div>
                <div id="copy-toast">Tersalin ke papan klip!</div>
            </div>
            <?php endif; ?>

            <div class="suc-instructions">
                <h4><i class="ti ti-info-circle"></i> Cara Pembayaran</h4>
                <ol>
                    <?php foreach($instructions as $inst): ?>
                        <li><?= $inst // $inst di-echo HTML untk rendering str tag <strong> ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
            
            <div class="suc-actions">
                <a href="<?= BASE_URL ?>member/dashboard.php" class="btn-primary-suc">Saya Sudah Bayar</a>
                <button onclick="window.print()" class="btn-outline-suc"><i class="ti ti-printer"></i> Cetak Instruksi</button>
            </div>
        </div>
    </div>
</section>

<style>
/* CSS seragam dengan layout gym dark mode */
.success-modern {
    padding: 5rem 1rem;
    min-height: 85vh;
    background-color: var(--bg);
    display: flex;
    justify-content: center;
    align-items: flex-start;
}
.suc-container {
    width: 100%;
    max-width: 600px;
}
.suc-card {
    background: var(--panel);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
    box-shadow: var(--shadow);
}

.suc-icon {
    width: 70px;
    height: 70px;
    background: rgba(245,179,1,0.1);
    color: var(--yellow);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.2rem;
    margin: 0 auto 1.5rem;
}

.suc-title {
    color: var(--text);
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}
.suc-title span {
    color: var(--yellow);
}
.suc-desc {
    color: var(--muted);
    font-size: 1rem;
    margin-bottom: 2rem;
}

.suc-countdown-box {
    background: rgba(255, 82, 82, 0.1);
    border: 1px solid rgba(255, 82, 82, 0.2);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 2rem;
    display: inline-flex;
    flex-direction: column;
    align-items: center;
}
.countdown-label {
    font-size: 0.8rem;
    text-transform: uppercase;
    color: #ff5252;
    margin-bottom: 0.3rem;
    font-weight: 600;
}
#countdown-timer {
    color: #ff5252;
    font-size: 1.4rem;
    font-family: monospace;
    font-weight: 800;
}

.suc-details {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    text-align: left;
}
.suc-row {
    display: flex;
    justify-content: space-between;
    padding-bottom: 0.8rem;
    margin-bottom: 0.8rem;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}
.suc-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}
.suc-label {
    color: var(--muted);
    font-size: 0.95rem;
}
.suc-val {
    color: var(--text);
    font-weight: 600;
}
.suc-val-highlight {
    background: rgba(26,26,26,0.6);
    color: var(--yellow);
    padding: 0.2rem 0.8rem;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.9rem;
}
.suc-total {
    margin-top: 1rem !important;
    padding-top: 1rem !important;
    border-top: 1px dashed rgba(255,255,255,0.1) !important;
    align-items: center;
}
.suc-total .suc-label {
    font-size: 1.1rem;
}
.suc-val-price {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--yellow);
}

.suc-va-box {
    background: rgba(245, 179, 1, 0.05);
    border: 1px dashed var(--yellow);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}
.va-label {
    display: block;
    color: var(--muted);
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.8rem;
}
.va-display {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}
#va-number {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--text);
    font-family: monospace;
    letter-spacing: 2px;
}
#btnCopy {
    background: var(--yellow);
    color: #111827;
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.3rem;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}
#btnCopy:hover {
    background: var(--yellow-2);
}
#copy-toast {
    opacity: 0;
    color: #00c853;
    font-size: 0.9rem;
    font-weight: 600;
    margin-top: 0.5rem;
    transition: opacity 0.3s;
}

.suc-instructions {
    text-align: left;
    margin-bottom: 2.5rem;
}
.suc-instructions h4 {
    color: var(--text);
    font-size: 1.1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.suc-instructions h4 i {
    color: var(--yellow);
}
.suc-instructions ol {
    color: var(--muted);
    font-size: 0.95rem;
    line-height: 1.7;
    padding-left: 1.2rem;
}

.suc-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.btn-primary-suc {
    background: var(--yellow);
    color: #111827;
    text-decoration: none;
    padding: 1rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1.05rem;
    transition: 0.3s;
}
.btn-primary-suc:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}
.btn-outline-suc {
    background: transparent;
    color: var(--muted);
    border: 1px solid rgba(255,255,255,0.2);
    padding: 1rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    font-family: inherit;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
.btn-outline-suc:hover {
    border-color: var(--text);
    color: var(--text);
}

@media print {
    body { background: var(--bg) !important; color: white !important; }
    .navbar, footer, .suc-actions, #btnCopy { display: none !important; }
    .success-modern { padding: 0 !important; }
    .suc-card { border: none !important; box-shadow: none !important; }
}

@media (max-width: 576px) {
    .suc-card { padding: 2rem 1.5rem; }
    #va-number { font-size: 1.4rem; }
}
</style>

<script>
function startTimer(duration, display) {
    var timer = duration, hours, minutes, seconds;
    setInterval(function () {
        hours   = parseInt(timer / 3600, 10);
        minutes = parseInt((timer % 3600) / 60, 10);
        seconds = parseInt(timer % 60, 10);
        hours   = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.innerHTML = '<i class="ti ti-clock"></i> ' + hours + ":" + minutes + ":" + seconds;
        if (--timer < 0) { timer = duration; }
    }, 1000);
}
window.onload = function () {
    var twentyFourHours = 60 * 60 * 24 - 1; 
    var display = document.querySelector('#countdown-timer');
    startTimer(twentyFourHours, display);
};
function copyVA() {
    var text = document.getElementById("va-number").innerText;
    navigator.clipboard.writeText(text).then(function() {
        var toast = document.getElementById("copy-toast");
        var btnIcon = document.querySelector("#btnCopy i");
        btnIcon.className = "ti ti-check";
        toast.style.opacity = 1;
        setTimeout(function() {
            toast.style.opacity = 0;
            btnIcon.className = "ti ti-copy";
        }, 2500);
    });
}
</script>

<?php require_once __DIR__ . '/../../../layouts/footer.php'; ?>
