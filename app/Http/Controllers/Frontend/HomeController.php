<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Resident;

class HomeController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_residents' => Resident::where('status', 'active')->count(),
            'total_families' => Resident::where('status', 'active')
                ->distinct('family_card_number')
                ->whereNotNull('family_card_number')
                ->count('family_card_number'),
            'total_hamlets' => $this->getHamletsCount(),
            'total_institutions' => $this->getInstitutionsCount(),
        ];

        // Greeting from village head
        $greeting = $this->getVillageGreeting();

        // Latest news (published only)
        $latestNews = $this->getLatestNews(6);

        return view('frontend.home', compact('stats', 'greeting', 'latestNews'));
    }

    public function profile()
    {
        $profile = $this->getVillageProfile();
        return view('frontend.profile', compact('profile'));
    }

    public function institutions()
    {
        $institutions = $this->getInstitutions();
        return view('frontend.institutions', compact('institutions'));
    }

    private function getHamletsCount()
    {
        if (!Storage::disk('local')->exists('hamlets.json')) {
            return 0;
        }
        $hamlets = json_decode(Storage::disk('local')->get('hamlets.json'), true) ?? [];
        return count($hamlets);
    }

    private function getInstitutionsCount()
    {
        if (!Storage::disk('local')->exists('village_institutions.json')) {
            return 0;
        }
        $institutions = json_decode(Storage::disk('local')->get('village_institutions.json'), true) ?? [];
        return count($institutions);
    }

    private function getVillageGreeting()
    {
        if (!Storage::disk('local')->exists('village_greetings.json')) {
            return null;
        }
        
        $greetings = json_decode(Storage::disk('local')->get('village_greetings.json'), true) ?? [];
        
        // Get published greeting
        $published = collect($greetings)->where('is_published', true)->first();
        return $published;
    }

    private function getLatestNews($limit = 6)
    {
        if (!Storage::disk('local')->exists('news.json')) {
            return [];
        }
        
        $news = json_decode(Storage::disk('local')->get('news.json'), true) ?? [];
        
        // Filter published only
        $published = array_filter($news, function($item) {
            return $item['status'] === 'published';
        });
        
        // Sort by published_at descending
        usort($published, function($a, $b) {
            return strtotime($b['published_at']) - strtotime($a['published_at']);
        });
        
        return array_slice($published, 0, $limit);
    }

    private function getVillageProfile()
    {
        if (!Storage::disk('local')->exists('village_profile.json')) {
            return [
                'village_name' => 'Badran Sari',
                'district' => '',
                'regency' => '',
                'province' => '',
                'postal_code' => '',
                'vision' => '',
                'mission' => '',
                'history' => '',
                'structure_image' => '',
            ];
        }
        
        return json_decode(Storage::disk('local')->get('village_profile.json'), true) ?? [];
    }

    private function getInstitutions()
    {
        if (!Storage::disk('local')->exists('village_institutions.json')) {
            return [];
        }
        
        return json_decode(Storage::disk('local')->get('village_institutions.json'), true) ?? [];
    }
}
