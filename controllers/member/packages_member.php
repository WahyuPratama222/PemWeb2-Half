<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../layouts/main.php';
require_once __DIR__ . '/../../models/Package.php';

require_member();

$packages = getActivePackages();

render_layout_member('member/packages_member_view.php', [
    'title'    => 'Paket Gym — Gymku',
    'packages' => $packages,
]);