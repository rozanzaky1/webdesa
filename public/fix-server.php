<?php
/**
 * Script untuk memperbaiki error ResidentController di server
 * Jalankan script ini dengan mengakses: https://badransari.web.id/fix-server.php
 * HAPUS file ini setelah selesai digunakan!
 */

// Set timeout lebih lama
set_time_limit(300);
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Fix Server - WebDesa</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; }
        .success { color: #27ae60; padding: 10px; background: #d4edda; border-left: 4px solid #27ae60; margin: 10px 0; }
        .error { color: #c0392b; padding: 10px; background: #f8d7da; border-left: 4px solid #c0392b; margin: 10px 0; }
        .info { color: #2980b9; padding: 10px; background: #d1ecf1; border-left: 4px solid #2980b9; margin: 10px 0; }
        .command { background: #f8f9fa; padding: 10px; border-radius: 4px; margin: 10px 0; font-family: monospace; }
        .warning { color: #f39c12; padding: 10px; background: #fff3cd; border-left: 4px solid #f39c12; margin: 10px 0; }
    </style>
</head>
<body>
<div class='container'>
<h1>🔧 Perbaikan Server WebDesa</h1>
";

try {
    // Cek apakah di root directory yang benar
    $basePath = dirname(__DIR__);
    
    echo "<div class='info'>📂 Base Path: $basePath</div>";
    
    // Cek file penting
    if (!file_exists($basePath . '/artisan')) {
        throw new Exception("File artisan tidak ditemukan. Pastikan script ini ada di folder public/");
    }
    
    echo "<div class='success'>✓ File artisan ditemukan</div>";
    
    // Load Laravel
    require $basePath . '/vendor/autoload.php';
    $app = require_once $basePath . '/bootstrap/app.php';
    
    echo "<div class='success'>✓ Laravel berhasil dimuat</div>";
    
    // Jalankan perintah perbaikan
    echo "<h2>Menjalankan Perintah Perbaikan...</h2>";
    
    // 1. Composer dump-autoload
    echo "<div class='command'>$ composer dump-autoload</div>";
    
    // Coba jalankan composer
    chdir($basePath);
    $composerPath = file_exists('/usr/local/bin/composer') ? '/usr/local/bin/composer' : 'composer';
    $output = shell_exec("$composerPath dump-autoload 2>&1");
    
    if ($output && strpos($output, 'Generated') !== false) {
        echo "<div class='success'>✓ Autoloader berhasil diperbarui</div>";
        echo "<pre style='font-size: 11px; background: #f8f9fa; padding: 10px;'>" . htmlspecialchars($output) . "</pre>";
    } else {
        echo "<div class='warning'>⚠ Composer dump-autoload via shell: " . htmlspecialchars($output ?: 'No output') . "</div>";
    }
    
    // 2. Clear config cache
    echo "<div class='command'>$ php artisan config:clear</div>";
    Artisan::call('config:clear');
    echo "<div class='success'>✓ Config cache berhasil dihapus</div>";
    
    // 3. Clear route cache
    echo "<div class='command'>$ php artisan route:clear</div>";
    Artisan::call('route:clear');
    echo "<div class='success'>✓ Route cache berhasil dihapus</div>";
    
    // 4. Clear view cache
    echo "<div class='command'>$ php artisan view:clear</div>";
    Artisan::call('view:clear');
    echo "<div class='success'>✓ View cache berhasil dihapus</div>";
    
    // 5. Optimize untuk production
    echo "<div class='command'>$ php artisan optimize</div>";
    Artisan::call('optimize');
    echo "<div class='success'>✓ Aplikasi berhasil dioptimalkan</div>";
    
    // 6. Cek apakah ResidentController ada
    echo "<h2>Verifikasi Controller...</h2>";
    $controllerPath = $basePath . '/app/Http/Controllers/ResidentController.php';
    
    if (file_exists($controllerPath)) {
        echo "<div class='success'>✓ ResidentController.php ditemukan di: $controllerPath</div>";
        
        // Cek apakah class bisa dimuat
        if (class_exists('App\Http\Controllers\ResidentController')) {
            echo "<div class='success'>✓ Class ResidentController berhasil dimuat</div>";
        } else {
            echo "<div class='error'>✗ Class ResidentController tidak dapat dimuat</div>";
        }
    } else {
        echo "<div class='error'>✗ File ResidentController.php tidak ditemukan</div>";
    }
    
    // 7. Test route residents
    echo "<h2>Testing Route...</h2>";
    try {
        $routes = Route::getRoutes();
        $residentRoute = $routes->getByName('residents.index');
        
        if ($residentRoute) {
            $action = $residentRoute->getActionName();
            echo "<div class='success'>✓ Route 'residents.index' ditemukan: $action</div>";
        } else {
            echo "<div class='error'>✗ Route 'residents.index' tidak ditemukan</div>";
        }
    } catch (Exception $e) {
        echo "<div class='warning'>⚠ Tidak dapat mengecek route: " . $e->getMessage() . "</div>";
    }
    
    echo "<h2>✅ Perbaikan Selesai!</h2>";
    echo "<div class='success'>";
    echo "<strong>Langkah selanjutnya:</strong><br>";
    echo "1. Coba akses <a href='/residents' target='_blank'>https://badransari.web.id/residents</a><br>";
    echo "2. Jika masih error, refresh browser (Ctrl+F5)<br>";
    echo "3. <strong style='color: red;'>PENTING: HAPUS file fix-server.php ini setelah selesai!</strong>";
    echo "</div>";
    
    echo "<div class='warning'>";
    echo "<strong>⚠️ PERINGATAN KEAMANAN:</strong><br>";
    echo "Segera hapus file fix-server.php dari server Anda untuk keamanan!";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<strong>❌ Error:</strong><br>";
    echo $e->getMessage();
    echo "<br><br><strong>Stack Trace:</strong><br>";
    echo nl2br($e->getTraceAsString());
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<strong>Solusi Alternatif:</strong><br>";
    echo "Jika script ini tidak bekerja, hubungi penyedia hosting Anda dan minta mereka menjalankan perintah berikut di server:<br><br>";
    echo "<code>cd /path/to/webdesa<br>";
    echo "composer dump-autoload<br>";
    echo "php artisan config:clear<br>";
    echo "php artisan route:clear<br>";
    echo "php artisan view:clear<br>";
    echo "php artisan optimize</code>";
    echo "</div>";
}

echo "</div>
</body>
</html>";
