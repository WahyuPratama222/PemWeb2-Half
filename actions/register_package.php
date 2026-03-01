<?php
require_once __DIR__ . '/../core/init.php';

require_member();

$user       = current_user();
$id_package = (int) ($_POST['id_package'] ?? 0);
$start_date = $_POST['start_date'] ?? '';
$pay_method = $_POST['payment_method'] ?? '';

// Validasi
if (!$id_package || empty($start_date) || empty($pay_method)) {
    set_flash('danger', 'Data tidak lengkap, silakan coba lagi.');
    redirect(BASE_URL . 'controllers/member/packages_member.php');
}

// Ambil data paket
$stmt = $pdo->prepare("SELECT * FROM packages WHERE id_package = ? AND status = 'Aktif' LIMIT 1");
$stmt->execute([$id_package]);
$package = $stmt->fetch();

if (!$package) {
    set_flash('danger', 'Paket tidak ditemukan atau sudah tidak aktif.');
    redirect(BASE_URL . 'controllers/member/packages_member.php');
}

// Cek apakah member sudah punya membership aktif
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM registration
    WHERE id_user = ? AND status = 'active'
");
$stmt->execute([$user['id_user']]);
if ((int) $stmt->fetchColumn() > 0) {
    set_flash('danger', 'Kamu masih memiliki membership aktif. Tunggu hingga masa aktif habis.');
    redirect(BASE_URL . 'controllers/member/packages_member.php');
}

// Hitung tanggal berakhir
$expiry_date = date('Y-m-d', strtotime($start_date . ' + ' . $package['day_duration'] . ' days'));

// Simpan registrasi
$stmt = $pdo->prepare("
    INSERT INTO registration (id_user, id_package, start_date, expiry_date, status)
    VALUES (?, ?, ?, ?, 'pending')
");
$stmt->execute([$user['id_user'], $id_package, $start_date, $expiry_date]);
$id_registration = $pdo->lastInsertId();

// Simpan pembayaran
$stmt = $pdo->prepare("
    INSERT INTO payments (id_registration, payment_method, payment_status, amount)
    VALUES (?, ?, 'Belum Lunas', ?)
");
$stmt->execute([$id_registration, $pay_method, $package['price']]);

set_flash('success', 'Pendaftaran berhasil! Menunggu konfirmasi pembayaran dari admin.');
redirect(BASE_URL . 'controllers/member/dashboard_member.php');