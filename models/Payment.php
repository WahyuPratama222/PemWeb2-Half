<?php

function getPaymentHistoryByUserId(int $userId): array
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT p.*, r.start_date, r.expiry_date, pkg.name as package_name 
        FROM payments p
        JOIN registration r ON p.id_registration = r.id_registration
        JOIN packages pkg ON r.id_package = pkg.id_package
        WHERE r.id_user = :user_id
        ORDER BY p.payment_date DESC
    ");
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
