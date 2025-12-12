<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use Illuminate\Support\Facades\DB;

class FamilyController extends Controller
{
    public function index()
    {
        // Hitung statistik keluarga
        $totalFamilies = Resident::distinct('address')->count('address');
        $totalResidents = Resident::count();
        $averageFamilySize = $totalFamilies > 0 ? round($totalResidents / $totalFamilies, 1) : 0;
        
        // Data keluarga berdasarkan address (top 10)
        $families = Resident::select('address', DB::raw('count(*) as members'))
            ->whereNotNull('address')
            ->groupBy('address')
            ->orderBy('members', 'desc')
            ->limit(10)
            ->get();

        // Statistik berdasarkan jumlah anggota keluarga
        $familySizeStats = [
            '1-2 Anggota' => 0,
            '3-4 Anggota' => 0,
            '5-6 Anggota' => 0,
            '7+ Anggota' => 0,
        ];

        $allFamilies = Resident::select('address', DB::raw('count(*) as members'))
            ->whereNotNull('address')
            ->groupBy('address')
            ->get();

        foreach ($allFamilies as $family) {
            if ($family->members <= 2) {
                $familySizeStats['1-2 Anggota']++;
            } elseif ($family->members <= 4) {
                $familySizeStats['3-4 Anggota']++;
            } elseif ($family->members <= 6) {
                $familySizeStats['5-6 Anggota']++;
            } else {
                $familySizeStats['7+ Anggota']++;
            }
        }

        return view('pages.families.index', compact(
            'totalFamilies',
            'totalResidents',
            'averageFamilySize',
            'families',
            'familySizeStats'
        ));
    }
}
