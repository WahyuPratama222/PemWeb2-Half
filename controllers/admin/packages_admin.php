<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/Package.php';

require_admin();

$packages = getAllPackages();

render_layout_admin('admin/package_admin_view.php', [
    'title'    => 'Manajemen Paket — Gymku',
    'packages' => $packages,
]);


