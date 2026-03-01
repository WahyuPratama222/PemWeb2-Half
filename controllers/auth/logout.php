<?php
require_once __DIR__ . '/../../core/init.php';

$_SESSION = [];
session_destroy();

redirect(BASE_URL . 'controllers/auth/login.php');