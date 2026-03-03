<?php

/**
 * Ambil semua data registrations dengan detail member & paket
 * Sorted by registration_date (terbaru dulu)
 */

function getPendingPayments(): array
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            py.id_payment,
            u.name AS member_name,
            p.name AS package_name,
            py.amount,
            py.payment_date
        FROM payments py
        JOIN registration r ON py.id_registration = r.id_registration
        JOIN users u ON r.id_user = u.id_user
        JOIN packages p ON r.id_package = p.id_package
        WHERE py.payment_status = 'Belum Lunas'
        ORDER BY py.payment_date ASC
        LIMIT 5
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getAllRegistrations(): array
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            r.id_registration,
            r.registration_date,
            r.start_date,
            r.expiry_date,
            r.status,
            u.id_user,
            u.name AS member_name,
            u.email,
            u.gender,
            p.id_package,
            p.name AS package_name,
            p.price,
            p.day_duration
        FROM registration r
        JOIN users u ON r.id_user = u.id_user
        JOIN packages p ON r.id_package = p.id_package
        ORDER BY r.registration_date DESC
    ");
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Hitung jumlah hari tersisa untuk registration tertentu
 */
function calculateDaysRemaining(string $expiry_date): int
{
    $today  = new DateTime();
    $expiry = new DateTime($expiry_date);
    $diff   = $today->diff($expiry);
    
    return $diff->invert ? 0 : $diff->days;
}

/**
 * Get status badge color
 */
function getStatusBadgeClass(string $status): string
{
    return match($status) {
        'active'    => 'bg-success',
        'expired'   => 'bg-danger',
        'pending'   => 'bg-warning',
        'cancelled' => 'bg-secondary',
        default     => 'bg-secondary'
    };
}
