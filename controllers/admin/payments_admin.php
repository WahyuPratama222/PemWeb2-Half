<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/Payment.php';

require_admin();

$payments = getAllPayments();

render_layout_admin('admin/payments_admin_view.php', [
    'title'    => 'Pembayaran — Gymku',
    'payments' => $payments,
]);