<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';

require_admin();

$stmt    = $pdo->query("SELECT * FROM dashboard_summary LIMIT 1");
$summary = $stmt->fetch();

render_layout_admin('admin/dashboard_admin_view.php', [
    'title'   => 'Dashboard Admin — Gymku',
    'summary' => $summary,
]);