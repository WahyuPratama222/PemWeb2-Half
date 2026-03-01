<?php
require_once __DIR__ . '/../../core/init.php';
require_admin();

$title = 'Pembayaran — Gymku';

// Ambil semua pembayaran + join ke registrations + members + packages
$stmt = $pdo->prepare("
    SELECT
        p.id_payment,
        p.amount,
        p.payment_method,
        p.payment_status,
        p.payment_date,
        r.id_registration,
        r.status        AS registration_status,
        r.start_date,
        r.expiry_date,
        u.name          AS member_name,
        u.email         AS member_email,
        pk.name         AS package_name
    FROM payments p
    JOIN registration r  ON p.id_registration = r.id_registration
    JOIN users u         ON r.id_user = u.id_user
    JOIN packages pk     ON r.id_package = pk.id_package
    ORDER BY p.payment_date DESC
");
$stmt->execute();
$payments = $stmt->fetchAll();

require_once __DIR__ . '/../../layouts/admin_header.php';
require_once __DIR__ . '/../../pages/admin/payments_admin_view.php';
require_once __DIR__ . '/../../layouts/admin_footer.php';