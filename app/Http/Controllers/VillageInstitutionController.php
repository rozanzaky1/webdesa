<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageInstitutionController extends Controller
{
    private $institutionsPath = 'village_institutions.json';

    public function index()
    {
        $institutions = $this->getInstitutions();
        return view('pages.village-institutions.index', compact('institutions'));
    }

    public function create()
    {
        return view('pages.village-institutions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'structure_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $institutions = $this->getInstitutions();

        $newInstitution = [
            'id' => uniqid(),
            'name' => $request->name,
            'description' => $request->description,
            'structure_image' => null,
            'created_at' => now()->toDateTimeString(),
        ];

        if ($request->hasFile('structure_image')) {
            $path = $request->file('structure_image')->store('institution-structure', 'public');
            $newInstitution['structure_image'] = $path;
        }

        $institutions[] = $newInstitution;
        Storage::disk('local')->put($this->institutionsPath, json_encode($institutions, JSON_PRETTY_PRINT));

        return redirect()->route('village-institutions.index')->with('success', 'Lembaga desa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $institutions = $this->getInstitutions();
        $institution = collect($institutions)->firstWhere('id', $id);

        if (!$institution) {
            return redirect()->route('village-institutions.index')->with('error', 'Lembaga tidak ditemukan!');
        }

        return view('pages.village-institutions.edit', compact('institution'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'structure_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $institutions = $this->getInstitutions();
        $index = collect($institutions)->search(function ($item) use ($id) {
            return $item['id'] === $id;
        });

        if ($index === false) {
            return redirect()->route('village-institutions.index')->with('error', 'Lembaga tidak ditemukan!');
        }

        $institutions[$index]['name'] = $request->name;
        $institutions[$index]['description'] = $request->description;
        $institutions[$index]['updated_at'] = now()->toDateTimeString();

        if ($request->hasFile('structure_image')) {
            // Hapus gambar lama jika ada
            if (isset($institutions[$index]['structure_image']) && Storage::disk('public')->exists($institutions[$index]['structure_image'])) {
                Storage::disk('public')->delete($institutions[$index]['structure_image']);
            }
            
            $path = $request->file('structure_image')->store('institution-structure', 'public');
            $institutions[$index]['structure_image'] = $path;
        }

        Storage::disk('local')->put($this->institutionsPath, json_encode(array_values($institutions), JSON_PRETTY_PRINT));

        return redirect()->route('village-institutions.index')->with('success', 'Lembaga desa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $institutions = $this->getInstitutions();
        $index = collect($institutions)->search(function ($item) use ($id) {
            return $item['id'] === $id;
        });

        if ($index === false) {
            return redirect()->route('village-institutions.index')->with('error', 'Lembaga tidak ditemukan!');
        }

        // Hapus gambar jika ada
        if (isset($institutions[$index]['structure_image']) && Storage::disk('public')->exists($institutions[$index]['structure_image'])) {
            Storage::disk('public')->delete($institutions[$index]['structure_image']);
        }

        unset($institutions[$index]);
        Storage::disk('local')->put($this->institutionsPath, json_encode(array_values($institutions), JSON_PRETTY_PRINT));

        return redirect()->route('village-institutions.index')->with('success', 'Lembaga desa berhasil dihapus!');
    }

    private function getInstitutions()
    {
        if (Storage::disk('local')->exists($this->institutionsPath)) {
            return json_decode(Storage::disk('local')->get($this->institutionsPath), true);
        }

        return [];
    }
}
