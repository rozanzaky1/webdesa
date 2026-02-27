<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;
use App\Models\User;

class TestWhatsAppTemplates extends Command
{
    protected $signature = 'whatsapp:test-templates {phone} {--type=all}';
    protected $description = 'Test template notifikasi WhatsApp (approval atau letter)';

    public function handle()
    {
        $phone = $this->argument('phone');
        $type = $this->option('type');
        
        $this->info("🧪 Testing WhatsApp Templates");
        $this->newLine();
        
        $whatsapp = new WhatsAppService();
        
        // Create dummy user object with stdClass instead of Model
        $dummyUser = new \stdClass();
        $dummyUser->name = 'Budi Santoso';
        $dummyUser->email = 'budi.santoso@example.com';
        $dummyUser->phone = $phone;
        
        if ($type === 'all' || $type === 'approval') {
            $this->info("📤 [1/2] Mengirim template AKTIVASI AKUN...");
            
            $sent1 = $whatsapp->sendAccountApproval($dummyUser);
            
            if ($sent1) {
                $this->info("✅ Template aktivasi akun berhasil dikirim!");
            } else {
                $this->error("❌ Template aktivasi akun gagal dikirim!");
            }
            
            $this->newLine();
            
            if ($type === 'all') {
                $this->info("⏳ Menunggu 3 detik sebelum kirim template kedua...");
                sleep(3);
                $this->newLine();
            }
        }
        
        if ($type === 'all' || $type === 'letter') {
            $this->info("📤 [2/2] Mengirim template SURAT SELESAI...");
            
            $sent2 = $whatsapp->sendLetterCompleted(
                $dummyUser,
                'Surat Keterangan Usaha',
                '470/SKU/DS-BS/II/2026'
            );
            
            if ($sent2) {
                $this->info("✅ Template surat selesai berhasil dikirim!");
            } else {
                $this->error("❌ Template surat selesai gagal dikirim!");
            }
            
            $this->newLine();
        }
        
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("✅ Testing selesai! Silakan cek WhatsApp Anda.");
        $this->newLine();
        $this->info("💡 Tips:");
        $this->line("  • Gunakan --type=approval untuk test template aktivasi saja");
        $this->line("  • Gunakan --type=letter untuk test template surat saja");
        $this->line("  • Tanpa --type akan test kedua template");
        
        return Command::SUCCESS;
    }
}
