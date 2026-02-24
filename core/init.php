<?php
// Mulai session di semua halaman
session_start();

// Load Database
require_once __DIR__ . '/../config/database.php';

// Load Fungsi bantuan
require_once __DIR__ . '/functions.php';

// Set Waktu
date_default_timezone_set('Asia/Jakarta');

// ── Error Reporting berbasis Environment ──────────────────────
// development : error tampil di layar (memudahkan debugging)
// production  : error disembunyikan dari user, dicatat di log server
$app_env = $_ENV['APP_ENV'] ?? 'development';

if ($app_env === 'production') {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}


// ── Auto-detect BASE_URL ──────────────────────────────────────
// Deteksi otomatis agar CSS & link selalu benar di localhost maupun production.
// Tidak perlu set BASE_URL di .env.
if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    // Ambil root folder project dari document root
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    // Naik ke root project (jika file berada di subfolder seperti auth/, admin/, dll.)
    $docRoot = str_replace('\\', '/', realpath(__DIR__ . '/..'));
    $webRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
    $basePath = str_replace($webRoot, '', $docRoot);
    $basePath = rtrim($basePath, '/') . '/';

    define('BASE_URL', $protocol . '://' . $host . $basePath);
}

// Buat variabel $base_url agar mudah dipakai di view
$base_url = BASE_URL;