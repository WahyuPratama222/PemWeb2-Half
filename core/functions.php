<?php
// Fungsi untuk mempermudah redirect halaman
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Fungsi untuk cek apakah user sudah login atau belum
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Fungsi untuk membersihkan input agar aman dari serangan XSS
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}