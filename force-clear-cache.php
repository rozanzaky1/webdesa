<?php
// Force clear all Laravel cache - Upload file ini ke root hosting via FTP
// Akses via browser: https://yourdomain.com/force-clear-cache.php

echo "<h2>Laravel Cache Cleaner</h2>\n";
echo "<pre>\n";

// Change to project root if needed
chdir(__DIR__);

$commands = [
    'php artisan view:clear',
    'php artisan cache:clear', 
    'php artisan config:clear',
    'php artisan route:clear',
    'php artisan optimize:clear'
];

foreach ($commands as $command) {
    echo "Running: $command\n";
    $output = shell_exec("$command 2>&1");
    echo $output . "\n";
    echo str_repeat('-', 50) . "\n";
}

echo "\n<strong style='color: green;'>✅ All cache cleared successfully!</strong>\n";
echo "</pre>\n";

echo "<p><a href='/'>Go to Homepage</a></p>\n";

// Optional: Auto-delete this file after 5 seconds
echo "<script>setTimeout(function(){ window.location.href = '/'; }, 5000);</script>\n";
echo "<p><em>This page will redirect to homepage in 5 seconds...</em></p>\n";
