<?php

// ================================================================
// HELPER FUNCTIONS — Gymku
// ================================================================

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']) && !empty($_SESSION['user']['id_user']);
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_admin(): bool
{
    return is_logged_in() && ($_SESSION['user']['role'] ?? '') === 'Admin';
}

function is_member(): bool
{
    return is_logged_in() && ($_SESSION['user']['role'] ?? '') === 'Member';
}

function require_login(): void
{
    if (!is_logged_in()) {
        redirect(BASE_URL . 'controllers/auth/login.php');
    }
}

function require_admin(): void
{
    require_login();
    if (!is_admin()) {
        redirect(BASE_URL . 'index.php');
    }
}

function require_member(): void
{
    require_login();
    if (!is_member()) {
        redirect(BASE_URL . 'index.php');
    }
}

function redirect_if_logged_in(): void
{
    if (!is_logged_in()) return;

    $role = $_SESSION['user']['role'] ?? '';

    if ($role === 'Admin') {
        redirect(BASE_URL . 'controllers/admin/dashboard_admin.php');
    } else {
        redirect(BASE_URL . 'controllers/member/dashboard_member.php');
    }
}

function escape(mixed $string): string
{
    return htmlspecialchars((string) $string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (!isset($_SESSION['flash'])) return null;
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function show_flash(): void
{
    $flash = get_flash();
    if (!$flash) return;

    $type    = escape($flash['type']);
    $message = escape($flash['message']);

    echo <<<HTML
    <div class="alert alert-{$type} alert-dismissible fade show" role="alert">
        {$message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    HTML;
}

function format_rupiah(int|float $amount): string
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function format_date(string $date): string
{
    $bulan = [
        1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
        5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
        9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember',
    ];

    $ts = strtotime($date);
    $d  = (int) date('j', $ts);
    $m  = (int) date('n', $ts);
    $y  = date('Y', $ts);

    return "$d {$bulan[$m]} $y";
}