<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/Member.php';

require_admin();


$stmt = $pdo->query("SELECT * FROM dashboard_summary LIMIT 1");
$summary = $stmt->fetch();

if (!$summary) {
    $summary = [
        'total_members' => 0,
        'active_memberships' => 0,
        'income_today' => 0,
        'income_this_month' => 0,
        'active_packages' => 0,
        'expired_memberships' => 0,
    ];
}

$pending_payments = getPendingPayments();

render_layout_admin('admin/dashboard_admin_view.php', [
    'title' => 'Dashboard Admin — Gymku',
    'summary' => $summary,
    'pending_payments' => $pending_payments,
]);
