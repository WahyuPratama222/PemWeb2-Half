<?php

/**
 * Ambil semua pembayaran beserta detail member & paket — untuk halaman admin
 */
function getAllPayments(): array
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT
            p.id_payment,
            p.amount,
            p.payment_method,
            p.payment_status,
            p.payment_date,
            r.id_registration,
            r.status    AS registration_status,
            r.start_date,
            r.expiry_date,
            u.name      AS member_name,
            u.email     AS member_email,
            pk.name     AS package_name
        FROM payments p
        JOIN registration r  ON p.id_registration = r.id_registration
        JOIN users u         ON r.id_user = u.id_user
        JOIN packages pk     ON r.id_package = pk.id_package
        ORDER BY p.payment_date DESC
    ");

    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Ambil riwayat pembayaran milik member tertentu
 */
function getPaymentHistoryByUserId(int $userId): array
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT
            p.*,
            r.start_date,
            r.expiry_date,
            pkg.name AS package_name
        FROM payments p
        JOIN registration r  ON p.id_registration = r.id_registration
        JOIN packages pkg     ON r.id_package = pkg.id_package
        WHERE r.id_user = :user_id
        ORDER BY p.payment_date DESC
    ");

    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Cek apakah user memiliki paket aktif
 */
function hasActivePackage(int $userId): bool
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 1 FROM registration
        WHERE id_user = :user_id
        AND status = 'active'
        LIMIT 1
    ");

    $stmt->execute(['user_id' => $userId]);
    return (bool)$stmt->fetch();
}

/**
 * Ambil paket aktif user beserta detail premium-nya
 */
function getActivePackageByUserId(int $userId): ?array
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT
            r.id_registration,
            r.start_date,
            r.expiry_date,
            r.status AS registration_status,
            pkg.id_package,
            pkg.name AS package_name,
            pkg.is_premium,
            pkg.price,
            pkg.day_duration
        FROM registration r
        JOIN packages pkg ON r.id_package = pkg.id_package
        WHERE r.id_user = :user_id
        AND r.status = 'active'
        LIMIT 1
    ");

    $stmt->execute(['user_id' => $userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result ?: null;
}

/**
 * Cek apakah paket aktif user adalah premium
 */
function isActivePackagePremium(int $userId): bool
{
    $activePackage = getActivePackageByUserId($userId);
    return $activePackage && (bool)$activePackage['is_premium'];
}