<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';

require_member();

$id_user    = current_user()['id_user'];
$id_package = (int) ($_GET['id'] ?? 0);
$extra_days = (int) ($_GET['extra_days'] ?? 0);

if (!$id_package) {
    set_flash('danger', 'Paket tidak valid.');
    redirect(BASE_URL . 'controllers/member/packages_member.php');
}

// Ambil data paket
$stmt = $pdo->prepare("SELECT * FROM packages WHERE id_package = ? AND status = 'Aktif'");
$stmt->execute([$id_package]);
$package = $stmt->fetch();

if (!$package) {
    set_flash('danger', 'Paket tidak ditemukan atau tidak aktif.');
    redirect(BASE_URL . 'controllers/member/packages_member.php');
}

$price_per_day = ceil($package['price'] / $package['day_duration']);
$total_days = $package['day_duration'] + $extra_days;
$total_price = $package['price'] + ($extra_days * $price_per_day);

// Cek apakah member sudah punya membership aktif
$stmt = $pdo->prepare("SELECT COUNT(*) FROM registration WHERE id_user = ? AND status = 'active'");
$stmt->execute([$id_user]);
if ((int) $stmt->fetchColumn() > 0) {
    set_flash('danger', 'Kamu masih memiliki membership aktif. Tunggu hingga masa aktif habis.');
    redirect(BASE_URL . 'controllers/member/packages_member.php');
}

// Proses form checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'] ?? '';
    $start_date     = $_POST['start_date'] ?? date('Y-m-d');

    $valid_methods = ['Transfer Bank', 'Tunai', 'QRIS', 'E-Wallet'];
    if (!in_array($payment_method, $valid_methods)) {
        set_flash('danger', 'Metode pembayaran tidak valid.');
        redirect(BASE_URL . 'controllers/member/checkout_member.php?id=' . $id_package . '&extra_days=' . $extra_days);
    }

    try {
        $pdo->beginTransaction();

        $expiry_date = date('Y-m-d', strtotime($start_date . ' + ' . $total_days . ' days'));

        $stmt = $pdo->prepare("
            INSERT INTO registration (id_user, id_package, start_date, expiry_date, status)
            VALUES (?, ?, ?, ?, 'pending')
        ");
        $stmt->execute([$id_user, $id_package, $start_date, $expiry_date]);
        $id_registration = $pdo->lastInsertId();

        $stmt = $pdo->prepare("
            INSERT INTO payments (id_registration, payment_method, payment_status, amount)
            VALUES (?, ?, 'Belum Lunas', ?)
        ");
        $stmt->execute([$id_registration, $payment_method, $total_price]);

        $pdo->commit();

        set_flash('success', 'Pendaftaran berhasil! Silakan selesaikan pembayaran.');
        redirect(BASE_URL . 'controllers/member/payment_success_member.php?reg_id=' . $id_registration);

    } catch (Exception $e) {
        $pdo->rollBack();
        set_flash('danger', 'Terjadi kesalahan sistem, silakan coba lagi.');
        redirect(BASE_URL . 'controllers/member/checkout_member.php?id=' . $id_package . '&extra_days=' . $extra_days);
    }
}

render_layout_member('member/checkout_member_view.php', [
    'title'       => 'Checkout — Gymku',
    'package'     => $package,
    'id_package'  => $id_package,
    'extra_days'  => $extra_days,
    'total_days'  => $total_days,
    'total_price' => $total_price,
]);