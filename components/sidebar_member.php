<?php
$current_page = basename($_SERVER['PHP_SELF']);

$menu = [
    ['href' => 'dashboard_member.php', 'icon' => 'bi-house-door', 'label' => 'Dashboard'],
    ['href' => 'packages_member.php', 'icon' => 'bi-tags', 'label' => 'Paket Gym'],
    ['href' => 'payments_member.php', 'icon' => 'bi-receipt', 'label' => 'Riwayat Pembayaran'],
    ['href' => 'progress_member.php', 'icon' => 'bi-graph-up-arrow', 'label' => 'Progress Saya'],
];
?>

<div class="d-flex flex-column flex-shrink-0 bg-color-1 border-end" style="width: 240px; height: 100vh; overflow-y: auto; border-color: rgba(29,36,43,0.12) !important;">

    <!-- Logo -->
    <a href="<?= BASE_URL ?>controllers/member/dashboard_member.php"
        class="d-flex align-items-center gap-2 px-3 py-4 text-decoration-none border-bottom flex-shrink-0" style="border-color: rgba(29,36,43,0.12) !important;">
        <i class="bi bi-trophy-fill text-color-2 fs-5"></i>
        <span class="text-color-2 fw-bold fs-5">Gymku</span>
        <span class="badge bg-color-2 ms-auto" style="font-size:.6rem;">Member</span>
    </a>

    <!-- Nav Menu -->
    <ul class="nav nav-pills flex-column px-2 py-3 gap-1 flex-grow-1">
        <?php foreach ($menu as $item): ?>
            <?php $is_active = $current_page === $item['href']; ?>
            <li class="nav-item">
                <a href="<?= BASE_URL ?>controllers/member/<?= $item['href'] ?>"
                    class="nav-link d-flex align-items-center gap-2 <?= $is_active ? 'bg-color-2 fw-bold' : 'text-color-4' ?>"
                    style="<?= $is_active ? 'color: var(--color-1) !important;' : '' ?>">
                    <i class="bi <?= $item['icon'] ?>"></i>
                    <?= $item['label'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- User info + Logout -->
    <?php $user = current_user(); ?>
    <div class="border-top p-3 flex-shrink-0" style="border-color: rgba(29,36,43,0.12) !important;">
        <div class="d-flex align-items-center gap-2 mb-2">
            <span
                class="bg-color-2 rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                style="width:32px;height:32px;font-size:.8rem; color: #fff;">
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            </span>
            <div class="overflow-hidden">
                <div class="text-color-4 small fw-bold text-truncate"><?= escape($user['name']) ?></div>
                <div class="text-muted-dark" style="font-size:.7rem;"><?= escape($user['email']) ?></div>
            </div>
        </div>
        <a href="<?= BASE_URL ?>controllers/auth/logout.php" class="btn btn-outline-color-3 btn-sm w-100">
            <i class="bi bi-box-arrow-right me-1"></i>Logout
        </a>
    </div>

</div>

