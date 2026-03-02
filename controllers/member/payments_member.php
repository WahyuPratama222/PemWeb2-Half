<?php
require_once __DIR__ . '/../../core/init.php';
require_member();

require_once __DIR__ . '/../../models/Payment.php';

$user = current_user();
$payments = getPaymentHistoryByUserId($user['id_user']);

require_once __DIR__ . '/../../pages/member/payments_member_view.php';
