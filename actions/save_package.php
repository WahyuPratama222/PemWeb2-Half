<?php
require_once __DIR__ . '/../core/init.php';

require_admin();

$id      = $_POST['id_package'] ?? null; // ada = edit, kosong = tambah
$name    = trim($_POST['name'] ?? '');
$price   = $_POST['price'] ?? 0;
$duration = $_POST['day_duration'] ?? 1;
$status  = $_POST['status'] ?? 'Aktif';

// Validasi
if (empty($name) || $price < 0 || $duration < 1) {
    set_flash('danger', 'Semua kolom wajib diisi dengan benar.');
    redirect(BASE_URL . 'controllers/admin/packages_admin.php');
}

if (!in_array($status, ['Aktif', 'Nonaktif'])) {
    $status = 'Aktif';
}

if ($id) {
    // UPDATE
    $stmt = $pdo->prepare("
        WHERE id_package = ?
    ");
    set_flash('success', 'Paket berhasil diperbarui.');
} else {
    // INSERT
    $stmt = $pdo->prepare("
    ");
    set_flash('success', 'Paket berhasil ditambahkan.');
}

redirect(BASE_URL . 'controllers/admin/packages_admin.php');