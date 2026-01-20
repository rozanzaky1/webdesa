<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Storage;

$institutionsPath = 'village_institutions.json';

echo "Reading from: " . Storage::disk('local')->path($institutionsPath) . "\n\n";

if (Storage::disk('local')->exists($institutionsPath)) {
    $json = Storage::disk('local')->get($institutionsPath);
    echo "Raw JSON preview (first 500 chars):\n";
    echo substr($json, 0, 500) . "\n\n";
    
    $institutions = json_decode($json, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "JSON Error: " . json_last_error_msg() . "\n";
        exit(1);
    }
    
    echo "Found " . count($institutions) . " institutions\n\n";
    
    foreach ($institutions as $idx => $institution) {
        echo "[$idx] {$institution['name']}\n";
        echo "  - ID: {$institution['id']}\n";
        echo "  - structure_image: " . ($institution['structure_image'] ?? 'NOT SET') . "\n\n";
    }
} else {
    echo "File not found!\n";
}

