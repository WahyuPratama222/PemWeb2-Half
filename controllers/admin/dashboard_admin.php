<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/member.php';

require_admin();

try {
    $stmt    = $pdo->query("SELECT * FROM dashboard_summary LIMIT 1");
    $summary = $stmt->fetch();

    if (!$summary) {
        $summary = [
            'total_members'       => 0,
            'active_memberships'  => 0,
            'income_today'        => 0,
            'income_this_month'   => 0,
            'active_packages'     => 0,
            'expired_memberships' => 0,
        ];
    }

    $pending_payments = getPendingPayments();

    render_layout_admin('admin/dashboard_admin_view.php', [
        'title'            => 'Dashboard Admin — Gymku',
        'summary'          => $summary,
        'pending_payments' => $pending_payments,
    ]);

} catch (PDOException $e) {
    $error_msg = ($_ENV['APP_ENV'] ?? 'development') === 'development' 
        ? htmlspecialchars($e->getMessage())
        : 'Terjadi kesalahan pada database.';
    
    die(
        '<div style="font-family:monospace;background:#1e1e1e;color:#f44;padding:2rem;">'
        . '❌ <b>Database Error:</b><br><br>'
        . $error_msg . '<br><br>'
        . '<small>Pastikan database sudah di-import dari file <b>db.sql</b></small><br>'
        . '<small>Lihat: <a href="' . BASE_URL . 'test-connection.php" style="color:#0f0;">test-connection.php</a></small>'
        . '</div>'
    );
}