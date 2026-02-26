<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../layouts/main.php';

if (isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Email dan password wajib diisi.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id_user' => $user['id_user'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
            ];

            header('Location: ' . BASE_URL . ($user['role'] === 'Admin' ? 'admin/dashboard.php' : 'index.php'));
            exit;
        } else {
            $error = 'Email atau password salah.';
        }
    }
}

// Pakai render_auth — tanpa navbar & footer
render_auth('login_view.php', [
    'title' => 'Login — Gymku',
    'error' => $error,
]);