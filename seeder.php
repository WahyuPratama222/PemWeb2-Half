<?php
require_once __DIR__ . '/config/database.php';

$name     = 'Admin Gymku';
$email    = 'admin@gymku.com';
$gender   = 'Laki-Laki';
$password = password_hash('admin123', PASSWORD_BCRYPT);
$role     = 'Admin';

$stmt = $pdo->prepare("
    INSERT INTO users (name, email, gender, password, role)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([$name, $email, $gender, $password, $role]);

echo "✅ Admin berhasil dibuat!<br>";
echo "Email: $email <br>";
echo "Password: admin123";
