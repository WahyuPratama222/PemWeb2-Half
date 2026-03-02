<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/progress.php';

require_member();
$user = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'create_progress') {

    $last = getLastProgress((int)$user['id_user']);

    $pick = function(string $key) use ($last) {
        $v = $_POST[$key] ?? '';
        if ($v === '' || $v === null) return $last[$key] ?? null;
        return $v;
    };

    $record_date = trim($_POST['record_date'] ?? '');
    if ($record_date === '') {
        $record_date = date('Y-m-d');
    }

    $weight      = $pick('weight');
    $height      = $pick('height');
    $body_fat    = $pick('body_fat');
    $muscle_mass = $pick('muscle_mass');
    $chest       = $pick('chest');
    $waist       = $pick('waist');
    $biceps      = $pick('biceps');
    $thigh       = $pick('thigh');

    $toFloatOrNull = fn($x) => ($x === null || $x === '') ? null : (float)$x;

    insertProgress([
        'id_user'     => (int)$user['id_user'],
        'record_date' => $record_date,
        'weight'      => $toFloatOrNull($weight),
        'height'      => $toFloatOrNull($height),
        'body_fat'    => $toFloatOrNull($body_fat),
        'muscle_mass' => $toFloatOrNull($muscle_mass),
        'chest'       => $toFloatOrNull($chest),
        'waist'       => $toFloatOrNull($waist),
        'biceps'      => $toFloatOrNull($biceps),
        'thigh'       => $toFloatOrNull($thigh),
    ]);

    set_flash('success', 'Progress berhasil ditambahkan.');
    redirect(BASE_URL . 'controllers/member/progress_member.php');
    exit;
}


// --- UPDATE PROGRESS TERBARU ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_progress') {

    $id_progress = (int)($_POST['id_progress'] ?? 0);

    $latest = getLastProgress((int)$user['id_user']);
    $record_date = trim($_POST['record_date'] ?? '') ?: ($latest['record_date'] ?? date('Y-m-d'));

    $pick = function(string $key) use ($latest) {
        $v = $_POST[$key] ?? '';
        if ($v === '' || $v === null) return $latest[$key] ?? null;
        return $v;
    };

    $toFloatOrNull = fn($x) => ($x === null || $x === '') ? null : (float)$x;

    $ok = updateProgress($id_progress, (int)$user['id_user'], [
        'record_date' => $record_date,
        'weight'      => $toFloatOrNull($pick('weight')),
        'height'      => $toFloatOrNull($pick('height')),
        'body_fat'    => $toFloatOrNull($pick('body_fat')),
        'muscle_mass' => $toFloatOrNull($pick('muscle_mass')),
        'chest'       => $toFloatOrNull($pick('chest')),
        'waist'       => $toFloatOrNull($pick('waist')),
        'biceps'      => $toFloatOrNull($pick('biceps')),
        'thigh'       => $toFloatOrNull($pick('thigh')),
    ]);

    set_flash('success', 'Progress berhasil diubah');
    redirect(BASE_URL . 'controllers/member/progress_member.php');
    exit;
}

// --- DELETE PROGRESS TERBARU ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_progress') {

    $id_progress = (int)($_POST['id_progress'] ?? 0);
    $ok = deleteProgress($id_progress, (int)$user['id_user']);

    set_flash('success', 'Progress berhasil dihapus.');
    redirect(BASE_URL . 'controllers/member/progress_member.php');
    exit;
}

$chartRows = getRecentProgress((int)$user['id_user']);


// tampilkan list progress
$rows = getProgress((int)$user['id_user']);

render_layout_member('member/progress_member_view.php', [
    'title' => 'Progress Member — Gymku',
    'rows'  => $rows,
    'chartRows' => $chartRows,
]);