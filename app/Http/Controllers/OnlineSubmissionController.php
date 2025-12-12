<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OnlineSubmissionController extends Controller
{
    private $submissionsPath = 'online_submissions.json';

    public function index(Request $request)
    {
        $submissions = $this->getSubmissions();
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $submissions = array_filter($submissions, function($item) use ($request) {
                return $item['status'] === $request->status;
            });
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

        Storage::disk('local')->put($this->submissionsPath, json_encode(array_values($submissions), JSON_PRETTY_PRINT));

        return redirect()->route('online-submission.show', $id)->with('success', 'Status permohonan berhasil diperbarui!');
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
}
