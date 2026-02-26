<?php

/**
 * loadEnv() — Membaca file .env dan memasukkan nilainya ke $_ENV
 * Fix: handle file tidak ditemukan + strip komentar inline (# ...)
 */
function loadEnv(string $path): void
{
    if (!file_exists($path)) {
        die(
            '<div style="font-family:monospace;background:#1e1e1e;color:#f44;padding:2rem;">'
            . '❌ File <b>.env</b> tidak ditemukan.<br>'
            . 'Salin <b>.env.example</b> menjadi <b>.env</b> lalu isi nilainya.'
            . '</div>'
        );
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        // Lewati baris komentar murni (diawali #)
        if (str_starts_with($line, '#')) continue;

        // Pastikan ada tanda '='
        if (!str_contains($line, '=')) continue;

        [$name, $value] = explode('=', $line, 2);

        $name  = trim($name);
        $value = trim($value);

        // Buang komentar inline, contoh: localhost  # komentar → localhost
        if (str_contains($value, '#')) {
            $value = trim(explode('#', $value, 2)[0]);
        }

        // Buang tanda kutip jika ada: "nilai" atau 'nilai' → nilai
        $value = trim($value, '"\'');

        if ($name !== '') {
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
}

// ── Jalankan loadEnv ──────────────────────────────────────────
loadEnv(__DIR__ . '/../.env');

// ── Koneksi PDO ───────────────────────────────────────────────
try {
    $host    = $_ENV['DB_HOST'] ?? 'localhost';
    $db      = $_ENV['DB_NAME'] ?? '';
    $user    = $_ENV['DB_USER'] ?? 'root';
    $pass    = $_ENV['DB_PASS'] ?? '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Error jadi Exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch default array asosiatif
        PDO::ATTR_EMULATE_PREPARES   => false,                   // Gunakan prepared statement asli
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {
    // Tampilkan pesan ramah, sembunyikan detail teknis di production
    $is_dev = ($_ENV['APP_ENV'] ?? 'development') === 'development';

    $detail = $is_dev
        ? '<br><small>' . htmlspecialchars($e->getMessage()) . '</small>'
        : '';

    die(
        '<div style="font-family:monospace;background:#1e1e1e;color:#f44;padding:2rem;">'
        . '❌ Koneksi database gagal.' . $detail
        . '</div>'
    );
}