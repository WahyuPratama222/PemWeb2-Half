<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/pendaftaran.php';

require_admin();

try {
    // Ambil semua data pendaftaran
    $pendaftaran = getAllPendaftaran();

    render_layout_admin('admin/pendaftaran_admin_view.php', [
        'title'       => 'Data Pendaftaran Member — Gymku',
        'pendaftaran' => $pendaftaran,
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
