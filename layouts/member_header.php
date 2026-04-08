<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../core/init.php';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= escape($title ?? 'Member — Gymku') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body class="bg-dark">
    <div class="d-flex" style="height: 100vh; overflow: hidden;">

        <!-- Sidebar Member -->
        <?php require_once __DIR__ . '/../components/sidebar_member.php'; ?>

        <!-- Wrapper kanan -->
        <div class="d-flex flex-column flex-grow-1">
            <main class="flex-grow-1" style="overflow-y: auto;">
                <!-- Main Content -->