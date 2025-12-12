<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        // Data dummy verifikasi pengajuan
        $verifications = [
            ['id' => 1, 'applicant_name' => 'Andi Saputra', 'request_type' => 'KTP Baru', 'date' => '2025-11-20', 'status' => 'Menunggu'],
            ['id' => 2, 'applicant_name' => 'Bella Octavia', 'request_type' => 'KK Baru', 'date' => '2025-11-19', 'status' => 'Menunggu'],
            ['id' => 3, 'applicant_name' => 'Citra Dewi', 'request_type' => 'Akta Kelahiran', 'date' => '2025-11-19', 'status' => 'Disetujui'],
            ['id' => 4, 'applicant_name' => 'Dedi Kurniawan', 'request_type' => 'KTP Hilang', 'date' => '2025-11-18', 'status' => 'Menunggu'],
            ['id' => 5, 'applicant_name' => 'Eka Putri', 'request_type' => 'KK Baru', 'date' => '2025-11-18', 'status' => 'Disetujui'],
            ['id' => 6, 'applicant_name' => 'Fajar Ramadhan', 'request_type' => 'Pindah Datang', 'date' => '2025-11-17', 'status' => 'Menunggu'],
            ['id' => 7, 'applicant_name' => 'Gina Safitri', 'request_type' => 'KTP Baru', 'date' => '2025-11-17', 'status' => 'Disetujui'],
            ['id' => 8, 'applicant_name' => 'Hendra Wijaya', 'request_type' => 'Akta Kematian', 'date' => '2025-11-16', 'status' => 'Disetujui'],
            ['id' => 9, 'applicant_name' => 'Ika Sari', 'request_type' => 'KK Baru', 'date' => '2025-11-16', 'status' => 'Ditolak'],
            ['id' => 10, 'applicant_name' => 'Jajang Sutisna', 'request_type' => 'KTP Baru', 'date' => '2025-11-15', 'status' => 'Disetujui'],
        ];

        $totalVerifications = count($verifications);
        
        // Statistik berdasarkan status
        $statusStats = [
            'Menunggu' => 0,
            'Disetujui' => 0,
            'Ditolak' => 0,
        ];
        
        foreach ($verifications as $verification) {
            $statusStats[$verification['status']]++;
        }

        // Statistik berdasarkan jenis pengajuan
        $requestTypeStats = [];
        foreach ($verifications as $verification) {
            if (!isset($requestTypeStats[$verification['request_type']])) {
                $requestTypeStats[$verification['request_type']] = 0;
            }
            $requestTypeStats[$verification['request_type']]++;
        }

        return view('pages.verifications.index', compact(
            'verifications',
            'totalVerifications',
            'statusStats',
            'requestTypeStats'
        ));
    }
}
