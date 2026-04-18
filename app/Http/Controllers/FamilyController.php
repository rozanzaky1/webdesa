<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Family;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FamilyController extends Controller
{
    public function index()
    {
        // Ambil semua data keluarga dari database dengan eager loading members
        $families = Family::with('members')->latest()->get();
        
        // Hitung statistik
        $totalFamilies = $families->count();
        
        // Hitung total penduduk langsung dari tabel residents (bukan dari sum total_members)
        $totalMembers = Resident::count();
        
        $averageFamilySize = $totalFamilies > 0 ? round($totalMembers / $totalFamilies, 1) : 0;

        return view('pages.families.index', compact(
            'families',
            'totalFamilies',
            'totalMembers',
            'averageFamilySize'
        ));
    }

    public function create()
    {
        $hamlets = $this->getHamlets();
        return view('pages.families.create', compact('hamlets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kk' => 'required|string|max:25|unique:families,kk',
            'head_name' => 'required|string|max:100',
            'head_nik' => 'nullable|string|max:20',
            'hamlet' => 'nullable|string|max:100',
            'total_members' => 'required|integer|min:1',
        ]);

        Family::create($validated);

        return redirect()->route('families.index')->with('success', 'Data keluarga berhasil ditambahkan');
    }

    public function edit($id)
    {
        $family = Family::findOrFail($id)->toArray();
        $hamlets = $this->getHamlets();
        return view('pages.families.edit', compact('family', 'hamlets'));
    }

    public function update(Request $request, $id)
    {
        $family = Family::findOrFail($id);

        $validated = $request->validate([
            'kk' => 'required|string|max:25|unique:families,kk,' . $id,
            'head_name' => 'required|string|max:100',
            'head_nik' => 'nullable|string|max:20',
            'hamlet' => 'nullable|string|max:100',
            'total_members' => 'required|integer|min:1',
        ]);

        $family->update($validated);

        return redirect()->route('families.index')->with('success', 'Data keluarga berhasil diperbarui');
    }

    public function destroy($id)
    {
        $family = Family::findOrFail($id);
        $family->delete();

        return redirect()->route('families.index')->with('success', 'Data keluarga berhasil dihapus');
    }

    private function getHamlets()
    {
        if (!Storage::disk('local')->exists('hamlets.json')) {
            return [];
        }
        $hamlets = json_decode(Storage::disk('local')->get('hamlets.json'), true) ?? [];
        return collect($hamlets)->pluck('name')->toArray();
    }
}
