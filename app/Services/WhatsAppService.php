<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.url', 'https://api.fonnte.com/send');
        $this->apiKey = config('services.whatsapp.key');
    }

    /**
     * Kirim pesan WhatsApp
     *
     * @param string $phone Nomor telepon (format: 628xxx)
     * @param string $message Isi pesan
     * @return bool
     */
    public function sendMessage($phone, $message)
    {
        try {
            // Format nomor telepon
            $phone = $this->formatPhoneNumber($phone);

            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->post($this->apiUrl, [
                'target' => $phone,
                'message' => $message,
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp sent successfully', [
                    'phone' => $phone,
                    'response' => $response->json()
                ]);
                return true;
            }

            Log::error('Failed to send WhatsApp', [
                'phone' => $phone,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp service error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format nomor telepon ke format WhatsApp (628xxx)
     *
     * @param string $phone
     * @return string
     */
    protected function formatPhoneNumber($phone)
    {
        // Hapus spasi, strip, dan karakter non-numeric
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Jika diawali 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Jika diawali +62, hapus +
        if (substr($phone, 0, 3) === '+62') {
            $phone = substr($phone, 1);
        }

        // Jika belum diawali 62, tambahkan
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Kirim notifikasi approval akun
     */
    public function sendAccountApproval($user)
    {
        $message = "🎉 *Akun Diverifikasi - Kampung Badran Sari*\n\n";
        $message .= "Halo *{$user->name}*,\n\n";
        $message .= "Selamat! Akun Anda telah diverifikasi oleh administrator.\n\n";
        $message .= "Anda sekarang dapat mengakses semua layanan yang tersedia di Sistem Informasi Kampung Badran Sari.\n\n";
        $message .= "📌 *Login di:* " . url('/login') . "\n\n";
        $message .= "Silakan login dengan email dan password yang Anda daftarkan.\n\n";
        $message .= "Terima kasih telah bergabung dengan kami!\n\n";
        $message .= "---\n";
        $message .= "Salam,\n";
        $message .= "Tim Kampung Badran Sari";

        return $this->sendMessage($user->phone, $message);
    }

    /**
     * Kirim notifikasi surat selesai
     */
    public function sendLetterCompleted($user, $letterType, $letterNumber)
    {
        $message = "✅ *Surat Selesai - Kampung Badran Sari*\n\n";
        $message .= "Halo *{$user->name}*,\n\n";
        $message .= "Surat Anda telah selesai diproses!\n\n";
        $message .= "📋 *Jenis Surat:* {$letterType}\n";
        $message .= "📄 *Nomor Surat:* {$letterNumber}\n\n";
        $message .= "Silakan login ke sistem untuk melihat dan mengunduh surat Anda.\n\n";
        $message .= "🔗 *Login di:* " . url('/login') . "\n\n";
        $message .= "Terima kasih telah menggunakan layanan kami.\n\n";
        $message .= "---\n";
        $message .= "Salam,\n";
        $message .= "Tim Kampung Badran Sari";

        return $this->sendMessage($user->phone, $message);
    }
}
