<?php
require_once __DIR__ . '/../../core/init.php';

require_member();

$id_user = current_user()['id_user'];
$id_package = $_GET['id'] ?? null;

if (!$id_package) {
    set_flash('danger', 'Paket tidak valid.');
    redirect(BASE_URL . 'auth/package.php');
}

// Ambil data paket
$stmt = $pdo->prepare("SELECT * FROM packages WHERE id_package = ? AND status = 'Aktif'");
$stmt->execute([$id_package]);
$package = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$package) {
    set_flash('danger', 'Paket tidak ditemukan atau tidak aktif.');
    redirect(BASE_URL . 'auth/package.php');
}

// Proses form checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'] ?? '';
    
    $valid_methods = ['Dana', 'GoPay', 'Cash', 'Transfer Bank', 'Tunai', 'QRIS', 'E-Wallet'];
    if (!in_array($payment_method, $valid_methods)) {
        set_flash('danger', 'Metode pembayaran tidak valid.');
        redirect(BASE_URL . 'member/payment/checkout.php?id=' . $id_package);
    }

    try {
        $pdo->beginTransaction();

        $start_date = date('Y-m-d');
        $expiry_date = date('Y-m-d', strtotime("+" . $package['day_duration'] . " days"));

        $stmt_reg = $pdo->prepare("INSERT INTO registration (id_user, id_package, start_date, expiry_date, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt_reg->execute([$id_user, $id_package, $start_date, $expiry_date]);
        
        $id_registration = $pdo->lastInsertId();

        $stmt_pay = $pdo->prepare("INSERT INTO payments (id_registration, payment_method, payment_status, amount) VALUES (?, ?, 'Belum Lunas', ?)");
        $stmt_pay->execute([$id_registration, $payment_method, $package['price']]);

        $pdo->commit();

        set_flash('success', 'Silakan selesaikan pembayaran Anda.');
        redirect(BASE_URL . 'member/payment/payment_success.php?reg_id=' . $id_registration);

    } catch (Exception $e) {
        $pdo->rollBack();
        set_flash('danger', 'Terjadi kesalahan sistem, silakan coba lagi.');
        redirect(BASE_URL . 'member/payment/checkout.php?id=' . $id_package);
    }
}

require_once __DIR__ . '/../../pages/member/payment/checkout_view.php';
