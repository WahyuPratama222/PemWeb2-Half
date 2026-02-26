<?php
$current_page = basename($_SERVER['PHP_SELF']);

$menu = [
    ['href' => 'dashboard.php',  'icon' => 'bi-speedometer2',    'label' => 'Dashboard'],
    ['href' => 'members.php',    'icon' => 'bi-people',           'label' => 'Member'],
    ['href' => 'packages.php',   'icon' => 'bi-tags',             'label' => 'Paket'],
    ['href' => 'registrations.php','icon'=> 'bi-clipboard-check', 'label' => 'Pendaftaran'],
    ['href' => 'payments.php',   'icon' => 'bi-credit-card',      'label' => 'Pembayaran'],
    ['href' => 'attendance.php', 'icon' => 'bi-calendar-check',   'label' => 'Absensi'],
];
?>

<div class="d-flex flex-column flex-shrink-0 bg-dark border-end border-secondary"
     style="width: 240px; min-height: 100vh;">

    <!-- Logo -->
    <a href="<?= BASE_URL ?>admin/dashboard.php"
       class="d-flex align-items-center gap-2 px-3 py-4 text-decoration-none border-bottom border-secondary">
        <i class="bi bi-trophy-fill text-warning fs-5"></i>
        <span class="text-white fw-bold fs-5">Gymku</span>
        <span class="badge bg-warning text-dark ms-auto" style="font-size:.6rem;">Admin</span>
    </a>

    <!-- Nav Menu -->
    <ul class="nav nav-pills flex-column px-2 py-3 gap-1 flex-grow-1">
        <?php foreach ($menu as $item): ?>
            <li class="nav-item">
                <a href="<?= BASE_URL ?>admin/<?= $item['href'] ?>"
                   class="nav-link text-white d-flex align-items-center gap-2
                          <?= $current_page === $item['href'] ? 'active bg-warning text-dark fw-bold' : '' ?>">
                    <i class="bi <?= $item['icon'] ?>"></i>
                    <?= $item['label'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- User info + Logout -->
    <?php $user = current_user(); ?>
    <div class="border-top border-secondary p-3">
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                  style="width:32px;height:32px;font-size:.8rem;">
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            </span>
            <div class="overflow-hidden">
                <div class="text-white small fw-bold text-truncate"><?= escape($user['name']) ?></div>
                <div class="text-white-50" style="font-size:.7rem;"><?= escape($user['email']) ?></div>
            </div>
        </div>
        <a href="<?= BASE_URL ?>auth/logout.php" class="btn btn-outline-danger btn-sm w-100">
            <i class="bi bi-box-arrow-right me-1"></i>Logout
        </a>
    </div>

</div>