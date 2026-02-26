<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary shadow-sm">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand fw-bold text-warning" href="<?= BASE_URL ?>">
            <i class="bi bi-trophy-fill me-1"></i> Gymku
        </a>

        <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">

                <?php if (is_logged_in()): ?>
                    <?php $user = current_user(); ?>

                    <?php if (is_admin()): ?>
                        <!-- Menu Admin -->
                        <li class="nav-item">
                            <a class="nav-link <?= $current_page === 'dashboard.php' ? 'active text-warning' : '' ?>"
                               href="<?= BASE_URL ?>admin/dashboard.php">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>admin/members.php">
                                <i class="bi bi-people me-1"></i>Member
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>admin/packages.php">
                                <i class="bi bi-tags me-1"></i>Paket
                            </a>
                        </li>
                    <?php else: ?>
                        <!-- Menu Member -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>member/dashboard.php">
                                <i class="bi bi-house me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>member/progress.php">
                                <i class="bi bi-bar-chart me-1"></i>Progress
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <span class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                  style="width:30px;height:30px;font-size:.8rem;">
                                <?= strtoupper(substr($user['name'], 0, 1)) ?>
                            </span>
                            <span><?= escape($user['name']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end border-secondary">
                            <li>
                                <span class="dropdown-item-text text-white-50 small">
                                    <?= escape($user['email']) ?>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider border-secondary"></li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>auth/logout.php">
                                    <i class="bi bi-box-arrow-right me-2 text-danger"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php else: ?>
                    <!-- Belum login -->
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page === 'login.php' ? 'active text-warning' : '' ?>"
                           href="<?= BASE_URL ?>auth/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning btn-sm fw-bold text-dark ms-lg-2"
                           href="<?= BASE_URL ?>auth/regist.php">Daftar</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>

    </div>
</nav>