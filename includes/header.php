<?php
/**
 * includes/header.php
 * Cara pakai:
 *   $page_title = "Nama Halaman";
 *   require_once __DIR__ . '/../includes/header.php';
 */
$page_title = $page_title ?? 'GymSystem';
// $base_url sudah di-set otomatis oleh core/init.php
$base_url = $base_url ?? '/';

$is_logged_in = isset($_SESSION['user_id']);
$role = $_SESSION['role'] ?? 'guest';
$user_name = htmlspecialchars($_SESSION['name'] ?? 'User', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GymSystem — Manajemen gym profesional">
    <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?> | GymSystem</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Global Stylesheet -->
    <link href="<?= $base_url ?>assets/css/style.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-gym sticky-top">
        <div class="container">

            <!-- Brand -->
            <a class="navbar-brand" href="<?= $base_url ?>">
                <i class="bi bi-lightning-charge-fill me-1"></i>Gym<span class="brand-accent">System</span>
            </a>

            <!-- Toggler (mobile) -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav me-auto gap-1">

                    <?php if (!$is_logged_in): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base_url ?>">
                                <i class="bi bi-house-door me-1"></i>Beranda
                            </a>
                        </li>

                    <?php elseif ($role === 'Admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>admin/"><i
                                    class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>admin/members/"><i
                                    class="bi bi-people me-1"></i>Member</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>admin/packages/"><i
                                    class="bi bi-box-seam me-1"></i>Paket</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>admin/payments/"><i
                                    class="bi bi-cash-stack me-1"></i>Pembayaran</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>admin/attendance/"><i
                                    class="bi bi-calendar-check me-1"></i>Absensi</a></li>

                    <?php elseif ($role === 'Member'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>member/"><i
                                    class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>member/progress.php"><i
                                    class="bi bi-graph-up-arrow me-1"></i>Progress</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>member/schedule.php"><i
                                    class="bi bi-calendar3 me-1"></i>Jadwal</a></li>
                    <?php endif; ?>

                </ul>

                <!-- Right -->
                <div class="d-flex align-items-center gap-2">
                    <?php if ($is_logged_in): ?>
                        <span class="text-white-50 small">
                            <i class="bi bi-person-circle me-1"></i><?= $user_name ?>
                            <span class="badge bg-warning text-dark badge-role ms-1"><?= $role ?></span>
                        </span>
                        <a href="<?= $base_url ?>auth/logout.php" class="btn btn-nav-login ms-1">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </a>
                    <?php else: ?>
                        <a href="<?= $base_url ?>auth/login.php" class="btn btn-nav-login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                        <a href="<?= $base_url ?>auth/regist.php" class="btn btn-nav-register">
                            <i class="bi bi-person-plus me-1"></i>Daftar
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </nav>