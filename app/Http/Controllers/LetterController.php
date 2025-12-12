<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LetterController extends Controller
{
    public function index()
    {
        // Data dummy surat
        $letters = [
            ['id' => 1, 'type' => 'Surat Keterangan Domisili', 'resident_name' => 'Ahmad Sudirman', 'date' => '2025-11-18', 'status' => 'Selesai'],
            ['id' => 2, 'type' => 'Surat Keterangan Usaha', 'resident_name' => 'Siti Aminah', 'date' => '2025-11-17', 'status' => 'Selesai'],
            ['id' => 3, 'type' => 'Surat Pengantar SKCK', 'resident_name' => 'Budi Santoso', 'date' => '2025-11-16', 'status' => 'Selesai'],
            ['id' => 4, 'type' => 'Surat Keterangan Tidak Mampu', 'resident_name' => 'Dewi Kartika', 'date' => '2025-11-15', 'status' => 'Selesai'],
            ['id' => 5, 'type' => 'Surat Keterangan Domisili', 'resident_name' => 'Eko Prasetyo', 'date' => '2025-11-14', 'status' => 'Selesai'],
            ['id' => 6, 'type' => 'Surat Pengantar Nikah', 'resident_name' => 'Fitri Handayani', 'date' => '2025-11-13', 'status' => 'Selesai'],
            ['id' => 7, 'type' => 'Surat Keterangan Usaha', 'resident_name' => 'Gunawan', 'date' => '2025-11-12', 'status' => 'Selesai'],
            ['id' => 8, 'type' => 'Surat Keterangan Domisili', 'resident_name' => 'Hani Wijaya', 'date' => '2025-11-11', 'status' => 'Selesai'],
            ['id' => 9, 'type' => 'Surat Pengantar SKCK', 'resident_name' => 'Indra Kusuma', 'date' => '2025-11-10', 'status' => 'Selesai'],
            ['id' => 10, 'type' => 'Surat Keterangan Tidak Mampu', 'resident_name' => 'Joko Widodo', 'date' => '2025-11-09', 'status' => 'Selesai'],
        ];

        $totalLetters = count($letters);
        
        // Statistik berdasarkan jenis surat
        $letterTypeStats = [];
        foreach ($letters as $letter) {
            if (!isset($letterTypeStats[$letter['type']])) {
                $letterTypeStats[$letter['type']] = 0;
            }
            $letterTypeStats[$letter['type']]++;
        }

        // Statistik bulan ini
        $currentMonth = date('Y-m');
        $lettersThisMonth = array_filter($letters, function($letter) use ($currentMonth) {
            return strpos($letter['date'], $currentMonth) === 0;
        });
        $totalThisMonth = count($lettersThisMonth);

        return view('pages.letters.index', compact(
            'letters',
            'totalLetters',
            'letterTypeStats',
            'totalThisMonth'
        ));
    }
}
