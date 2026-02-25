<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\WhatsAppService;
use App\Models\User;

class OnlineSubmissionController extends Controller
{
    private $submissionsPath = 'online_submissions.json';

    public function index(Request $request)
    {
        $submissions = $this->getSubmissions();
        
        // Filter by status (support multiple statuses separated by comma)
        if ($request->has('status') && $request->status !== '') {
            $statusParam = $request->status;
            
            // Check if multiple statuses (comma-separated)
            if (strpos($statusParam, ',') !== false) {
                $allowedStatuses = array_map('trim', explode(',', $statusParam));
                $submissions = array_filter($submissions, function($item) use ($allowedStatuses) {
                    return in_array($item['status'], $allowedStatuses);
                });
            } else {
                // Single status
                $submissions = array_filter($submissions, function($item) use ($request) {
                    return $item['status'] === $request->status;
                });
            }
        }

        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $submissions = array_filter($submissions, function($item) use ($request) {
                return $item['letter_type'] === $request->type;
            });
        }

        // Sort by date descending
        usort($submissions, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        $letterTypes = $this->getLetterTypes();

        return view('pages.services.online-submission.index', compact('submissions', 'letterTypes'));
    }

    public function show($id)
    {
        $submissions = $this->getSubmissions();
        $submission = collect($submissions)->firstWhere('id', $id);

        if (!$submission) {
            return redirect()->route('online-submission.index')->with('error', 'Permohonan tidak ditemukan!');
        }

        return view('pages.services.online-submission.show', compact('submission'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'admin_notes' => 'nullable|string',
        ]);

        $submissions = $this->getSubmissions();
        $index = collect($submissions)->search(function ($item) use ($id) {
            return $item['id'] === $id;
        });

        if ($index === false) {
            return redirect()->route('online-submission.index')->with('error', 'Permohonan tidak ditemukan!');
        }

        $submissions[$index]['status'] = $request->status;
        $submissions[$index]['admin_notes'] = $request->admin_notes;
        $submissions[$index]['updated_at'] = now()->toDateTimeString();

        // Set letter_number if approved
        if ($request->status === 'approved' && empty($submissions[$index]['letter_number'])) {
            $submissions[$index]['letter_number'] = $this->generateLetterNumber($submissions[$index]['letter_type']);
        }

        // Auto-archive when status is completed
        if ($request->status === 'completed' && !empty($submissions[$index]['letter_number'])) {
            $this->archiveLetter($submissions[$index]);
            
            // Kirim notifikasi WhatsApp ke user
            try {
                $user = User::find($submissions[$index]['user_id']);
                if ($user && $user->phone) {
                    $whatsapp = new WhatsAppService();
                    $letterType = $this->getLetterTypeName($submissions[$index]['letter_type']);
                    $whatsapp->sendLetterCompleted($user, $letterType, $submissions[$index]['letter_number']);
                }
            } catch (\Exception $e) {
                // Log error but don't stop the process
                \Log::error('Failed to send WhatsApp notification: ' . $e->getMessage());
            }
        }

        Storage::disk('local')->put($this->submissionsPath, json_encode(array_values($submissions), JSON_PRETTY_PRINT));

        $message = 'Status permohonan berhasil diperbarui!';
        if ($request->status === 'completed') {
            $message = 'Status permohonan berhasil diperbarui dan otomatis diarsipkan!';
        }

        return redirect()->route('online-submission.show', $id)->with('success', $message);
    }

    public function print($id)
    {
        $submissions = $this->getSubmissions();
        $submission = collect($submissions)->firstWhere('id', $id);

        if (!$submission) {
            return redirect()->route('online-submission.index')->with('error', 'Permohonan tidak ditemukan!');
        }

        if ($submission['status'] !== 'approved' && $submission['status'] !== 'completed') {
            return redirect()->route('online-submission.show', $id)->with('error', 'Hanya permohonan yang disetujui yang dapat dicetak!');
        }

        return view('pages.services.online-submission.print', compact('submission'));
    }

