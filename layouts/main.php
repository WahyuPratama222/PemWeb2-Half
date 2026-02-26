<?php

// ================================================================
// layouts/main.php — Fungsi render template
// ================================================================

/**
 * render_layout() — Render halaman DENGAN navbar & footer.
 * Cocok untuk: beranda, dashboard, halaman member/admin, dll.
 *
 * @param string $content_file  Path relatif dari folder pages/, contoh: 'admin/dashboard_view.php'
 * @param array  $data          Variabel yang akan tersedia di dalam view
 */
function render_layout(string $content_file, array $data = []): void
{
    extract($data);
    $base_path    = __DIR__ . '/../';
    $content_path = $base_path . 'pages/' . $content_file;

    if (!file_exists($content_path)) {
        die("❌ View tidak ditemukan: pages/{$content_file}");
    }

    include $base_path . 'layouts/header.php';
    include $content_path;
    include $base_path . 'layouts/footer.php';
}

/**
 * render_layout_admin() — Render halaman admin DENGAN sidebar.
 * Cocok untuk semua halaman di dalam admin/.
 *
 * @param string $content_file  Path relatif dari folder pages/, contoh: 'admin/dashboard_view.php'
 * @param array  $data          Variabel yang akan tersedia di dalam view
 */
function render_layout_admin(string $content_file, array $data = []): void
{
    extract($data);
    $base_path    = __DIR__ . '/../';
    $content_path = $base_path . 'pages/' . $content_file;

    if (!file_exists($content_path)) {
        die("❌ View tidak ditemukan: pages/{$content_file}");
    }

    include $base_path . 'layouts/admin_header.php';
    include $content_path;
    include $base_path . 'layouts/admin_footer.php';
}

/**
 * render_auth() — Render halaman TANPA navbar & footer.
 * Cocok untuk: login, register, lupa password, dll.
 *
 * @param string $content_file  Path relatif dari folder pages/, contoh: 'auth/login_view.php'
 * @param array  $data          Variabel yang akan tersedia di dalam view
 */
function render_auth(string $content_file, array $data = []): void
{
    extract($data);
    $base_path    = __DIR__ . '/../';
    $content_path = $base_path . 'pages/' . $content_file;

    if (!file_exists($content_path)) {
        die("❌ View tidak ditemukan: pages/{$content_file}");
    }

    include $base_path . 'layouts/auth_header.php';
    include $content_path;
    include $base_path . 'layouts/auth_footer.php';
}