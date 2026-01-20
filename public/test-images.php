<!DOCTYPE html>
<html>
<head>
    <title>Test Village Institutions Images</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .institution { border: 1px solid #ddd; padding: 20px; margin: 20px 0; }
        img { max-width: 500px; border: 2px solid #4A7C2C; }
        .status { padding: 5px 10px; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Test Village Institutions Images</h1>
    
    <?php
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    use Illuminate\Support\Facades\Storage;
    
    $institutionsPath = 'village_institutions.json';
    $institutions = [];
    
    if (Storage::disk('local')->exists($institutionsPath)) {
        $institutions = json_decode(Storage::disk('local')->get($institutionsPath), true);
    }
    
    echo "<h2>Found " . count($institutions) . " institutions</h2>";
    
    foreach ($institutions as $institution) {
        echo "<div class='institution'>";
        echo "<h3>{$institution['name']}</h3>";
        echo "<p><strong>ID:</strong> {$institution['id']}</p>";
        
        if (!empty($institution['structure_image'])) {
            $imagePath = $institution['structure_image'];
            $fullPath = storage_path('app/public/' . $imagePath);
            $publicPath = asset('storage/' . $imagePath);
            
            echo "<p><strong>Image Path:</strong> {$imagePath}</p>";
            echo "<p><strong>Full Path:</strong> {$fullPath}</p>";
            echo "<p><strong>Public URL:</strong> {$publicPath}</p>";
            
            if (file_exists($fullPath)) {
                echo "<p class='status success'>✓ File exists on disk</p>";
                echo "<img src='{$publicPath}' alt='Structure'>";
            } else {
                echo "<p class='status error'>✗ File NOT found on disk</p>";
            }
        } else {
            echo "<p class='status error'>No structure_image set</p>";
        }
        
        echo "</div>";
    }
    ?>
</body>
</html>
