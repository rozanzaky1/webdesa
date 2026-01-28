<?php
/**
 * Manual Cache Clear Script for Production Server
 * 
 * Upload this file to your server root and access via browser:
 * https://badransari.web.id/clear-cache.php
 * 
 * This script will automatically delete itself after execution.
 */

echo "<pre>";
echo "=== Laravel Cache Clear Script ===\n\n";

// Change to the correct directory if needed
$baseDir = __DIR__;
chdir($baseDir);

echo "Working directory: " . getcwd() . "\n\n";

$commands = [
    'view:clear' => 'Clear compiled views',
    'cache:clear' => 'Clear application cache',
    'config:clear' => 'Clear config cache',
    'route:clear' => 'Clear route cache'
];

foreach ($commands as $command => $description) {
    echo "[$description]\n";
    echo "Running: php artisan $command\n";
    
    $output = shell_exec("php artisan $command 2>&1");
    echo $output . "\n";
    echo str_repeat("-", 50) . "\n\n";
}

echo "\n✅ All caches cleared successfully!\n\n";

// Auto delete this file after execution
if (file_exists(__FILE__)) {
    if (unlink(__FILE__)) {
        echo "🗑️  This script has been automatically deleted for security.\n";
    } else {
        echo "⚠️  Please manually delete this file: clear-cache.php\n";
    }
}

echo "\n=== Done ===\n";
echo "</pre>";
?>
