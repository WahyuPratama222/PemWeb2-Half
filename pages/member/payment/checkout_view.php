<?php require_once __DIR__ . '/../../../layouts/header.php'; ?>

<!-- Gunakan style section yang sama persis strukturnya dengan pk-section di auth/package_view -->
<section class="checkout-modern">
    <div class="chk-container">
        
        <div class="chk-head">
            <h2>Selesaikan <span>Pembayaran</span></h2>
            <p>Langkah terakhir untuk mengaktifkan paket membership Anda.</p>
        </div>

        <?php show_flash(); ?>

        <div class="chk-grid">
            
            <!-- (KIRI) Form Pilih Metode -->
            <div class="chk-form-area">
                <form action="<?= BASE_URL ?>member/payment/checkout.php?id=<?= $id_package ?>" method="POST" id="formCheckout">
                    <h3 class="chk-section-title">Metode Pembayaran</h3>
                    
                    <div class="chk-methods">
                        <!-- Dana -->
                        <label class="chk-pm-card">
                            <input type="radio" name="payment_method" value="Dana" required>
                            <div class="chk-pm-box">
                                <div class="chk-pm-icon"><i class="ti ti-wallet"></i></div>
                                <div class="chk-pm-info">
                                    <span class="chk-pm-name">Dana</span>
                                    <span class="chk-pm-desc">Via Aplikasi DANA</span>
                                </div>
                                <div class="chk-pm-check"><i class="ti ti-circle-check-filled"></i></div>
                            </div>
                        </label>

                        <!-- GoPay -->
                        <label class="chk-pm-card">
                            <input type="radio" name="payment_method" value="GoPay" required>
                            <div class="chk-pm-box">
                                <div class="chk-pm-icon"><i class="ti ti-wallet"></i></div>
                                <div class="chk-pm-info">
                                    <span class="chk-pm-name">GoPay</span>
                                    <span class="chk-pm-desc">Via Aplikasi Gojek</span>
                                </div>
                                <div class="chk-pm-check"><i class="ti ti-circle-check-filled"></i></div>
                            </div>
                        </label>

                        <!-- E-Wallet -->
                        <label class="chk-pm-card">
                            <input type="radio" name="payment_method" value="E-Wallet" required>
                            <div class="chk-pm-box">
                                <div class="chk-pm-icon"><i class="ti ti-device-mobile"></i></div>
                                <div class="chk-pm-info">
                                    <span class="chk-pm-name">E-Wallet Lain</span>
                                    <span class="chk-pm-desc">OVO, ShopeePay</span>
                                </div>
                                <div class="chk-pm-check"><i class="ti ti-circle-check-filled"></i></div>
                            </div>
                        </label>

                        <!-- QRIS -->
                        <label class="chk-pm-card">
                            <input type="radio" name="payment_method" value="QRIS" required>
                            <div class="chk-pm-box">
                                <div class="chk-pm-icon"><i class="ti ti-qrcode"></i></div>
                                <div class="chk-pm-info">
                                    <span class="chk-pm-name">QRIS</span>
                                    <span class="chk-pm-desc">Scan dengan Web/App</span>
                                </div>
                                <div class="chk-pm-check"><i class="ti ti-circle-check-filled"></i></div>
                            </div>
                        </label>

                        <!-- Transfer Bank -->
                        <label class="chk-pm-card">
                            <input type="radio" name="payment_method" value="Transfer Bank" required>
                            <div class="chk-pm-box">
                                <div class="chk-pm-icon"><i class="ti ti-building-bank"></i></div>
                                <div class="chk-pm-info">
                                    <span class="chk-pm-name">Transfer Bank</span>
                                    <span class="chk-pm-desc">BCA, Mandiri, BNI, BRI</span>
                                </div>
                                <div class="chk-pm-check"><i class="ti ti-circle-check-filled"></i></div>
                            </div>
                        </label>

                        <!-- Cash -->
                        <label class="chk-pm-card">
                            <input type="radio" name="payment_method" value="Cash" required>
                            <div class="chk-pm-box">
                                <div class="chk-pm-icon"><i class="ti ti-cash"></i></div>
                                <div class="chk-pm-info">
                                    <span class="chk-pm-name">Kasir / Cash</span>
                                    <span class="chk-pm-desc">Bayar Tunai di Resepsionis</span>
                                </div>
                                <div class="chk-pm-check"><i class="ti ti-circle-check-filled"></i></div>
                            </div>
                        </label>
                    </div>
                </form>
            </div>

            <!-- (KANAN) Ringkasan Pesanan Area Sticky bergaya dark-card modern Gymku -->
            <div class="chk-summary-area">
                <article class="pk-card pk-featured" style="width: 100%; max-width: 100%; border: 2px solid var(--yellow);">
                    <header class="pk-card__top">
                        <div class="pk-title-row">
                            <h3 class="pk-title"><?= escape($package['name']) ?></h3>
                        </div>

                        <div class="pk-price">
                            <span class="pk-currency">Rp</span>
                            <span class="pk-amount"><?= number_format($package['price'], 0, ',', '.') ?></span>
                        </div>

                        <div class="pk-sub">
                            <span class="pk-duration"><?= escape($package['day_duration']) ?> Hari Akses</span>
                        </div>
                    </header>

                    <div class="pk-line"></div>

                    <ul class="pk-features">
                        <li>Semua alat fitness standar & mesin</li>
                        <li>Akses loker dan shower per hari</li>
                        <li>Free konsultasi pemula dengan instruktur</li>
                    </ul>

                    <footer class="pk-actions" style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1rem;">
                        <button type="submit" form="formCheckout" class="pk-btn pk-btn--yellow" style="width: 100%; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-family: inherit;">
                            Bayar Sekarang <i class="ti ti-arrow-right"></i>
                        </button>
                        <a class="pk-btn" href="<?= BASE_URL ?>auth/package.php" style="width: 100%; text-align: center; border: 1px solid rgba(255,255,255,0.2); background: transparent; padding: 0.8rem;">
                            Batal & Kembali
                        </a>
                    </footer>
                </article>
            </div>
            
        </div>
    </div>
