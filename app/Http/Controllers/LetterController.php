<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\Resident;
use Illuminate\Support\Facades\Auth;

class LetterController extends Controller
{
    /**
     * Display template selection
     */
    public function index()
    {
        $templates = [
            [
                'type' => 'domisili',
                'name' => 'Surat Keterangan Domisili',
                'icon' => 'fa-home',
                'description' => 'Surat keterangan tempat tinggal/domisili'
            ],
            [
                'type' => 'usaha',
                'name' => 'Surat Keterangan Usaha',
                'icon' => 'fa-store',
                'description' => 'Surat keterangan menjalankan usaha'
            ],
            [
                'type' => 'skck',
                'name' => 'Surat Pengantar SKCK',
                'icon' => 'fa-shield-alt',
                'description' => 'Surat pengantar untuk membuat SKCK'
            ],
            [
                'type' => 'tidak_mampu',
                'name' => 'Surat Keterangan Tidak Mampu',
                'icon' => 'fa-hand-holding-heart',
                'description' => 'Surat keterangan tidak mampu secara ekonomi'
            ],
            [
                'type' => 'nikah',
                'name' => 'Surat Pengantar Nikah',
                'icon' => 'fa-ring',
                'description' => 'Surat pengantar untuk menikah'
            ],
            [
                'type' => 'kematian',
                'name' => 'Surat Keterangan Kematian',
                'icon' => 'fa-cross',
                'description' => 'Surat keterangan kematian'
            ],
            [
                'type' => 'kelahiran',
                'name' => 'Surat Keterangan Kelahiran',
                'icon' => 'fa-baby',
                'description' => 'Surat keterangan kelahiran'
            ],
            [
                'type' => 'pindah',
                'name' => 'Surat Keterangan Pindah',
                'icon' => 'fa-truck-moving',
                'description' => 'Surat keterangan pindah domisili'
            ],
        ];

        return view('pages.letters.index', compact('templates'));
    }

    /**
     * Show form to create letter
     */
    public function create(Request $request)
    {
        $type = $request->query('type');
        
        if (!$type) {
            return redirect()->route('letters.index');
        }

        // Get all residents for selection with necessary fields
        $residents = Resident::select('id', 'nik', 'name', 'birth_place', 'birth_date', 'gender', 'religion', 'occupation', 'marital_status', 'address', 'hamlet')
            ->orderBy('name')
            ->get()
            ->map(function($resident) {
                return [
                    'id' => $resident->id,
                    'nik' => $resident->nik,
                    'name' => $resident->name,
                    'birth_place' => $resident->birth_place,
                    'birth_date' => $resident->birth_date ? $resident->birth_date->format('Y-m-d') : '',
                    'gender' => $resident->gender,
                    'religion' => $resident->religion,
                    'occupation' => $resident->occupation,
                    'marital_status' => $resident->marital_status,
                    'address' => $resident->address,
                    'hamlet' => $resident->hamlet,
                ];
            });

        return view('pages.letters.create', compact('type', 'residents'));
    }

    /**
     * Get resident data for auto-fill
     */
    public function getResidentData($id)
    {
        $resident = Resident::findOrFail($id);
        return response()->json($resident);
    }

    /**
     * Store letter
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_type' => 'required|string',
            'resident_id' => 'required|exists:residents,id',
            'purpose' => 'required|string',
            'additional_data' => 'nullable|array',
            'letter_date' => 'required|date',
            'village_head_name' => 'nullable|string',
        ]);

        $validated['letter_number'] = Letter::generateLetterNumber($request->letter_type);
        $validated['created_by'] = Auth::id();
        $validated['status'] = 'completed';
        
        // Set default village head name if not provided
        if (empty($validated['village_head_name'])) {
            $validated['village_head_name'] = 'Wibowo, S.H.';
        }

        $letter = Letter::create($validated);

        return redirect()->route('letters.show', $letter->id)
            ->with('success', 'Surat berhasil dibuat!');
    }

    /**
     * Update letter
     */
    public function update(Request $request, $id)
    {
        $letter = Letter::findOrFail($id);
        
        $validated = $request->validate([
            'letter_number' => 'nullable|string',
            'purpose' => 'required|string',
            'additional_data' => 'nullable|array',
            'letter_date' => 'required|date',
            'village_head_name' => 'nullable|string',
            'resident_data' => 'nullable|array',
        ]);
        
        // Update resident data if provided (from inline edit)
        if (isset($validated['resident_data'])) {
            $resident = $letter->resident;
            
            if (isset($validated['resident_data']['name'])) {
                $resident->name = $validated['resident_data']['name'];
            }
            if (isset($validated['resident_data']['nik'])) {
                $resident->nik = $validated['resident_data']['nik'];
            }
            if (isset($validated['resident_data']['birth_place'])) {
                $resident->birth_place = $validated['resident_data']['birth_place'];
            }
            if (isset($validated['resident_data']['birth_date'])) {
                $resident->birth_date = $validated['resident_data']['birth_date'];
            }
            if (isset($validated['resident_data']['gender'])) {
                $resident->gender = $validated['resident_data']['gender'];
            }
            if (isset($validated['resident_data']['religion'])) {
                $resident->religion = $validated['resident_data']['religion'];
            }
            if (isset($validated['resident_data']['occupation'])) {
                $resident->occupation = $validated['resident_data']['occupation'];
            }
            if (isset($validated['resident_data']['marital_status'])) {
                $resident->marital_status = $validated['resident_data']['marital_status'];
            }
            if (isset($validated['resident_data']['address'])) {
                $resident->address = $validated['resident_data']['address'];
            }
            
            $resident->save();
            unset($validated['resident_data']);
        }
        
        // Set default village head name if not provided
        if (empty($validated['village_head_name'])) {
            $validated['village_head_name'] = 'Wibowo, S.H.';
        }

        $letter->update($validated);

        // Return JSON for AJAX request
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Surat berhasil diperbarui!']);
        }

        return redirect()->route('letters.show', $letter->id)
            ->with('success', 'Surat berhasil diperbarui!');
    }

    /**
     * Display letter for preview/print
     */
    public function show($id)
    {
        $letter = Letter::with('resident', 'creator')->findOrFail($id);
        
        return view('pages.letters.show', compact('letter'));
    }

    /**     * Show edit form
     */
    public function edit($id)
    {
        $letter = Letter::with('resident')->findOrFail($id);
        
        return view('pages.letters.edit', compact('letter'));
    }

    /**     * List all created letters
     */
    public function list()
    {
        $letters = Letter::with('resident', 'creator')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('pages.letters.list', compact('letters'));
    }
}
