<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../layouts/main.php';

// Kalau sudah login, tidak perlu register lagi
redirect_if_logged_in();

$error   = '';
$success = '';
$old     = []; // simpan input lama agar tidak hilang saat error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST; // simpan semua input untuk repopulate form

    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $gender   = $_POST['gender'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // ── Validasi ──────────────────────────────────────────────
    if (empty($name) || empty($email) || empty($gender) || empty($password)) {
        $error = 'Semua kolom wajib diisi.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';

    } elseif (!in_array($gender, ['Laki-Laki', 'Wanita'])) {
        $error = 'Pilih jenis kelamin yang valid.';

    } elseif (strlen($password) < 8) {
        $error = 'Password minimal 8 karakter.';

    } elseif ($password !== $confirm) {
        $error = 'Konfirmasi password tidak cocok.';

    } else {
        // ── Cek email sudah terdaftar ──────────────────────────
        $stmt = $pdo->prepare("SELECT id_user FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'Email sudah terdaftar, silakan gunakan email lain.';
        } else {
            // ── Simpan ke database ─────────────────────────────
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, gender, password, role)
                 VALUES (?, ?, ?, ?, 'Member')"
            );
            $stmt->execute([$name, $email, $gender, $hashed]);

            // Flash message lalu redirect ke login
            set_flash('success', 'Akun berhasil dibuat! Silakan login.');
            redirect(BASE_URL . 'auth/login.php');
        }
    }
}

render_auth('auth/register_view.php', [
    'title' => 'Daftar Akun — Gymku',
    'error' => $error,
    'old'   => $old,
]);