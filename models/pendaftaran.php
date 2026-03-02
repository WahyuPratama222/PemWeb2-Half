<?php

/**
 * Ambil semua data pendaftaran dengan detail member & paket
 * Sorted by registration_date (terbaru dulu)
 */
function getAllPendaftaran(): array
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
 * Hitung jumlah hari tersisa untuk pendaftaran tertentu
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
