<?php

// ================================================================
// init.php — Bootstrap utama aplikasi
// Wajib di-require di SETIAP file PHP:
//   require_once __DIR__ . '/../core/init.php';
// Sesuaikan jumlah ../ dengan kedalaman folder file tersebut.
// ================================================================

// ── Session ───────────────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Database & Environment ────────────────────────────────────────
// loadEnv() dipanggil di dalam database.php, $pdo tersedia global setelah ini
require_once __DIR__ . '/../config/database.php';

// ── Fungsi Bantuan ────────────────────────────────────────────────
require_once __DIR__ . '/functions.php';

// ── Timezone ──────────────────────────────────────────────────────
date_default_timezone_set('Asia/Jakarta');

// ── Error Reporting ───────────────────────────────────────────────
$_app_env = $_ENV['APP_ENV'] ?? 'development';

if ($_app_env === 'production') {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

// ── BASE_URL (auto-detect) ────────────────────────────────────────
if (!defined('BASE_URL')) {
    $protocol  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host      = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $docRoot   = str_replace('\\', '/', realpath(__DIR__ . '/..'));
    $webRoot   = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
    $basePath  = rtrim(str_replace($webRoot, '', $docRoot), '/') . '/';

    define('BASE_URL', $protocol . '://' . $host . $basePath);
}