<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class TestWhatsAppNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test {phone} {--message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test WhatsApp notification dengan mengirim pesan ke nomor telepon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $phone = $this->argument('phone');
        $customMessage = $this->option('message');
        
        $this->info("🔄 Mengirim pesan WhatsApp ke: {$phone}");
        $this->newLine();
        
        // Cek konfigurasi WhatsApp
        $apiKey = config('services.whatsapp.key');
        $apiUrl = config('services.whatsapp.url');
        
        if (empty($apiKey)) {
            $this->error('❌ WHATSAPP_API_KEY belum dikonfigurasi di file .env');
            $this->info('Silakan tambahkan WHATSAPP_API_KEY di file .env');
            return Command::FAILURE;
        }
        
        $this->info("✓ API URL: {$apiUrl}");
        $this->info("✓ API Key: " . substr($apiKey, 0, 10) . "...");
        $this->newLine();
        
        try {
            $whatsapp = new WhatsAppService();
            
            // Cek device status terlebih dahulu
            $this->info("🔍 Mengecek status device...");
            $deviceStatus = $whatsapp->checkDeviceStatus();
            $this->newLine();
            
            if (isset($deviceStatus['status']) && $deviceStatus['status'] === true && isset($deviceStatus['device_status']) && $deviceStatus['device_status'] === 'connect') {
                $this->info("✅ Device Status: CONNECTED");
                if (isset($deviceStatus['name'])) {
                    $this->info("📱 Device Name: " . $deviceStatus['name']);
                }
                if (isset($deviceStatus['device'])) {
                    $this->info("📱 Device Number: " . $deviceStatus['device']);
                }
                if (isset($deviceStatus['quota'])) {
                    $this->info("📊 Quota: " . $deviceStatus['quota'] . " messages");
                }
                if (isset($deviceStatus['expired'])) {
                    $this->info("⏰ Expired: " . $deviceStatus['expired']);
                }
            } else {
                $this->error("⚠️  Device Status: DISCONNECTED atau ERROR");
                $this->warn("Reason: " . ($deviceStatus['reason'] ?? $deviceStatus['error'] ?? 'Unknown'));
                $this->newLine();
                $this->warn("Silakan cek dashboard Fonnte dan pastikan device WhatsApp Anda sudah ter-connect.");
                $this->info("Dashboard: https://md.fonnte.com/");
                return Command::FAILURE;
            }
            $this->newLine();
            
            // Gunakan pesan custom atau pesan default
            if ($customMessage) {
                $message = $customMessage;
            } else {
                $message = "🧪 *Test Notifikasi WhatsApp*\n\n";
                $message .= "Halo! Ini adalah pesan test dari Sistem Informasi Kampung Badran Sari.\n\n";
                $message .= "Jika Anda menerima pesan ini, berarti konfigurasi WhatsApp API sudah berfungsi dengan baik! ✅\n\n";
                $message .= "Waktu pengiriman: " . now()->format('d/m/Y H:i:s') . "\n\n";
                $message .= "Terima kasih!";
            }
            
            $this->info("📤 Mengirim pesan...");
            $this->newLine();
            
            $sent = $whatsapp->sendMessage($phone, $message);
            
            if ($sent) {
                $this->info("✅ Pesan WhatsApp berhasil dikirim!");
                $this->newLine();
                $this->info("💡 Tips: Cek log di storage/logs/laravel.log untuk detail response");
                return Command::SUCCESS;
            } else {
                $this->error("❌ Gagal mengirim pesan WhatsApp");
                $this->info("💡 Cek log di storage/logs/laravel.log untuk error detail");
                return Command::FAILURE;
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            $this->newLine();
            $this->info("💡 Cek log di storage/logs/laravel.log untuk detail lengkap");
            return Command::FAILURE;
        }
    }
}
