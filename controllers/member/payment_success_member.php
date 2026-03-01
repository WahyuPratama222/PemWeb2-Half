<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';

require_member();

$id_user = current_user()['id_user'];
$reg_id  = (int) ($_GET['reg_id'] ?? 0);

if (!$reg_id) {
    redirect(BASE_URL . 'controllers/member/packages_member.php');
}

$stmt = $pdo->prepare("
    SELECT r.*, p.name AS package_name, pay.payment_method, pay.payment_status, pay.amount
    FROM registration r
    JOIN packages p ON r.id_package = p.id_package
    JOIN payments pay ON r.id_registration = pay.id_registration
    WHERE r.id_registration = ? AND r.id_user = ?
");
$stmt->execute([$reg_id, $id_user]);
$transaction = $stmt->fetch();

if (!$transaction) {
    set_flash('danger', 'Detail transaksi tidak ditemukan.');
    redirect(BASE_URL . 'controllers/member/packages_member.php');
}

$virt_account   = '081234567890';
$bank_account   = 'BCA 1234567890 (Gymku Official)';
$payment_method = $transaction['payment_method'];

$instructions = [];

if ($payment_method === 'E-Wallet') {
    $instructions = [
        'Buka aplikasi e-wallet pilihan Anda (OVO, LinkAja, ShopeePay).',
        'Pilih menu <strong>Transfer</strong> atau <strong>Kirim Uang</strong>.',
        'Masukkan nomor Gymku: <strong>' . $virt_account . '</strong>.',
        'Masukkan nominal sebesar ' . format_rupiah($transaction['amount']) . '.',
        'Konfirmasi dan simpan bukti pembayaran.',
    ];
} elseif ($payment_method === 'QRIS') {
    $instructions = [
        'Buka m-BCA, GoPay, OVO, atau aplikasi yang mendukung QRIS.',
        'Pilih opsi <strong>Pindai / Scan QR</strong>.',
        'Tunjukkan atau pindai QR Gymku di meja resepsionis.',
        'Masukkan jumlah ' . format_rupiah($transaction['amount']) . ' dan klik konfirmasi.',
        'Simpan bukti transaksi sukses.',
    ];
} elseif ($payment_method === 'Transfer Bank') {
    $instructions = [
        'Login M-Banking, Internet Banking, atau ATM.',
        'Pilih <strong>Transfer Antar Bank</strong>.',
        'Tujuan transfer: <strong>' . $bank_account . '</strong>.',
        'Masukkan nominal: ' . format_rupiah($transaction['amount']) . '.',
        'Simpan struk atau bukti transfer digital Anda.',
    ];
} elseif ($payment_method === 'Tunai') {
    $instructions = [
        'Kunjungi resepsionis Gymku secara langsung.',
        'Sebutkan nama atau email Anda untuk verifikasi (Order ID: <strong>#REG-' . str_pad($reg_id, 5, '0', STR_PAD_LEFT) . '</strong>).',
        'Lakukan pembayaran tunai sebesar ' . format_rupiah($transaction['amount']) . '.',
        'Status membership akan segera diaktifkan setelah kasir mengonfirmasi.',
    ];
}

render_layout_member('member/payment_success_member_view.php', [
    'title'          => 'Pembayaran Berhasil — Gymku',
    'transaction'    => $transaction,
    'reg_id'         => $reg_id,
    'instructions'   => $instructions,
    'payment_method' => $payment_method,
    'virt_account'   => $virt_account,
    'bank_account'   => $bank_account,
]);