<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Resident;
use App\Models\Family;
use Illuminate\Support\Facades\DB;

class HamletController extends Controller
{
    public function index(Request $request)
    {
        $hamlets = $this->getHamlets();
        
        // Integrate real-time data from residents and families table
        foreach ($hamlets as &$hamlet) {
            // Count ALL residents in this hamlet (not just active)
            $hamlet['total_residents'] = Resident::where('hamlet', $hamlet['name'])
                ->count();
            
            // Count families from families table
            $hamlet['total_families'] = Family::where('hamlet', $hamlet['name'])
                ->count();
        }
        
        // Search by hamlet name
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $hamlets = array_filter($hamlets, function($hamlet) use ($search) {
                return str_contains(strtolower($hamlet['name'] ?? ''), $search);
            });
        }
        
        // Hitung total penduduk dan keluarga langsung dari database untuk konsistensi
        $totalResidents = Resident::count();
        $totalFamilies = Family::count();
        
        return view('pages.hamlets.index', compact('hamlets', 'totalResidents', 'totalFamilies'));
    }
    
    public function create()
    {
        return view('pages.hamlets.create');
    }
        
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'head_name' => 'required|string|max:255',
            'head_phone' => 'nullable|string|max:20',
            'total_rt' => 'required|integer|min:1',
            'total_rw' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);
        
        $hamlets = $this->getHamlets();
        
        $validated['id'] = uniqid('ham_');
        $validated['created_at'] = now()->format('Y-m-d H:i:s');
        
        $hamlets[] = $validated;
        
        Storage::disk('local')->put('hamlets.json', json_encode($hamlets, JSON_PRETTY_PRINT));
        
        return redirect()->route('hamlets.index')->with('success', 'Data dusun berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $hamlets = $this->getHamlets();
        $hamlet = collect($hamlets)->firstWhere('id', $id);
        
        if (!$hamlet) {
            return redirect()->route('hamlets.index')->with('error', 'Data dusun tidak ditemukan');
        }
        
        return view('pages.hamlets.edit', compact('hamlet'));
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'head_name' => 'required|string|max:255',
            'head_phone' => 'nullable|string|max:20',
            'total_rt' => 'required|integer|min:1',
            'total_rw' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);
        
        $hamlets = $this->getHamlets();
        $index = collect($hamlets)->search(function($hamlet) use ($id) {
            return $hamlet['id'] === $id;
        });
        
        if ($index === false) {
            return redirect()->route('hamlets.index')->with('error', 'Data dusun tidak ditemukan');
        }
        
        $hamlets[$index] = array_merge($hamlets[$index], $validated);
        $hamlets[$index]['updated_at'] = now()->format('Y-m-d H:i:s');
        
        Storage::disk('local')->put('hamlets.json', json_encode(array_values($hamlets), JSON_PRETTY_PRINT));
        
        return redirect()->route('hamlets.index')->with('success', 'Data dusun berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $hamlets = $this->getHamlets();
        $hamlets = array_filter($hamlets, function($hamlet) use ($id) {
            return $hamlet['id'] !== $id;
        });
        
        Storage::disk('local')->put('hamlets.json', json_encode(array_values($hamlets), JSON_PRETTY_PRINT));
        
        return redirect()->route('hamlets.index')->with('success', 'Data dusun berhasil dihapus');
    }
    
    private function getHamlets()
    {
        if (!Storage::disk('local')->exists('hamlets.json')) {
            return [];
        }
        
        return json_decode(Storage::disk('local')->get('hamlets.json'), true) ?? [];
    }
}
