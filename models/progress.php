<?php

function getLastProgress(int $id_user): ?array
{
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT *
        FROM progress
        WHERE id_user = ?
        ORDER BY id_progress DESC
        LIMIT 1
    ");
    $stmt->execute([$id_user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}

function insertProgress(array $data): bool
{
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO progress
        (id_user, record_date, weight, height, body_fat, muscle_mass, chest, waist, biceps, thigh, created_at)
        VALUES
        (:id_user, :record_date, :weight, :height, :body_fat, :muscle_mass, :chest, :waist, :biceps, :thigh, NOW())
    ");

    return $stmt->execute([
        'id_user'     => $data['id_user'],
        'record_date' => $data['record_date'],
        'weight'      => $data['weight'],
        'height'      => $data['height'],
        'body_fat'    => $data['body_fat'],
        'muscle_mass' => $data['muscle_mass'],
        'chest'       => $data['chest'],
        'waist'       => $data['waist'],
        'biceps'      => $data['biceps'],
        'thigh'       => $data['thigh'],
    ]);
}

function getProgressById(int $id_progress, int $id_user): ?array
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM progress WHERE id_progress = ? AND id_user = ? LIMIT 1");
    $stmt->execute([$id_progress, $id_user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}

function updateProgress(int $id_progress, int $id_user, array $data): bool
{
    global $pdo;
    $stmt = $pdo->prepare("
        UPDATE progress
        SET record_date = :record_date,
            weight = :weight,
            height = :height,
            body_fat = :body_fat,
            muscle_mass = :muscle_mass,
            chest = :chest,
            waist = :waist,
            biceps = :biceps,
            thigh = :thigh
        WHERE id_progress = :id_progress AND id_user = :id_user
    ");

    return $stmt->execute([
        'record_date'  => $data['record_date'],
        'weight'       => $data['weight'],
        'height'       => $data['height'],
        'body_fat'     => $data['body_fat'],
        'muscle_mass'  => $data['muscle_mass'],
        'chest'        => $data['chest'],
        'waist'        => $data['waist'],
        'biceps'       => $data['biceps'],
        'thigh'        => $data['thigh'],
        'id_progress'  => $id_progress,
        'id_user'      => $id_user,
    ]);
}

function deleteProgress(int $id_progress, int $id_user): bool
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM progress WHERE id_progress = ? AND id_user = ?");
    return $stmt->execute([$id_progress, $id_user]);
}

function getProgress(int $id_user): array
{
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT *
        FROM progress
        WHERE id_user = ?
        ORDER BY record_date DESC, id_progress DESC
    ");
    $stmt->execute([$id_user]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
