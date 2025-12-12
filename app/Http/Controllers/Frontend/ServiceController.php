<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = $this->getServiceList();
        return view('frontend.services.index', compact('services'));
    }
    
    public function create()
    {
        $letterTypes = $this->getLetterTypes();
        return view('frontend.services.form', compact('letterTypes'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'letter_type' => 'required|string',
            'purpose' => 'required|string|min:10',
            'notes' => 'nullable|string',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.numeric' => 'NIK harus berupa angka',
            'nik.digits' => 'NIK harus 16 digit',
            'letter_type.required' => 'Jenis surat wajib dipilih',
            'purpose.required' => 'Keperluan wajib diisi',
            'purpose.min' => 'Keperluan minimal 10 karakter',
        ]);
        
        $user = auth()->user();
        $submissions = $this->getAllSubmissions();
        
        $submission = [
            'id' => uniqid('sub_'),
            'user_id' => $user->id,
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'user_email' => $user->email,
            'letter_type' => $validated['letter_type'],
            'purpose' => $validated['purpose'],
            'notes' => $validated['notes'] ?? '',
            'status' => 'pending',
            'letter_number' => null,
            'admin_notes' => null,
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ];
        
        $submissions[] = $submission;
        
        Storage::disk('local')->put('online_submissions.json', json_encode($submissions, JSON_PRETTY_PRINT));
        
        return redirect()->route('frontend.services.history')->with('success', 'Pengajuan surat berhasil dikirim! Silakan tunggu proses persetujuan dari admin.');
    }
    
    public function history()
    {
        $user = auth()->user();
        $submissions = $this->getUserSubmissions($user->id);
        
        return view('frontend.services.history', compact('submissions'));
    }
    
    public function show($id)
    {
        $submissions = $this->getAllSubmissions();
        $submission = collect($submissions)->firstWhere('id', $id);
        
        if (!$submission || !isset($submission['user_id']) || $submission['user_id'] != auth()->id()) {
            abort(404, 'Pengajuan tidak ditemukan');
        }
        
        return view('frontend.services.show', compact('submission'));
    }
    
    private function getAllSubmissions()
    {
        if (!Storage::disk('local')->exists('online_submissions.json')) {
            return [];
        }
        
        return json_decode(Storage::disk('local')->get('online_submissions.json'), true) ?? [];
    }
    
    private function getUserSubmissions($userId)
    {
        $submissions = $this->getAllSubmissions();
        
        $userSubmissions = array_filter($submissions, function($submission) use ($userId) {
            return isset($submission['user_id']) && $submission['user_id'] == $userId;
        });
        
        // Sort by created_at descending
        usort($userSubmissions, function($a, $b) {
            $timeA = isset($a['created_at']) ? strtotime($a['created_at']) : 0;
            $timeB = isset($b['created_at']) ? strtotime($b['created_at']) : 0;
            return $timeB - $timeA;
        });
        
        return array_values($userSubmissions);
    }
    
    private function getServiceList()
    {
        return [
            [
                'name' => 'Surat Keterangan Domisili',
                'icon' => 'fa-home',
                'description' => 'Surat keterangan tempat tinggal',
            ],
            [
                'name' => 'Surat Keterangan Usaha',
                'icon' => 'fa-briefcase',
                'description' => 'Surat keterangan memiliki usaha',
            ],
            [
                'name' => 'Surat Keterangan Tidak Mampu',
                'icon' => 'fa-hands-helping',
                'description' => 'Surat keterangan ekonomi kurang mampu',
            ],
            [
                'name' => 'Surat Pengantar KTP',
                'icon' => 'fa-id-card',
                'description' => 'Surat pengantar pembuatan KTP',
            ],
            [
                'name' => 'Surat Pengantar KK',
                'icon' => 'fa-users',
                'description' => 'Surat pengantar pembuatan Kartu Keluarga',
            ],
            [
                'name' => 'Surat Keterangan Kelahiran',
                'icon' => 'fa-baby',
                'description' => 'Surat keterangan kelahiran bayi',
            ],
        ];
    }
    
    private function getLetterTypes()
    {
        return [
            'Surat Keterangan Domisili',
            'Surat Keterangan Usaha',
            'Surat Keterangan Tidak Mampu',
            'Surat Keterangan Kelahiran',
            'Surat Keterangan Kematian',
            'Surat Pengantar KTP',
            'Surat Pengantar KK',
            'Surat Keterangan Pindah',
            'Surat Keterangan Belum Menikah',
            'Surat Keterangan Penghasilan',
        ];
    }
}
