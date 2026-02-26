<?php

// ================================================================
// HELPER FUNCTIONS — Gymku
// Semua fungsi bantu global ada di sini.
// ================================================================


// ── Redirect ─────────────────────────────────────────────────────

/**
 * Redirect ke URL tertentu lalu stop eksekusi.
 */
function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}


// ── Session / Auth ────────────────────────────────────────────────

/**
 * Cek apakah user sudah login.
 * Key 'user' sesuai dengan yang di-set di auth/login.php.
 */
function is_logged_in(): bool
{
    return isset($_SESSION['user']) && !empty($_SESSION['user']['id_user']);
}

/**
 * Ambil data user yang sedang login.
 * Return array user, atau null kalau belum login.
 */
function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

/**
 * Cek apakah user yang login adalah Admin.
 */
function is_admin(): bool
{
    return is_logged_in() && ($_SESSION['user']['role'] ?? '') === 'Admin';
}

/**
 * Cek apakah user yang login adalah Member.
 */
function is_member(): bool
{
    return is_logged_in() && ($_SESSION['user']['role'] ?? '') === 'Member';
}


// ── Guard / Middleware ────────────────────────────────────────────

/**
 * Wajib login — redirect ke login jika belum.
 * Taruh di baris pertama setiap halaman yang butuh login.
 *
 * Contoh pemakaian:
 *   require_login();
 */
function require_login(): void
{
    if (!is_logged_in()) {
        redirect(BASE_URL . 'auth/login.php');
    }
}

/**
 * Wajib Admin — redirect ke beranda jika bukan Admin.
 * Otomatis cek login juga.
 *
 * Contoh pemakaian:
 *   require_admin();
 */
function require_admin(): void
{
    require_login();

    if (!is_admin()) {
        redirect(BASE_URL . 'index.php');
    }
}

/**
 * Wajib Member — redirect ke beranda jika bukan Member.
 *
 * Contoh pemakaian:
 *   require_member();
 */
function require_member(): void
{
    require_login();

    if (!is_member()) {
        redirect(BASE_URL . 'index.php');
    }
}

/**
 * Redirect ke dashboard jika sudah login.
 * Pakai di halaman login/register agar user yang sudah login tidak bisa balik.
 *
 * Contoh pemakaian (di login.php):
 *   redirect_if_logged_in();
 */
function redirect_if_logged_in(): void
{
    if (!is_logged_in()) return;

    $role = $_SESSION['user']['role'] ?? '';

    if ($role === 'Admin') {
        redirect(BASE_URL . 'admin/dashboard.php');
    } else {
        redirect(BASE_URL . 'member/dashboard.php');
    }
}


// ── Output / Security ─────────────────────────────────────────────

/**
 * Escape string untuk output HTML — cegah XSS.
 * SELALU pakai ini saat echo data dari DB / user input.
 *
 * Contoh: echo escape($user['name']);
 */
function escape(mixed $string): string
{
    return htmlspecialchars((string) $string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}


// ── Flash Message ─────────────────────────────────────────────────

/**
 * Set flash message (pesan sekali tampil setelah redirect).
 *
 * Contoh:
 *   set_flash('success', 'Data berhasil disimpan!');
 *   redirect(BASE_URL . 'admin/members.php');
 */
function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Ambil & hapus flash message.
 * Return array ['type' => ..., 'message' => ...] atau null.
 */
function get_flash(): ?array
{
    if (!isset($_SESSION['flash'])) return null;

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}

/**
 * Tampilkan flash message sebagai Bootstrap alert (jika ada).
 *
 * Contoh pemakaian di view:
 *   <?php show_flash(); ?>
 */
function show_flash(): void
{
    $flash = get_flash();
    if (!$flash) return;

    $type    = escape($flash['type']);     // success | danger | warning | info
    $message = escape($flash['message']);

    echo <<<HTML
    <div class="alert alert-{$type} alert-dismissible fade show" role="alert">
        {$message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    HTML;
}


// ── Format ────────────────────────────────────────────────────────

/**
 * Format angka ke format Rupiah.
 * Contoh: format_rupiah(150000) → "Rp 150.000"
 */
function format_rupiah(int|float $amount): string
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

/**
 * Format tanggal ke format Indonesia.
 * Contoh: format_date('2024-01-15') → "15 Januari 2024"
 */
function format_date(string $date): string
{
    $bulan = [
        1  => 'Januari',    2  => 'Februari', 3  => 'Maret',
        4  => 'April',      5  => 'Mei',       6  => 'Juni',
        7  => 'Juli',       8  => 'Agustus',   9  => 'September',
        10 => 'Oktober',    11 => 'November',  12 => 'Desember',
    ];

    $ts  = strtotime($date);
    $d   = (int) date('j', $ts);
    $m   = (int) date('n', $ts);
    $y   = date('Y', $ts);

    return "$d {$bulan[$m]} $y";
}