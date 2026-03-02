<?php
/**
 * test-connection.php — Cek koneksi database & struktur
 * Akses: http://localhost/PemWeb2-Half/test-connection.php
 */

require_once __DIR__ . '/core/init.php';

echo '<div style="font-family:monospace;background:#1e1e1e;color:#0f0;padding:2rem;">';

// Test 1: Koneksi database
echo "✅ <b>Database Connected!</b> — Koneksi berhasil.<br><br>";

// Test 2: Cek tabel yang ada
$tables = $pdo->query("SHOW TABLES FROM " . $_ENV['DB_NAME'])->fetchAll(PDO::FETCH_COLUMN);
echo "<b>Tabel di Database:</b><br>";
echo "- " . implode("<br>- ", $tables) . "<br><br>";

// Test 3: Cek VIEW dashboard_summary
$viewExists = $pdo->query("SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA='" . $_ENV['DB_NAME'] . "' AND TABLE_NAME='dashboard_summary' AND TABLE_TYPE='VIEW'")->rowCount();
echo ($viewExists ? "✅" : "❌") . " <b>VIEW dashboard_summary:</b> " . ($viewExists ? "Ada" : "Tidak Ada") . "<br><br>";

// Test 4: Coba query dashboard_summary
try {
    $stmt = $pdo->query("SELECT * FROM dashboard_summary LIMIT 1");
    $summary = $stmt->fetch();
    
    echo "<b>Data dari dashboard_summary:</b><br>";
    foreach ($summary as $key => $value) {
        echo "- <b>$key:</b> $value<br>";
    }
} catch (Exception $e) {
    echo "❌ <b>Error query dashboard_summary:</b><br>";
    echo "<small>" . htmlspecialchars($e->getMessage()) . "</small>";
}

echo '<br><br><a href="' . BASE_URL . '" style="color:#0f0;">« Kembali ke Home</a>';
echo '</div>';
?>
