<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../models/Package.php';

// kalau halaman ini hanya untuk member, aktifkan guard ini
// require_member();

$packages = getAllPackages();

require_once __DIR__ . '/../pages/auth/package_view.php';