<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckFonnteConnection extends Command
{
    protected $signature = 'fonnte:check';
    protected $description = 'Debug Fonnte API connection';

    public function handle()
    {
        $token = config('services.whatsapp.key');
        
        $this->info("=== FONNTE API DEBUG ===");
        $this->newLine();
        
        $this->info("Token dari config: " . $token);
        $this->info("Token length: " . strlen($token));
        $this->newLine();
        
        // Test dengan endpoint validate
        $this->info("Testing dengan endpoint /validate...");
        
        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/validate');
            
            $this->info("Status Code: " . $response->status());
            $this->info("Response:");
            $this->line(json_encode($response->json(), JSON_PRETTY_PRINT));
            $this->newLine();
            
            // Test dengan endpoint /device
            $this->info("Testing dengan endpoint /device...");
            $response2 = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/device');
            
            $this->info("Status Code: " . $response2->status());
            $this->info("Response:");
            $this->line(json_encode($response2->json(), JSON_PRETTY_PRINT));
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
        
        return Command::SUCCESS;
    }
}