</section>

<!-- CSS disesuaikan persis dengan skema warna asli Gymku -->
<style>
/* Base Section mirip pk-section */
.checkout-modern {
  padding: 5rem 1rem;
  min-height: 80vh;
  background-color: var(--bg); /* Dark background */
}
.chk-container {
  max-width: 1100px;
  margin: 0 auto;
}
.chk-head {
  text-align: center;
  margin-bottom: 4rem;
}
.chk-head h2 {
  font-size: clamp(2rem, 5vw, 2.8rem);
  font-weight: 800;
  color: var(--text);
  margin-bottom: 1rem;
  letter-spacing: -0.5px;
}
.chk-head h2 span {
  color: var(--yellow);
}
.chk-head p {
  color: var(--muted);
  font-size: 1.1rem;
  max-width: 600px;
  margin: 0 auto;
}

.chk-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 3rem;
    align-items: start;
}

/* Kiri: Form Area */
.chk-form-area {
    background-color: var(--panel);
    border: 1px solid var(--border);
    border-radius: 1.5rem;
    padding: 2.5rem;
}
.chk-section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 1.5rem;
}

/* Grid Methods */
.chk-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
}
.chk-pm-card input[type="radio"] {
    display: none;
}
.chk-pm-box {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.2rem;
    border: 2px solid var(--border);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.02);
    height: 100%;
}
.chk-pm-card:hover .chk-pm-box {
    border-color: rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.05);
}
.chk-pm-icon {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--text);
    transition: 0.3s;
    flex-shrink: 0;
}
.chk-pm-info {
    flex: 1;
    display: flex;
    flex-direction: column;
}
.chk-pm-name {
    font-weight: 600;
    color: var(--text);
    font-size: 1rem;
    margin-bottom: 0.2rem;
}
.chk-pm-desc {
    font-size: 0.8rem;
    color: var(--muted);
}
.chk-pm-check {
    color: var(--yellow);
    font-size: 1.3rem;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.3s ease;
}

/* Checked State */
.chk-pm-card input[type="radio"]:checked + .chk-pm-box {
    border-color: var(--yellow);
    background: rgba(245, 179, 1, 0.08); /* slight yellow tint based on var(--yellow) */
}
.chk-pm-card input[type="radio"]:checked + .chk-pm-box .chk-pm-icon {
    background: var(--yellow);
    color: #111827; /* dark matching badge txt */
}
.chk-pm-card input[type="radio"]:checked + .chk-pm-box .chk-pm-check {
    opacity: 1;
    transform: scale(1);
}

/* Kanan: Summary Area */
.chk-summary-area {
    position: sticky;
    top: 2rem;
}

@media (max-width: 900px) {
    .chk-grid {
        grid-template-columns: 1fr;
        flex-direction: column-reverse;
    }
    .chk-summary-area {
        position: static;
        order: -1;
    }
}
</style>

<?php require_once __DIR__ . '/../../../layouts/footer.php'; ?>
