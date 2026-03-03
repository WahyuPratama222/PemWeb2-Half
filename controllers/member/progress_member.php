<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/progress.php';

require_member();
$user = current_user();

if (!isset($_SESSION['compare_preset'])) {
  $_SESSION['compare_preset'] = 'all';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'set_compare_preset') {
  $allowed = ['week','month','quarter','year','all'];
  $p = $_POST['preset'] ?? 'all';
  $_SESSION['compare_preset'] = in_array($p, $allowed, true) ? $p : 'all';
  redirect(BASE_URL . 'controllers/member/progress_member.php');
  exit;
}

if (!isset($_SESSION['progress_show_all'])) {
  $_SESSION['progress_show_all'] = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'toggle_progress_show') {
  $_SESSION['progress_show_all'] = !$_SESSION['progress_show_all'];
  redirect(BASE_URL . 'controllers/member/progress_member.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';
    $toFloatOrNull = fn($x) => ($x === null || $x === '') ? null : (float)$x;

    // Create
    if ($action === 'create_progress') {

        $last = getLastProgress((int)$user['id_user']);

        $pick = function(string $key) use ($last) {
            $v = $_POST[$key] ?? '';
            if ($v === '' || $v === null) return $last[$key] ?? null;
            return $v;
        };

        $record_date = trim($_POST['record_date'] ?? '');
        if ($record_date === '') $record_date = date('Y-m-d');

        insertProgress([
            'id_user'     => (int)$user['id_user'],
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

        set_flash('success', 'Progress berhasil ditambahkan.');
        redirect(BASE_URL . 'controllers/member/progress_member.php');
        exit;
    }

    // Update
    if ($action === 'update_progress') {

        $id_progress = (int)($_POST['id_progress'] ?? 0);

        $existing = getProgressById($id_progress, (int)$user['id_user']);
        if (!$existing) {
            set_flash('danger', 'Data progress tidak ditemukan.');
            redirect(BASE_URL . 'controllers/member/progress_member.php');
            exit;
        }

        $pickOld = function(string $key) use ($existing) {
            $v = $_POST[$key] ?? '';
            if ($v === '' || $v === null) return $existing[$key] ?? null;
            return $v;
        };

        $record_date = trim($_POST['record_date'] ?? '');
        if ($record_date === '') $record_date = ($existing['record_date'] ?? date('Y-m-d'));

        updateProgress($id_progress, (int)$user['id_user'], [
            'record_date'  => $record_date,
            'weight'       => $toFloatOrNull($pickOld('weight')),
            'height'       => $toFloatOrNull($pickOld('height')),
            'body_fat'     => $toFloatOrNull($pickOld('body_fat')),
            'muscle_mass'  => $toFloatOrNull($pickOld('muscle_mass')),
            'chest'        => $toFloatOrNull($pickOld('chest')),
            'waist'        => $toFloatOrNull($pickOld('waist')),
            'biceps'       => $toFloatOrNull($pickOld('biceps')),
            'thigh'        => $toFloatOrNull($pickOld('thigh')),
        ]);

        set_flash('success', 'Progress berhasil diupdate.');
        redirect(BASE_URL . 'controllers/member/progress_member.php');
        exit;
    }

    // Delete
    if ($action === 'delete_progress') {
        $id_progress = (int)($_POST['id_progress'] ?? 0);

        $existing = getProgressById($id_progress, (int)$user['id_user']);
        if (!$existing) {
            set_flash('danger', 'Data progress tidak ditemukan.');
            redirect(BASE_URL . 'controllers/member/progress_member.php');
            exit;
        }

        deleteProgress($id_progress, (int)$user['id_user']);
        
        set_flash('success', 'Progress berhasil dihapus.');
        redirect(BASE_URL . 'controllers/member/progress_member.php');
        exit;
    }
}

$rows = getProgress((int)$user['id_user']);

render_layout_member('member/progress_member_view.php', [
    'title' => 'Progress Member — Gymku',
    'rows' => $rows,
    'show_all' => (bool)$_SESSION['progress_show_all'],
    'preset'  => $_SESSION['compare_preset'],
]);