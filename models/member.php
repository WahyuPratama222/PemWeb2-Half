<?php

function getPendingPayments(): array
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            py.id_payment,
            u.name  AS member_name,
            p.name  AS package_name,
            py.amount,
            py.payment_date
        FROM payments py
        JOIN registration r ON py.id_registration = r.id_registration
        JOIN users u        ON r.id_user = u.id_user
        JOIN packages p     ON r.id_package = p.id_package
        WHERE py.payment_status = 'Belum Lunas'
        ORDER BY py.payment_date ASC
        LIMIT 5
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getAllMembersWithLatestMembership(): array
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT
            u.id_user,
            u.name       AS member_name,
            u.email,
            u.gender,
            u.created_at AS joined_at,

            r.id_registration,
            r.registration_date,
            r.start_date,
            r.expiry_date,
            r.status,

            p.id_package,
            p.name       AS package_name,
            p.price,
            p.day_duration

        FROM users u

        LEFT JOIN registration r
            ON r.id_registration = (
                SELECT id_registration
                FROM registration
                WHERE id_user = u.id_user
                ORDER BY registration_date DESC
                LIMIT 1
            )

        LEFT JOIN packages p ON p.id_package = r.id_package

        WHERE u.role = 'Member'
        ORDER BY u.created_at DESC
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function calculateDaysRemaining(string $expiry_date): int
{
    $today  = new DateTime();
    $expiry = new DateTime($expiry_date);
    $diff   = $today->diff($expiry);

    return $diff->invert ? 0 : $diff->days;
}

function getStatusBadgeClass(string $status): string
{
    return match ($status) {
        'active'    => 'bg-success',
        'expired'   => 'bg-danger',
        'pending'   => 'bg-warning text-dark',
        'cancelled' => 'bg-secondary',
        default     => 'bg-secondary'
    };
}

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