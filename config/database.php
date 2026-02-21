<?php

function loadEnv($path) {
    if (!file_exists($path)) {
        return false; // Berhenti jika file .env tidak ditemukan
    }

    // Membaca file per baris, mengabaikan baris kosong
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        // Memasukkan variabel ke sistem environment PHP agar bisa diakses global
        putenv(sprintf('%s=%s', $name, $value));
        $_ENV[$name] = $value;
    }
}

loadEnv(__DIR__ . '/../.env'); // Menjalankan fungsi loadEnv (lokasi .env ada di luar folder config)

$db_status = ""; // Inisialisasi variabel status agar tidak error "Undefined"

try {
    // Mengambil data kredensial dari file .env
    $host = $_ENV['DB_HOST'];
    $db   = $_ENV['DB_NAME'];
    $user = $_ENV['DB_USER'];
    $pass = $_ENV['DB_PASS'];

    // Membuat koneksi database menggunakan PDO (PHP Data Objects)
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    // Mengatur mode error ke Exception agar jika ada query salah, PHP langsung memberitahu lokasinya
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $db_status = "Koneksi Berhasil!"; 
} catch (PDOException $e) {
    // Menangkap error jika koneksi gagal (misal: password salah atau database mati)
    $db_status = "Koneksi Gagal: " . $e->getMessage();
}
?>