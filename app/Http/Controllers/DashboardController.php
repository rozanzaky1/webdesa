<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Family;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // Get hamlets data
        $hamlets = $this->getHamlets();
        $hamletCount = count($hamlets);
        
        // Get online submissions data
        $allSubmissions = $this->getAllSubmissions();
        
        // Count printed letters (approved/completed status)
        $printedLetters = count(array_filter($allSubmissions, function($submission) {
            return in_array($submission['status'] ?? '', ['approved', 'completed']);
        }));
        
        // Count pending verifications
        $pendingVerifications = count(array_filter($allSubmissions, function($submission) {
            return ($submission['status'] ?? '') === 'pending';
        }));
        
        // Get institutions count
        $institutionsCount = count($this->getInstitutions());
        
        // User verification statistics
        $pendingUsers = \App\Models\User::where('role', 'user')->where('is_approved', false)->count();
        $approvedUsers = \App\Models\User::where('role', 'user')->where('is_approved', true)->count();
        $totalUsers = \App\Models\User::where('role', 'user')->count();
        
        // Hitung statistik dari database
        $totalResidents = Resident::where('status', 'active')->count();
        
        // Hitung jumlah keluarga dari tabel families
        $familyCount = Family::count();
        
        // Statistik berdasarkan jenis kelamin (sesuai dengan enum: Male, Female)
        $maleCount = Resident::where('gender', 'Male')->count();
        $femaleCount = Resident::where('gender', 'Female')->count();
        
        // Statistik berdasarkan agama
        $religionStats = Resident::select('religion', DB::raw('count(*) as total'))
            ->whereNotNull('religion')
            ->groupBy('religion')
            ->orderBy('total', 'desc')
            ->get();
        
        // Statistik berdasarkan status perkawinan (sesuai dengan enum)
        $maritalStats = Resident::select('marital_status', DB::raw('count(*) as total'))
            ->groupBy('marital_status')
            ->orderBy('total', 'desc')
            ->get();
        
        // Statistik berdasarkan pekerjaan (top 5)
        $jobStats = Resident::select('occupation', DB::raw('count(*) as total'))
            ->whereNotNull('occupation')
            ->groupBy('occupation')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Hitung berdasarkan kelompok umur (gunakan birth_date)
        $ageGroups = [
            '0-5' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 0 AND 5')->count(),
            '6-12' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 6 AND 12')->count(),
            '13-17' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 13 AND 17')->count(),
            '18-40' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 40')->count(),
            '41-60' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 41 AND 60')->count(),
            '60+' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > 60')->count(),
        ];
        
        return view('pages.dashboard', compact(
            'totalResidents',
            'familyCount',
            'maleCount',
            'femaleCount',
            'religionStats',
            'maritalStats',
            'jobStats',
            'ageGroups',
            'hamlets',
            'hamletCount',
            'institutionsCount',
            'printedLetters',
            'pendingVerifications',
            'pendingUsers',
            'approvedUsers',
            'totalUsers'
        ));
    }
    
    private function getHamlets()
    {
        if (!Storage::disk('local')->exists('hamlets.json')) {
            return [];
        }
        
        return json_decode(Storage::disk('local')->get('hamlets.json'), true) ?? [];
    }
    
    private function getInstitutions()
    {
        if (!Storage::disk('local')->exists('village_institutions.json')) {
            return [];
        }
        
        return json_decode(Storage::disk('local')->get('village_institutions.json'), true) ?? [];
    }
    
    private function getAllSubmissions()
    {
        if (!Storage::disk('local')->exists('online_submissions.json')) {
            return [];
        }
        
        return json_decode(Storage::disk('local')->get('online_submissions.json'), true) ?? [];
    }
}
