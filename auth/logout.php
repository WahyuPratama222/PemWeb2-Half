<?php
require_once __DIR__ . '/../core/init.php';

// Hapus semua data session
$_SESSION = [];
session_destroy();

// Redirect ke halaman login
redirect(BASE_URL . 'auth/login.php');


