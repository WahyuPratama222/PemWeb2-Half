<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/Member.php';

require_admin();

$members = getAllMembersWithLatestMembership(); 

render_layout_admin('admin/data_member_view.php', [
    'title' => 'Data Member — Gymku',
    'members' => $members,
]);