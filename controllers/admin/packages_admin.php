<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/Package.php';

require_admin();

$packages = getAllPackages();

// Load data paket yang mau diedit
$edit_package = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM packages WHERE id_package = ? LIMIT 1");
    $stmt->execute([(int) $_GET['edit']]);
    $edit_package = $stmt->fetch();
}

render_layout_admin('admin/package_admin_view.php', [
    'title'        => 'Manajemen Paket — Gymku',
    'packages'     => $packages,
    'edit_package' => $edit_package,
]);