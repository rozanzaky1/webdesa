<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageProfileController extends Controller
{
    private $profilePath = 'village_profile.json';

    public function index()
    {
        $profile = $this->getProfile();
        return view('pages.village-profile.index', compact('profile'));
    }

    public function edit()
    {
        $profile = $this->getProfile();
        return view('pages.village-profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'village_name' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'regency' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'history' => 'nullable|string',
            'structure_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $profile = $this->getProfile();

        $profile['village_name'] = $request->village_name;
        $profile['district'] = $request->district;
        $profile['regency'] = $request->regency;
        $profile['province'] = $request->province;
        $profile['postal_code'] = $request->postal_code;
        $profile['vision'] = $request->vision;
        $profile['mission'] = $request->mission;
        $profile['history'] = $request->history;

        if ($request->hasFile('structure_image')) {
            // Hapus gambar lama jika ada
            if (isset($profile['structure_image']) && Storage::disk('public')->exists($profile['structure_image'])) {
                Storage::disk('public')->delete($profile['structure_image']);
            }
            
            $path = $request->file('structure_image')->store('village-structure', 'public');
            $profile['structure_image'] = $path;
        }

        Storage::disk('local')->put($this->profilePath, json_encode($profile, JSON_PRETTY_PRINT));

        return redirect()->route('village-profile.index')->with('success', 'Profil desa berhasil diperbarui!');
    }

    private function getProfile()
    {
        if (Storage::disk('local')->exists($this->profilePath)) {
            return json_decode(Storage::disk('local')->get($this->profilePath), true);
        }

        // Default data
        return [
            'village_name' => 'Desa Badran Sari',
            'district' => 'Kecamatan Punggur',
            'regency' => 'Kabupaten Lampung Tengah',
            'province' => 'Provinsi Lampung',
            'postal_code' => '',
            'vision' => '',
            'mission' => '',
            'history' => '',
            'structure_image' => null,
        ];
    }
}
