<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">

            <!-- Logo -->
            <div class="text-center mb-4">
                <i class="bi bi-trophy-fill text-color-2" style="font-size: 2.5rem;"></i>
                <h4 class="text-color-4 fw-bold mt-2">Masuk ke <span class="text-color-4">Gymku</span></h4>
                <p class="text-muted-dark small">Selamat datang kembali!</p>
            </div>

            <!-- Flash message (sukses register, dll.) -->
            <?php show_flash(); ?>

            <!-- Card Form -->
            <div class="card bg-color-1 border border-secondary shadow">
                <div class="card-body p-4">

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                            <i class="bi bi-exclamation-circle me-1"></i> <?= escape($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">

                        <div class="mb-3">
                            <label class="form-label text-color-3 small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control bg-color-1 text-color-4 border-secondary"
                                placeholder="contoh@email.com" value="<?= escape($_POST['email'] ?? '') ?>" required
                                autofocus>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-color-3 small fw-bold">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="passwordInput"
                                    class="form-control bg-color-1 text-color-4 border-secondary" placeholder="€¢€¢€¢€¢€¢€¢€¢€¢"
                                    required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()"
                                    tabindex="-1">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-color-4 fw-bold w-100 border-0">
                            Masuk
                        </button>

                    </form>

                </div>
            </div>

            <p class="text-center text-muted-dark small mt-3">
                Belum punya akun?
                <a href="<?= BASE_URL ?>controllers/auth/regist.php" class="text-color-4 text-decoration-none fw-bold">Daftar sekarang</a>
            </p>

        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>



