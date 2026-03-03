<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/payment.php';

require_member();

$user = current_user();
$payments = getPaymentHistoryByUserId($user['id_user']);

render_layout_member('member/payments_member_view.php', [
    'title'    => 'Riwayat Pembayaran — Gymku',
    'payments' => $payments,
]);