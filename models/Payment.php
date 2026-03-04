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