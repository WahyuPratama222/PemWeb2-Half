<?php
require_once __DIR__ . '/../../core/init.php';
require_once __DIR__ . '/../../models/Package.php';

require_member();

$packages = getAllPackages();

require_once __DIR__ . '/../pages/member/package_view.php';