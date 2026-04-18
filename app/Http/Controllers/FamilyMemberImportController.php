<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Exception;

class FamilyMemberImportController extends Controller
{
    /**
     * Show import form
     */
    public function showForm()
    {
        return view('admin.family-members.import');
    }

    /**
     * Handle CSV upload and import
     */
    public function import(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt|max:10240',
            ], [
                'csv_file.required' => 'File CSV wajib diunggah',
                'csv_file.mimes' => 'File harus berformat CSV',
                'csv_file.max' => 'Ukuran file maksimal 10MB',
            ]);

            $file = $request->file('csv_file');
            $path = $file->getRealPath();

            $successCount = 0;
            $errorCount = 0;
            $errors = [];
            $rowNumber = 0;

            if (($handle = fopen($path, 'r')) !== false) {
                // Skip header
                fgetcsv($handle);
                
                while (($row = fgetcsv($handle)) !== false) {
                    $rowNumber++;

                    try {
                        // Map CSV columns to fields
                        $data = [
                            'family_card_number' => trim($row[0] ?? ''),
                            'nik' => trim($row[1] ?? ''),
                            'name' => trim($row[2] ?? ''),
                            'gender' => trim($row[3] ?? ''),
                            'birth_place' => trim($row[4] ?? ''),
                            'birth_date' => $this->parseDate(trim($row[5] ?? '')),
                            'address' => trim($row[6] ?? ''),
                            'hamlet' => trim($row[7] ?? ''),
                            'rt' => (int)($row[8] ?? 0),
                            'rw' => (int)($row[9] ?? 0),
                            'religion' => trim($row[10] ?? ''),
                            'marital_status' => trim($row[11] ?? ''),
                            'occupation' => trim($row[12] ?? ''),
                            'phone' => trim($row[13] ?? ''),
                            'status' => trim($row[14] ?? 'active'),
                        ];

                        // Validate required fields
                        if (empty($data['family_card_number']) || empty($data['nik']) || empty($data['name'])) {
                            throw new Exception('Nomor KK, NIK, dan Nama tidak boleh kosong');
                        }

                        // Check if family exists, if not create it
                        $family = Family::firstOrCreate(
                            ['kk' => $data['family_card_number']],
                            [
                                'head_name' => $data['name'],
                                'head_nik' => $data['nik'],
                                'hamlet' => $data['hamlet'],
                                'rt' => $data['rt'],
                                'rw' => $data['rw'],
                            ]
                        );

                        // Insert or update family member
                        FamilyMember::updateOrCreate(
                            ['nik' => $data['nik']],
                            $data
                        );

                        $successCount++;
                    } catch (Exception $e) {
                        $errorCount++;
                        $errors[] = "Baris {$rowNumber}: " . $e->getMessage();
                    }
                }

                fclose($handle);
            }

            return response()->json([
                'success' => true,
                'message' => "Import selesai! {$successCount} data berhasil diimpor.",
                'successCount' => $successCount,
                'errorCount' => $errorCount,
                'errors' => array_slice($errors, 0, 10), // Show first 10 errors
                'totalErrors' => count($errors),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Parse date from various formats
     */
    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        try {
            // Try to parse the date
            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $dateString);
            return $date->format('Y-m-d');
        } catch (Exception $e) {
            try {
                $date = \Carbon\Carbon::parse($dateString);
                return $date->format('Y-m-d');
            } catch (Exception $ex) {
                return null;
            }
        }
    }

    /**
     * Get import status
     */
    public function status()
    {
        $totalMembers = FamilyMember::count();
        $totalFamilies = Family::count();
        $activeMembers = FamilyMember::where('status', 'active')->count();

        return response()->json([
            'totalMembers' => $totalMembers,
            'totalFamilies' => $totalFamilies,
            'activeMembers' => $activeMembers,
        ]);
    }
}
