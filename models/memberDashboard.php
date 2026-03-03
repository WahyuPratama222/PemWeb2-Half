<?php

function getMemberDashboardData(int $id_user): array
{
    global $pdo;

    // Membership aktif
    $stmt = $pdo->prepare("
        SELECT r.*, p.name AS package_name, p.price, p.day_duration
        FROM registration r
        JOIN packages p ON p.id_package = r.id_package
        WHERE r.id_user = ?
          AND r.status = 'active'
        ORDER BY r.expiry_date DESC
        LIMIT 1
    ");
    $stmt->execute([$id_user]);
    $active_membership = $stmt->fetch();

    // Hitung hari tersisa
    $days_remaining = 0;
    if ($active_membership) {
        $today  = new DateTime();
        $expiry = new DateTime($active_membership['expiry_date']);
        $diff   = $today->diff($expiry);
        $days_remaining = $diff->invert ? 0 : $diff->days;
    }

    // Semua riwayat pendaftaran
    $stmt = $pdo->prepare("
        SELECT r.*, p.name AS package_name, p.price
        FROM registration r
        JOIN packages p ON p.id_package = r.id_package
        WHERE r.id_user = ?
        ORDER BY r.registration_date DESC
    ");
    $stmt->execute([$id_user]);
    $all_registrations = $stmt->fetchAll();

    // Riwayat pembayaran terbaru
    $stmt = $pdo->prepare("
        SELECT pay.*, p.name AS package_name
        FROM payments pay
        JOIN registration r ON r.id_registration = pay.id_registration
        JOIN packages p ON p.id_package = r.id_package
        WHERE r.id_user = ?
        ORDER BY pay.payment_date DESC
        LIMIT 5
    ");
    $stmt->execute([$id_user]);
    $recent_payments = $stmt->fetchAll();

    return compact(
        'active_membership',
        'days_remaining',
        'all_registrations',
        'recent_payments'
    );
}

function getActivePackages(): array
{
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT * FROM packages
        WHERE status = 'Aktif'
        ORDER BY price ASC
    ");
    $stmt->execute();
    return $stmt->fetchAll();
}