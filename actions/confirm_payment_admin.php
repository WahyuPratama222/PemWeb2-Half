<?php
require_once __DIR__ . '/../core/init.php';
require_admin();

$payment_id = (int)($_POST['payment_id'] ?? 0);

if (!$payment_id) {
    set_flash('error', 'ID pembayaran tidak valid.');
    redirect(BASE_URL . 'controllers/admin/payments_admin.php');
}

// Cek payment ada dan masih Belum Lunas
$stmt = $pdo->prepare("
    SELECT id_payment, payment_status, id_registration
    FROM payments
    WHERE id_payment = ?
");
$stmt->execute([$payment_id]);
$payment = $stmt->fetch();

if (!$payment) {
    set_flash('error', 'Pembayaran tidak ditemukan.');
    redirect(BASE_URL . 'controllers/admin/payments_admin.php');
}

if ($payment['payment_status'] !== 'Belum Lunas') {
    set_flash('error', 'Pembayaran ini sudah dikonfirmasi sebelumnya.');
    redirect(BASE_URL . 'controllers/admin/payments_admin.php');
}

try {
    $pdo->beginTransaction();

    // 1. Payment → Lunas
    $stmt = $pdo->prepare("UPDATE payments SET payment_status = 'Lunas' WHERE id_payment = ?");
    $stmt->execute([$payment_id]);

    // 2. Registration → active
    $stmt = $pdo->prepare("UPDATE registration SET status = 'active' WHERE id_registration = ?");
    $stmt->execute([$payment['id_registration']]);

    $pdo->commit();

    set_flash('success', 'Pembayaran berhasil dikonfirmasi. Membership member sekarang aktif.');
} catch (Exception $e) {
    $pdo->rollBack();
    set_flash('error', 'Terjadi kesalahan, coba lagi.');
}

redirect(BASE_URL . 'controllers/admin/payments_admin.php');