<?php

function getAllPackages(): array
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM packages ORDER BY day_duration ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}