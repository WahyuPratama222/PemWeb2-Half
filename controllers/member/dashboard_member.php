<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/MemberDashboard.php';

require_member(); // Wajib login sebagai member

$user = current_user();
$data = getMemberDashboardData($user['id_user']);
$packages = getActivePackages();

render_layout_member('member/dashboard_member_view.php', [
    'title'             => 'Dashboard Member — Gymku',
    'active_membership' => $data['active_membership'],
    'days_remaining'    => $data['days_remaining'],
    'checkins_this_month' => $data['checkins_this_month'],
    'total_checkins'    => $data['total_checkins'],
    'recent_attendance' => $data['recent_attendance'],
    'all_registrations' => $data['all_registrations'],
    'recent_payments'   => $data['recent_payments'],
    'packages'          => $packages,
]);