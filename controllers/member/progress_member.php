<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/progress.php';

require_member();
$user = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $toFloatOrNull = fn($x) => ($x === null || $x === '') ? null : (float)$x;

    $existing = getLastProgress((int)$user['id_user']);

    if ($existing) {
        // Update data yang sudah ada
        updateProgress($existing['id_progress'], (int)$user['id_user'], [
            'record_date' => date('Y-m-d'),
            'weight'      => $toFloatOrNull($_POST['weight'] ?? null),
            'height'      => $toFloatOrNull($_POST['height'] ?? null),
            'body_fat'    => $toFloatOrNull($_POST['body_fat'] ?? null),
            'muscle_mass' => $toFloatOrNull($_POST['muscle_mass'] ?? null),
            'chest'       => $toFloatOrNull($_POST['chest'] ?? null),
            'waist'       => $toFloatOrNull($_POST['waist'] ?? null),
            'biceps'      => $toFloatOrNull($_POST['biceps'] ?? null),
            'thigh'       => $toFloatOrNull($_POST['thigh'] ?? null),
        ]);
    } else {
        // Insert pertama kali
        insertProgress([
            'id_user'     => (int)$user['id_user'],
            'record_date' => date('Y-m-d'),
            'weight'      => $toFloatOrNull($_POST['weight'] ?? null),
            'height'      => $toFloatOrNull($_POST['height'] ?? null),
            'body_fat'    => $toFloatOrNull($_POST['body_fat'] ?? null),
            'muscle_mass' => $toFloatOrNull($_POST['muscle_mass'] ?? null),
            'chest'       => $toFloatOrNull($_POST['chest'] ?? null),
            'waist'       => $toFloatOrNull($_POST['waist'] ?? null),
            'biceps'      => $toFloatOrNull($_POST['biceps'] ?? null),
            'thigh'       => $toFloatOrNull($_POST['thigh'] ?? null),
        ]);
    }

    set_flash('success', 'Progress berhasil disimpan.');
    redirect(BASE_URL . 'controllers/member/progress_member.php');
    exit;
}

$progress = getLastProgress((int)$user['id_user']);

render_layout_member('member/progress_member_view.php', [
    'title'    => 'Progress Saya — Gymku',
    'progress' => $progress,
]);