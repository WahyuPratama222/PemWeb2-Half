<?php
require_once __DIR__ . '/../core/init.php';

require_admin();

$id = (int) ($_GET['id'] ?? 0);

if (!$id) {
    set_flash('danger', 'Paket tidak ditemukan.');
    redirect(BASE_URL . 'controllers/admin/packages_admin.php');
}

// Cek apakah paket masih dipakai di registrasi
$stmt = $pdo->prepare("SELECT COUNT(*) FROM registration WHERE id_package = ?");
$stmt->execute([$id]);
$used = (int) $stmt->fetchColumn();

if ($used > 0) {
    set_flash('danger', 'Paket tidak bisa dihapus karena masih digunakan oleh member.');
    redirect(BASE_URL . 'controllers/admin/packages_admin.php');
}

$stmt = $pdo->prepare("DELETE FROM packages WHERE id_package = ?");
$stmt->execute([$id]);

set_flash('success', 'Paket berhasil dihapus.');
redirect(BASE_URL . 'controllers/admin/packages_admin.php');