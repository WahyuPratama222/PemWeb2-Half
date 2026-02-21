<?php
// Mulai session di semua halaman
session_start();

// Load Database
require_once __DIR__ . '/../config/database.php';

// Load Fungsi bantuan
require_once __DIR__ . '/functions.php';

// Set Waktu
date_default_timezone_set('Asia/Jakarta');