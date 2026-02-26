<?php
// ── render_layout ─────────────────────────────────────────────
// Untuk halaman DENGAN navbar & footer (beranda, dashboard, dll.)
function render_layout($content_file, $data = [])
{
    extract($data);
    $base_path = __DIR__ . '/../';

    include $base_path . 'layouts/header.php';
    include $base_path . 'pages/' . $content_file;
    include $base_path . 'layouts/footer.php';
}

// ── render_auth ───────────────────────────────────────────────
// Untuk halaman TANPA navbar & footer (login, register, dll.)
function render_auth($content_file, $data = [])
{
    extract($data);
    $base_path = __DIR__ . '/../';

    include $base_path . 'layouts/auth_header.php';
    include $base_path . 'pages/' . $content_file;
    include $base_path . 'layouts/auth_footer.php';
}
