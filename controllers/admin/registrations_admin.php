<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/registration.php';

require_admin();

try {
    // Ambil semua data registrations
    $registrations = getAllRegistrations();

    render_layout_admin('admin/registrations_admin_view.php', [
        'title'         => 'Data Registrations Member — Gymku',
        'registrations' => $registrations,
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
