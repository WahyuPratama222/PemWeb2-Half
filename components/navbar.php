<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">
            <i class="bi bi-house-door"></i> Gymku
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'login.php') ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>auth/login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'regist.php') ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>auth/regist.php">Daftar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>