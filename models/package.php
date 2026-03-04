<?php

function getAllPackages(): array
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM packages ORDER BY day_duration ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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