<?php
// 1. Load config & database dulu
require_once __DIR__ . '/core/init.php';

// 2. Load file yang berisi fungsi render_layout (PENTING!)
// Sesuaikan alamatnya, misal kamu simpan di folder 'includes' atau 'layouts'
require_once __DIR__ . '/layouts/main.php'; 

// 3. Baru panggil fungsinya
render_layout('home_view.php', [
    'title' => 'Beranda Gymku',
]);