<?php
require_once __DIR__ . '/../core/init.php';

require_admin();

$id      = $_POST['id_package'] ?? null; // ada = edit, kosong = tambah
$name    = trim($_POST['name'] ?? '');
$price   = $_POST['price'] ?? 0;
$duration = $_POST['day_duration'] ?? 1;
$status  = $_POST['status'] ?? 'Aktif';
$is_premium = isset($_POST['is_premium']) ? 1 : 0;

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
        UPDATE packages SET name = ?, price = ?, day_duration = ?, is_premium = ?, status = ?
        WHERE id_package = ?
    ");
    $stmt->execute([$name, $price, $duration, $is_premium, $status, $id]);
    set_flash('success', 'Paket berhasil diperbarui.');
} else {
    // INSERT
    $stmt = $pdo->prepare("
        INSERT INTO packages (name, price, day_duration, is_premium, status)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$name, $price, $duration, $is_premium, $status]);
    set_flash('success', 'Paket berhasil ditambahkan.');
}

redirect(BASE_URL . 'controllers/admin/packages_admin.php');