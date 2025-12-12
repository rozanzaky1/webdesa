<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserSubmissionController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Get user's submissions
        $submissions = $this->getUserSubmissions($user->id);
        
        // Count by status
        $stats = [
            'total' => count($submissions),
            'pending' => count(array_filter($submissions, fn($s) => $s['status'] === 'pending')),
            'approved' => count(array_filter($submissions, fn($s) => $s['status'] === 'approved')),
            'rejected' => count(array_filter($submissions, fn($s) => $s['status'] === 'rejected')),
        ];
        
        return view('user.dashboard', compact('submissions', 'stats'));
    }
    
    public function create()
    {
        $letterTypes = $this->getLetterTypes();
        return view('user.submission-create', compact('letterTypes'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_type' => 'required|string',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        $user = auth()->user();
        $submissions = $this->getAllSubmissions();
        
        $submission = [
            'id' => uniqid('sub_'),
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_nik' => $user->nik,
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
        
        return redirect()->route('user.dashboard')->with('success', 'Pengajuan surat berhasil dikirim. Mohon tunggu persetujuan admin.');
    }
    
    public function show($id)
    {
        $submissions = $this->getAllSubmissions();
        $submission = collect($submissions)->firstWhere('id', $id);
        
        if (!$submission || !isset($submission['user_id']) || $submission['user_id'] != auth()->id()) {
            return redirect()->route('user.dashboard')->with('error', 'Pengajuan tidak ditemukan');
        }
        
        return view('user.submission-detail', compact('submission'));
    }
    
    public function print($id)
    {
        $submissions = $this->getAllSubmissions();
        $submission = collect($submissions)->firstWhere('id', $id);
        
        if (!$submission || !isset($submission['user_id']) || $submission['user_id'] != auth()->id()) {
            return redirect()->route('user.dashboard')->with('error', 'Pengajuan tidak ditemukan');
        }
        
        if (!isset($submission['status']) || !in_array($submission['status'], ['approved', 'completed'])) {
            return redirect()->route('user.dashboard')->with('error', 'Hanya surat yang sudah disetujui yang dapat dicetak');
        }
        
        return view('user.submission-print', compact('submission'));
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
        return array_filter($submissions, function($submission) use ($userId) {
            return isset($submission['user_id']) && $submission['user_id'] == $userId;
        });
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
            'Lainnya',
        ];
    }
}
