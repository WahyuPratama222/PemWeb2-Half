<?php
/**
 * includes/footer.php
 * Cara pakai: require_once __DIR__ . '/../includes/footer.php';
 */
// $base_url sudah di-set otomatis oleh core/init.php
$base_url = $base_url ?? '/';
?>

<footer class="footer-gym mt-auto">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

            <!-- Brand -->
            <div>
                <span class="footer-brand">
                    <i class="bi bi-lightning-charge-fill me-1" style="color:#f59e0b"></i>
                    Gym<span class="brand-accent">System</span>
                </span>
                <p class="small mb-0 mt-1" style="color:rgba(255,255,255,.45)">Platform manajemen gym profesional.</p>
            </div>

            <!-- Quick Links -->
            <ul class="list-unstyled d-flex gap-3 mb-0 small">
                <li><a href="<?= $base_url ?>"><i class="bi bi-house me-1"></i>Beranda</a></li>
                <li><a href="<?= $base_url ?>auth/login.php"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a></li>
                <li><a href="<?= $base_url ?>auth/regist.php"><i class="bi bi-person-plus me-1"></i>Daftar</a></li>
            </ul>

        </div>

        <hr class="footer-divider">

        <p class="text-center small mb-0" style="color:rgba(255,255,255,.35)">
            &copy; <?= date('Y') ?> GymSystem &mdash; Dibuat dengan PHP Native &amp; Bootstrap 5
        </p>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>