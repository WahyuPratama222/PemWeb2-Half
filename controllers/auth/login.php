<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';

// Kalau sudah login, langsung redirect ke dashboard
redirect_if_logged_in();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Email dan Password Wajib Diisi.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id_user' => $user['id_user'],
                'name'    => $user['name'],
                'email'   => $user['email'],
                'role'    => $user['role'],
            ];

            if ($user['role'] === 'Admin') {
                redirect(BASE_URL . 'controllers/admin/dashboard_admin.php');
            } else {
                redirect(BASE_URL . 'controllers/member/dashboard_member.php');
            }
        } else {
            $error = 'Email atau Password Salah.';
        }
    }
}

render_auth('auth/login_view.php', [
    'title' => 'Login — Gymku',
    'error' => $error,
]);