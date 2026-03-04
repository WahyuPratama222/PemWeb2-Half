<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/member.php';

require_admin();

try {
    $members = getAllMembersWithLatestMembership(); // ← fungsi baru

    render_layout_admin('admin/data_member_view.php', [
        'title'   => 'Data Member — Gymku',
        'members' => $members,
    ]);

} catch (PDOException $e) {
    $error_msg = ($_ENV['APP_ENV'] ?? 'development') === 'development'
        ? htmlspecialchars($e->getMessage())
        : 'Terjadi kesalahan pada database.';

    die(
        '<div style="font-family:monospace;background:#1e1e1e;color:#f44;padding:2rem;">'
        . '❌ <b>Database Error:</b><br><br>'
        . $error_msg
        . '</div>'
    );
}