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
        
        // Load all data for client-side search and pagination
        $residents = $query->latest()->get();
        $hamlets = $this->getHamlets();
        
        // Hitung statistik
        $stats = [
            'total' => Resident::count(),
            'active' => Resident::where('status', 'active')->count(),
            'inactive' => Resident::where('status', '!=', 'active')->count(),
        ];
        
        return view('pages.residents.index', compact('residents', 'hamlets', 'stats'));
    }

    public function create()
    {
        $hamlets = $this->getHamlets();
        return view('pages.residents.create', compact('hamlets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|min:16|max:16|unique:residents,nik',
            'name' => 'required|string|max:100',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'religion' => 'required|string|max:50',
            'occupation' => 'required|string|max:100',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            'address' => 'required|string',
            'hamlet' => 'nullable|string|max:100',
            'family_card_number' => 'required|string|min:16|max:16',
            'phone' => 'nullable|string|max:15',
            'status' => 'required|in:active,moved,deceased',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.min' => 'NIK harus tepat 16 digit',
            'nik.max' => 'NIK harus tepat 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'name.required' => 'Nama lengkap wajib diisi',
            'name.max' => 'Nama lengkap maksimal 100 karakter',
            'birth_place.required' => 'Tempat lahir wajib diisi',
            'birth_place.max' => 'Tempat lahir maksimal 100 karakter',
            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'birth_date.date' => 'Format tanggal lahir tidak valid',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'gender.in' => 'Jenis kelamin tidak valid',
            'religion.required' => 'Agama wajib dipilih',
            'religion.max' => 'Agama maksimal 50 karakter',
            'occupation.required' => 'Pekerjaan wajib diisi',
            'occupation.max' => 'Pekerjaan maksimal 100 karakter',
            'marital_status.required' => 'Status perkawinan wajib dipilih',
            'marital_status.in' => 'Status perkawinan tidak valid',
            'address.required' => 'Alamat wajib diisi',
            'hamlet.max' => 'Dusun maksimal 100 karakter',
            'family_card_number.required' => 'Nomor KK wajib diisi',
            'family_card_number.min' => 'Nomor KK harus tepat 16 digit',
            'family_card_number.max' => 'Nomor KK harus tepat 16 digit',
            'phone.max' => 'Nomor telepon maksimal 15 karakter',
            'status.required' => 'Status penduduk wajib dipilih',
            'status.in' => 'Status penduduk tidak valid',
        ]);
        
        $resident = Resident::create($validated);
        
        // Auto-manage family data berdasarkan No. KK
        if ($validated['family_card_number']) {
            $this->manageFamily($resident);
        }
        
        return redirect()->route('residents.index')->with('success', 'Data penduduk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);
        $hamlets = $this->getHamlets();
        return view('pages.residents.edit', [
            'resident' => $resident,
            'hamlets' => $hamlets
        ]);
    }

    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        
        $validated = $request->validate([
            'nik' => 'required|string|min:16|max:16|unique:residents,nik,' . $id,
            'name' => 'required|string|max:100',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'religion' => 'required|string|max:50',
            'occupation' => 'required|string|max:100',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            'address' => 'required|string',
            'hamlet' => 'nullable|string|max:100',
            'family_card_number' => 'required|string|min:16|max:16',
            'phone' => 'nullable|string|max:15',
            'status' => 'required|in:active,moved,deceased',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.min' => 'NIK harus tepat 16 digit',
            'nik.max' => 'NIK harus tepat 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'name.required' => 'Nama lengkap wajib diisi',
            'name.max' => 'Nama lengkap maksimal 100 karakter',
            'birth_place.required' => 'Tempat lahir wajib diisi',
            'birth_place.max' => 'Tempat lahir maksimal 100 karakter',
            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'birth_date.date' => 'Format tanggal lahir tidak valid',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'gender.in' => 'Jenis kelamin tidak valid',
            'religion.required' => 'Agama wajib dipilih',
            'religion.max' => 'Agama maksimal 50 karakter',
            'occupation.required' => 'Pekerjaan wajib diisi',
            'occupation.max' => 'Pekerjaan maksimal 100 karakter',
            'marital_status.required' => 'Status perkawinan wajib dipilih',
            'marital_status.in' => 'Status perkawinan tidak valid',
            'address.required' => 'Alamat wajib diisi',
            'hamlet.max' => 'Dusun maksimal 100 karakter',
            'family_card_number.required' => 'Nomor KK wajib diisi',
            'family_card_number.min' => 'Nomor KK harus tepat 16 digit',
            'family_card_number.max' => 'Nomor KK harus tepat 16 digit',
            'phone.max' => 'Nomor telepon maksimal 15 karakter',
            'status.required' => 'Status penduduk wajib dipilih',
            'status.in' => 'Status penduduk tidak valid',
        ]);
        
        $resident->update($validated);
        
        // Auto-manage family data berdasarkan No. KK
        if ($validated['family_card_number']) {
            $this->manageFamily($resident->fresh());
        }
        
        return redirect()->route('residents.index')->with('success', 'Data penduduk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $familyCardNumber = $resident->family_card_number;
        
        $resident->delete();
        
        // Update total members di family jika ada No. KK
        if ($familyCardNumber) {
            $family = \App\Models\Family::where('kk', $familyCardNumber)->first();
            if ($family) {
                $totalMembers = Resident::where('family_card_number', $familyCardNumber)->count();
                if ($totalMembers > 0) {
                    $family->update(['total_members' => $totalMembers]);
                } else {
                    // Jika tidak ada anggota lagi, hapus data keluarga
                    $family->delete();
                }
            }
        }
        
        return redirect()->route('residents.index')->with('success', 'Data penduduk berhasil dihapus');
    }
    
    private function manageFamily($resident)
    {
        // Cek apakah keluarga dengan No. KK ini sudah ada
        $family = \App\Models\Family::where('kk', $resident->family_card_number)->first();
        
        if (!$family) {
            // Jika belum ada, buat data keluarga baru
            // Cari kepala keluarga: laki-laki paling tua, jika tidak ada ambil yang paling tua
            $headResident = null;
            
            // Try to find oldest male first (handle different gender formats: M, Male, male)
            $residents = Resident::where('family_card_number', $resident->family_card_number)
                ->orderBy('birth_date', 'asc')
                ->get();
            foreach ($residents as $res) {
                $gender = strtoupper(trim($res->gender));
                if ($gender === 'M' || $gender === 'MALE') {
                    $headResident = $res;
                    break; // Found oldest male (already sorted)
                }
            }
            
            // If no male found, use oldest person
            if (!$headResident) {
                $headResident = $residents->first();
            }
            
            // Hitung total anggota keluarga
            $totalMembers = Resident::where('family_card_number', $resident->family_card_number)->count();
            
            \App\Models\Family::create([
                'kk' => $resident->family_card_number,
                'head_name' => $headResident->name,
                'head_nik' => $headResident->nik,
                'hamlet' => $resident->hamlet,
                'total_members' => $totalMembers,
            ]);
        } else {
            // Jika sudah ada, update jumlah anggota dan head jika diperlukan
            $totalMembers = Resident::where('family_card_number', $resident->family_card_number)->count();
            
            // Update head of family jika berubah
            $residents = Resident::where('family_card_number', $resident->family_card_number)
                ->orderBy('birth_date', 'asc')
                ->get();
            
            $headResident = null;
            foreach ($residents as $res) {
                $gender = strtoupper(trim($res->gender));
                if ($gender === 'M' || $gender === 'MALE') {
                    $headResident = $res;
                    break; // Found oldest male
                }
            }
            
            if (!$headResident) {
                $headResident = $residents->first();
            }
            
            $family->update([
                'total_members' => $totalMembers,
                'head_name' => $headResident->name,
                'head_nik' => $headResident->nik,
            ]);
        }
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
