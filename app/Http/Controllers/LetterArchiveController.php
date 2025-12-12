<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LetterArchiveController extends Controller
{
    private $archivePath = 'letter_archives.json';

    public function index(Request $request)
    {
        $archives = $this->getArchives();
        
        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $archives = array_filter($archives, function($item) use ($request) {
                return $item['letter_type'] === $request->type;
            });
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from !== '') {
            $archives = array_filter($archives, function($item) use ($request) {
                return date('Y-m-d', strtotime($item['created_at'])) >= $request->date_from;
            });
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $archives = array_filter($archives, function($item) use ($request) {
                return date('Y-m-d', strtotime($item['created_at'])) <= $request->date_to;
            });
        }

        // Sort by date descending
        usort($archives, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        $letterTypes = $this->getLetterTypes();

        return view('pages.services.letter-archive.index', compact('archives', 'letterTypes'));
    }

    public function create()
    {
        $letterTypes = $this->getLetterTypes();
        return view('pages.services.letter-archive.create', compact('letterTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_number' => 'required|string|max:255',
            'letter_type' => 'required|string',
            'recipient_name' => 'required|string|max:255',
            'recipient_nik' => 'nullable|string|max:20',
            'purpose' => 'nullable|string',
            'notes' => 'nullable|string',
            'letter_date' => 'required|date',
        ]);

        $archives = $this->getArchives();

        $newArchive = [
            'id' => uniqid(),
            'letter_number' => $request->letter_number,
            'letter_type' => $request->letter_type,
            'recipient_name' => $request->recipient_name,
            'recipient_nik' => $request->recipient_nik,
            'purpose' => $request->purpose,
            'notes' => $request->notes,
            'letter_date' => $request->letter_date,
            'created_at' => now()->toDateTimeString(),
        ];

        $archives[] = $newArchive;
        Storage::disk('local')->put($this->archivePath, json_encode($archives, JSON_PRETTY_PRINT));

        return redirect()->route('letter-archive.index')->with('success', 'Arsip surat berhasil ditambahkan!');
    }

    public function show($id)
    {
        $archives = $this->getArchives();
        $archive = collect($archives)->firstWhere('id', $id);

        if (!$archive) {
            return redirect()->route('letter-archive.index')->with('error', 'Arsip tidak ditemukan!');
        }

        return view('pages.services.letter-archive.show', compact('archive'));
    }

    public function destroy($id)
    {
        $archives = $this->getArchives();
        $index = collect($archives)->search(function ($item) use ($id) {
            return $item['id'] === $id;
        });

        if ($index === false) {
            return redirect()->route('letter-archive.index')->with('error', 'Arsip tidak ditemukan!');
        }

        unset($archives[$index]);
        Storage::disk('local')->put($this->archivePath, json_encode(array_values($archives), JSON_PRETTY_PRINT));

        return redirect()->route('letter-archive.index')->with('success', 'Arsip surat berhasil dihapus!');
    }

    private function getArchives()
    {
        if (Storage::disk('local')->exists($this->archivePath)) {
            return json_decode(Storage::disk('local')->get($this->archivePath), true);
        }
        return [];
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