    public function updateLetter(Request $request, $id)
    {
        $submissions = $this->getSubmissions();
        $index = collect($submissions)->search(function ($item) use ($id) {
            return $item['id'] === $id;
        });

        if ($index === false) {
            return response()->json(['success' => false, 'message' => 'Permohonan tidak ditemukan!'], 404);
        }

        // Update letter data
        $submissions[$index]['letter_number'] = $request->input('letter_number');
        $submissions[$index]['letter_type'] = $request->input('letter_type');
        $submissions[$index]['name'] = $request->input('name');
        $submissions[$index]['applicant_name'] = $request->input('name'); // Keep compatibility
        $submissions[$index]['nik'] = $request->input('nik');
        $submissions[$index]['applicant_nik'] = $request->input('nik'); // Keep compatibility
        $submissions[$index]['birth_place'] = $request->input('birth_place');
        $submissions[$index]['birth_date'] = $request->input('birth_date');
        $submissions[$index]['gender'] = $request->input('gender');
        $submissions[$index]['occupation'] = $request->input('occupation');
        $submissions[$index]['address'] = $request->input('address');
        $submissions[$index]['purpose'] = $request->input('purpose');
        $submissions[$index]['updated_at'] = now()->toDateTimeString();

        Storage::disk('local')->put($this->submissionsPath, json_encode(array_values($submissions), JSON_PRETTY_PRINT));

        return response()->json(['success' => true, 'message' => 'Data surat berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        $submissions = $this->getSubmissions();
        $index = collect($submissions)->search(function ($item) use ($id) {
            return $item['id'] === $id;
        });

        if ($index === false) {
            return redirect()->route('online-submission.index')->with('error', 'Permohonan tidak ditemukan!');
        }

        unset($submissions[$index]);
        Storage::disk('local')->put($this->submissionsPath, json_encode(array_values($submissions), JSON_PRETTY_PRINT));

        return redirect()->route('online-submission.index')->with('success', 'Permohonan berhasil dihapus!');
    }

    private function getSubmissions()
    {
        if (Storage::disk('local')->exists($this->submissionsPath)) {
            return json_decode(Storage::disk('local')->get($this->submissionsPath), true);
        }
        
        // Sample data for demo
        return [
            [
                'id' => 'sub001',
                'letter_type' => 'Surat Keterangan Domisili',
                'applicant_name' => 'Ahmad Yani',
                'applicant_nik' => '3515012345678901',
                'applicant_phone' => '081234567890',
                'applicant_email' => 'ahmad@email.com',
                'purpose' => 'Keperluan pembuatan SIM',
                'status' => 'pending',
                'letter_number' => null,
                'admin_notes' => null,
                'created_at' => now()->subDays(2)->toDateTimeString(),
                'updated_at' => now()->subDays(2)->toDateTimeString(),
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

    private function generateLetterNumber($letterType)
    {
        $code = 'SKT';
        $number = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        $month = date('m');
        $year = date('Y');
        
        return "{$code}/{$number}/{$month}/{$year}";
    }

    private function archiveLetter($submission)
    {
        $archivePath = 'letter_archives.json';
        
        // Get existing archives
        $archives = [];
        if (Storage::disk('local')->exists($archivePath)) {
            $archives = json_decode(Storage::disk('local')->get($archivePath), true);
        }

        // Check if already archived
        $exists = collect($archives)->contains(function ($item) use ($submission) {
            return $item['letter_number'] === $submission['letter_number'];
        });

        if ($exists) {
            return; // Already archived, skip
        }

        // Create archive entry
        $newArchive = [
            'id' => uniqid(),
            'letter_number' => $submission['letter_number'],
            'letter_type' => $submission['letter_type'],
            'recipient_name' => $submission['applicant_name'] ?? $submission['name'] ?? 'N/A',
            'recipient_nik' => $submission['applicant_nik'] ?? $submission['nik'] ?? null,
            'purpose' => $submission['purpose'] ?? null,
            'notes' => 'Otomatis diarsipkan dari pengajuan online',
            'letter_date' => now()->toDateString(),
            'created_at' => now()->toDateTimeString(),
            'source' => 'online_submission',
            'submission_id' => $submission['id'],
        ];

        // Add to archives
        $archives[] = $newArchive;
        Storage::disk('local')->put($archivePath, json_encode($archives, JSON_PRETTY_PRINT));
    }

    /**
     * Get human readable letter type name
     */
    private function getLetterTypeName($letterType)
    {
        $types = [
            'skck' => 'Surat Keterangan Catatan Kepolisian (SKCK)',
            'domisili' => 'Surat Keterangan Domisili',
            'usaha' => 'Surat Keterangan Usaha',
            'tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'nikah' => 'Surat Pengantar Nikah',
            'kematian' => 'Surat Keterangan Kematian',
            'kelahiran' => 'Surat Keterangan Kelahiran',
            'pindah' => 'Surat Keterangan Pindah',
        ];

        return $types[$letterType] ?? ucwords(str_replace('_', ' ', $letterType));
    }
}
