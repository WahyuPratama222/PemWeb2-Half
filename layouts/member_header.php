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
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body class="bg-dark">
    <div class="d-flex" style="min-height: 100vh;">

        <!-- Sidebar Member -->
        <?php require_once __DIR__ . '/../components/sidebar_member.php'; ?>

        <!-- Wrapper kanan: konten + footer -->
        <div class="d-flex flex-column flex-grow-1 overflow-auto">
            <main class="flex-grow-1">
                <!-- Main Content -->