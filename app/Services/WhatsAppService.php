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

            $responseData = $response->json();
            
            // Log detail response
            Log::info('WhatsApp API Response', [
                'phone' => $phone,
                'status_code' => $response->status(),
                'response' => $responseData
            ]);

            // Cek jika response sukses dari Fonnte (status: true)
            if ($response->successful() && isset($responseData['status']) && $responseData['status'] === true) {
                return true;
            }

            // Log error jika gagal
            Log::error('Failed to send WhatsApp', [
                'phone' => $phone,
                'status_code' => $response->status(),
                'response' => $responseData,
                'reason' => $responseData['reason'] ?? 'Unknown error'
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
        $message = "🎉 *AKUN TELAH DIAKTIFKAN*\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "Halo *{$user->name}*,\n\n";
        $message .= "Selamat! Akun Anda telah diverifikasi dan diaktifkan oleh administrator Kampung Badran Sari.\n\n";
        $message .= "📋 *DATA LOGIN ANDA:*\n";
        $message .= "👤 Username: *{$user->email}*\n";
        $message .= "🔐 Password: _Gunakan password yang Anda daftarkan_\n\n";
        $message .= "🌐 *LOGIN DI:*\n";
        $message .= "https://badransari.web.id/login\n\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "✅ *LAYANAN YANG BISA DIAKSES:*\n";
        $message .= "• Pengajuan Surat Online\n";
        $message .= "• Cek Status Permohonan\n\n";
        $message .= "Jika lupa password, silakan gunakan fitur *Lupa Password* di halaman login.\n\n";
        $message .= "Terima kasih telah bergabung dengan kami! 🙏\n\n";
        $message .= "_Salam,_\n";
        $message .= "_Tim Kampung Badran Sari_";

        return $this->sendMessage($user->phone, $message);
    }

    /**
     * Check device status
     */
    public function checkDeviceStatus()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->post('https://api.fonnte.com/device');

            $data = $response->json();
            
            Log::info('Device Status Check', [
                'status_code' => $response->status(),
                'response' => $data
            ]);

            return $data;
        } catch (\Exception $e) {
            Log::error('Failed to check device status: ' . $e->getMessage());
            return ['status' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Kirim notifikasi surat selesai
     */
    public function sendLetterCompleted($user, $letterType, $letterNumber)
    {
        $message = "✅ *SURAT ANDA SUDAH SELESAI*\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "Halo *{$user->name}*,\n\n";
        $message .= "Kabar baik! Surat yang Anda ajukan telah selesai diproses.\n\n";
        $message .= "📋 *DETAIL SURAT:*\n";
        $message .= "• Jenis: *{$letterType}*\n";
        $message .= "• Nomor: *{$letterNumber}*\n";
        $message .= "• Status: *Selesai dan Siap Diambil*\n\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "📥 *CARA MENGAMBIL SURAT:*\n\n";
        $message .= "📍 *Lokasi:* Balai Kampung Badran Sari\n";
        $message .= "🕒 *Jam Kerja:* Senin - Jumat, 08.00 - 15.00 WIB\n";
        $message .= "💳 *Persyaratan:* Bawa KTP/Identitas asli\n\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "⚠️ *Catatan Penting:*\n";
        $message .= "• Surat harus diambil langsung di Balai Desa\n";
        $message .= "• Pastikan datang sesuai jam kerja\n";
        $message .= "• Jika berhalangan hadir, bisa diwakilkan dengan surat kuasa\n\n";
        $message .= "Cek status permohonan Anda:\n";
        $message .= "https://badransari.web.id/login\n\n";
        $message .= "Terima kasih telah menggunakan layanan kami! 🙏\n\n";
        $message .= "_Salam,_\n";
        $message .= "_Tim Kampung Badran Sari_";

        return $this->sendMessage($user->phone, $message);
    }
}
