<?php

// ================================================================
// layouts/main.php — Fungsi render template
// ================================================================

/**
 * render_layout() — Render halaman DENGAN navbar & footer.
 * Cocok untuk: beranda, dll.
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
 * render_layout_admin() — Render halaman admin DENGAN sidebar admin.
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
 * render_layout_member() — Render halaman member DENGAN sidebar member.
 */
function render_layout_member(string $content_file, array $data = []): void
{
    extract($data);
    $base_path    = __DIR__ . '/../';
    $content_path = $base_path . 'pages/' . $content_file;

    if (!file_exists($content_path)) {
        die("❌ View tidak ditemukan: pages/{$content_file}");
    }

    include $base_path . 'layouts/member_header.php';
    include $content_path;
    include $base_path . 'layouts/member_footer.php';
}

/**
 * render_auth() — Render halaman TANPA navbar & footer.
 * Cocok untuk: login, register, dll.
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