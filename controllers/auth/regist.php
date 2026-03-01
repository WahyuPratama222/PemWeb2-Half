<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';

redirect_if_logged_in();

$error = '';
$old   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST;

    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $gender   = $_POST['gender'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (empty($name) || empty($email) || empty($gender) || empty($password)) {
        $error = 'Semua Kolom Wajib Diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format Email Tidak Valid.';
    } elseif (!in_array($gender, ['Laki-Laki', 'Wanita'])) {
        $error = 'Pilih Jenis Kelamin yang Valid.';
    } elseif (strlen($password) < 8) {
        $error = 'Password Minimal 8 Karakter.';
    } elseif ($password !== $confirm) {
        $error = 'Konfirmasi Password Tidak Cocok.';
    } else {
        $stmt = $pdo->prepare("SELECT id_user FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'Email Sudah Terdaftar, Silahkan Gunakan Email Lain.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt   = $pdo->prepare(
                "INSERT INTO users (name, email, gender, password, role)
                 VALUES (?, ?, ?, ?, 'Member')"
            );
            $stmt->execute([$name, $email, $gender, $hashed]);

            set_flash('success', 'Akun Berhasil Dibuat! Silahkan Login.');
            redirect(BASE_URL . 'controllers/auth/login.php');
        }
    }
}

render_auth('auth/register_view.php', [
    'title' => 'Daftar Akun — Gymku',
    'error' => $error,
    'old'   => $old,
]);