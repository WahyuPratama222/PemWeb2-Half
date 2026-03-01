<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<section class="pk-section">
  <div class="pk-container">
    <div class="pk-head">
      <h2>Pilih Paket <span>Gymku</span></h2>
      <p>Tersedia 3 pilihan paket: Basic (30), Standard (60), Premium (90).</p>
    </div>

    <?php if (empty($packages)): ?>
      <div class="pk-empty">Paket belum tersedia.</div>
    <?php else: ?>

      <!-- Pastikan tampil 3 card saja (kalau DB ada lebih dari 3 data) -->
      <?php $packages = array_slice($packages, 0, 3); ?>

      <div class="pk-grid">
        <?php foreach ($packages as $p): ?>
          <?php
            // Standard (60 hari) jadi featured
            $isFeatured = ((int)$p['day_duration'] === 60);
            $cardClass  = $isFeatured ? 'pk-card pk-featured' : 'pk-card';
            $btnClass   = $isFeatured ? 'pk-btn pk-btn--yellow' : 'pk-btn';

            // Subjudul singkat sesuai nama paket (opsional)
            $tagline = match ((int)$p['day_duration']) {
              30 => 'Cocok untuk pemula',
              60 => 'Paling populer untuk konsisten',
              90 => 'Untuk hasil maksimal',
              default => 'Paket latihan terbaik'
            };
          ?>

          <article class="<?= $cardClass; ?>">
            <header class="pk-card__top">
              <div class="pk-title-row">
                <h3 class="pk-title"><?= escape($p['name']); ?></h3>
                <?php if ($isFeatured): ?>
                  <span class="pk-badge">Paling Populer</span>
                <?php endif; ?>
              </div>

              <div class="pk-price">
                <span class="pk-currency">Rp</span>
                <span class="pk-amount"><?= number_format((float)$p['price'], 0, ',', '.'); ?></span>
              </div>

              <div class="pk-sub">
                <span class="pk-duration"><?= escape($p['day_duration']); ?> Hari</span>
                <span class="pk-dot">•</span>
                <span class="pk-note"><?= escape($tagline); ?></span>
              </div>
            </header>

            <div class="pk-line"></div>

            <ul class="pk-features">
              <li>Akses gym selama <?= escape($p['day_duration']); ?> hari</li>
              <li>Free konsultasi 1x</li>
              <li>Locker tersedia</li>
              <li>Jam operasional fleksibel</li>
            </ul>

            <footer class="pk-actions">
              <a class="<?= $btnClass; ?>" href="#">
                Pilih Paket
              </a>
            </footer>
          </article>
        <?php endforeach; ?>
      </div>

    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>