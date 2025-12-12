<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Resident;
use Illuminate\Support\Facades\Storage;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        $query = Resident::query();
        
        // Filter by hamlet
        if ($request->filled('hamlet')) {
            $query->where('hamlet', $request->hamlet);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by name or NIK
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }
        
        $residents = $query->latest()->get();
        $hamlets = $this->getHamlets();
        
        return view('pages.residents.index', compact('residents', 'hamlets'));
    }

    public function create()
    {
        $hamlets = $this->getHamlets();
        return view('pages.residents.create', compact('hamlets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16|unique:residents,nik',
            'name' => 'required|string|max:100',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'religion' => 'required|string|max:50',
            'occupation' => 'required|string|max:100',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            'address' => 'required|string',
            'hamlet' => 'nullable|string|max:100',
            'family_card_number' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:15',
            'status' => 'required|in:active,moved,deceased',
        ]);
        
        Resident::create($validated);
        
        return redirect()->route('residents.index')->with('success', 'Data penduduk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);
        return view('pages.residents.edit', [
            'resident' => $resident
        ]);
    }

    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        
        $validated = $request->validate([
            'nik' => 'required|string|max:16|unique:residents,nik,' . $id,
            'name' => 'required|string|max:100',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'religion' => 'required|string|max:50',
            'occupation' => 'required|string|max:100',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            'address' => 'required|string',
            'hamlet' => 'nullable|string|max:100',
            'family_card_number' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:15',
            'status' => 'required|in:active,moved,deceased',
        ]);
        
        $resident->update($validated);
        
        return redirect()->route('residents.index')->with('success', 'Data penduduk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();
        
        return redirect()->route('residents.index')->with('success', 'Data penduduk berhasil dihapus');
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
