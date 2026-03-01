<?php
require_once __DIR__ . '/../../core/init.php';

require_member();

$id_user = current_user()['id_user'];
$reg_id  = $_GET['reg_id'] ?? null;

if (!$reg_id) {
    redirect(BASE_URL . 'auth/package.php');
}

$stmt = $pdo->prepare("
    SELECT r.*, p.name AS package_name, pay.payment_method, pay.payment_status, pay.amount 
    FROM registration r
    JOIN packages p ON r.id_package = p.id_package
    JOIN payments pay ON r.id_registration = pay.id_registration
    WHERE r.id_registration = ? AND r.id_user = ?
");
$stmt->execute([$reg_id, $id_user]);
$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transaction) {
    set_flash('danger', 'Detail transaksi tidak ditemukan.');
    redirect(BASE_URL . 'auth/package.php');
}

$virt_account   = '081234567890';
$bank_account   = 'BCA 1234567890 (Gymku Official)';

$instructions = [];
$payment_method = $transaction['payment_method'];

if ($payment_method === 'Dana') {
    $instructions = [
        "Buka aplikasi Dana Anda.",
        "Pilih menu <strong>'Kirim'</strong> atau <strong>'Send'</strong>.",
        "Masukkan nomor DANA Gymku: <strong>$virt_account</strong>.",
        "Masukkan nominal transfer sebesar " . format_rupiah($transaction['amount']),
        "Konfirmasi transfer dan simpan bukti pembayaran.",
    ];
} elseif ($payment_method === 'GoPay') {
    $instructions = [
        "Buka aplikasi Gojek / GoPay Anda.",
        "Pilih <strong>'Bayar'</strong> atau tap icon Scan QR.",
        "Masukkan nomor GoPay Gymku: <strong>$virt_account</strong>.",
        "Masukkan nominal " . format_rupiah($transaction['amount']) . " lalu klik konfirmasi.",
        "Simpan screenshot pembayaran berhasil.",
    ];
} elseif ($payment_method === 'Transfer Bank') {
    $instructions = [
        "Login M-Banking, Internet Banking, atau ATM.",
        "Pilih Transfer antar Bank.",
        "Tujuan: <strong>$bank_account</strong>",
        "Masukkan nominal tagihan: " . format_rupiah($transaction['amount']),
        "Simpan struk / bukti transfer digital Anda.",
    ];
} elseif ($payment_method === 'Cash' || $payment_method === 'Tunai') {
    $instructions = [
        "Kunjungi resepsionis Gymku secara langsung.",
        "Sebutkan email atau nama Anda untuk verifikasi identitas (Order ID: #REG-{$reg_id}).",
        "Lakukan pembayaran tunai sebesar " . format_rupiah($transaction['amount']),
        "Status membership Anda akan segera diaktifkan setelah transaksi kasir berhasil."
    ];
} elseif ($payment_method === 'QRIS') {
    $instructions = [
        "Buka m-BCA, GoPay, OVO, atau aplikasi pembayaran Anda yang mendukung QRIS.",
        "Pilih opsi pindai / scan QR.",
        "Tunjukkan kepada kami atau pindai QR Gymku di meja resepsionis.",
        "Masukkan jumlah " . format_rupiah($transaction['amount']) . " dan klik konfirmasi."
    ];
} elseif ($payment_method === 'E-Wallet') {
     $instructions = [
        "Gunakan e-wallet pilihan Anda (OVO/LinkAja/ShopeePay).",
        "Transfer ke nomor Gymku: <strong>$virt_account</strong>.",
        "Otorisasi nominal sebesar " . format_rupiah($transaction['amount']),
        "Simpan bukti transfer sukses."
    ];
}

require_once __DIR__ . '/../../pages/member/payment/payment_success_view.php';
