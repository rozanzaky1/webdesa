<?php
/**
 * Storage Symlink Creator for Production
 * Upload this file to public/ folder and access via browser
 * URL: https://yourdomain.com/link-storage.php
 */

echo "<h2>Storage Symlink Creator</h2>";
echo "<pre>";

$target = dirname(__DIR__) . '/storage/app/public';
$link = __DIR__ . '/storage';

echo "Target directory: $target\n";
echo "Symlink location: $link\n\n";

// Check if target exists
if (!is_dir($target)) {
    echo "❌ ERROR: Target directory does not exist!\n";
    echo "Please make sure storage/app/public folder exists.\n";
    exit;
}

// Remove existing link/directory
if (file_exists($link)) {
    if (is_link($link)) {
        unlink($link);
        echo "✓ Removed existing symlink\n";
    } elseif (is_dir($link)) {
        echo "⚠ WARNING: 'storage' is a directory, not a symlink\n";
        echo "Please manually delete or rename public/storage directory first\n";
        exit;
    }
}

// Create symbolic link
if (symlink($target, $link)) {
    echo "\n✅ SUCCESS! Symbolic link created successfully!\n\n";
    echo "Your images should now be accessible at:\n";
    echo "https://yourdomain.com/storage/your-image.jpg\n";
} else {
    echo "\n❌ ERROR: Failed to create symbolic link\n";
    echo "This might be due to server restrictions.\n";
    echo "Please contact your hosting provider or use Laravel's artisan command:\n";
    echo "php artisan storage:link\n";
}

echo "</pre>";
echo "<p><a href='/'>← Back to Homepage</a></p>";

// Auto-delete this file after 10 seconds for security
echo "<script>setTimeout(function(){ window.location.href = '/'; }, 10000);</script>";
echo "<p><em>This page will redirect in 10 seconds...</em></p>";
