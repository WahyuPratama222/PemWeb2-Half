<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../layouts/main.php';

// 🔒 Hanya Admin yang boleh masuk
require_admin();

// ── Ambil data dashboard dari VIEW ───────────────────────────────
$stmt    = $pdo->query("SELECT * FROM dashboard_summary LIMIT 1");
$summary = $stmt->fetch();

render_layout_admin('admin/dashboard_view.php', [
    'title'   => 'Dashboard Admin — Gymku',
    'summary' => $summary,
]);