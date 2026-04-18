<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;

class FamilyMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to CSV file
        $csvFile = database_path('seeders/family_members.csv');
        
        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found at: {$csvFile}");
            return;
        }

        try {
            $file = fopen($csvFile, 'r');
            $header = fgetcsv($file); // Skip header row
            $count = 0;
            $errors = [];

            while (($row = fgetcsv($file)) !== false) {
                try {
                    // Map CSV columns to array
                    $data = [
                        'family_card_number' => $row[0] ?? null,
                        'nik' => $row[1] ?? null,
                        'name' => $row[2] ?? null,
                        'gender' => $row[3] ?? null,
                        'birth_place' => $row[4] ?? null,
                        'birth_date' => !empty($row[5]) ? date('Y-m-d', strtotime($row[5])) : null,
                        'address' => $row[6] ?? null,
                        'hamlet' => $row[7] ?? null,
                        'rt' => $row[8] ?? null,
                        'rw' => $row[9] ?? null,
                        'religion' => $row[10] ?? null,
                        'marital_status' => $row[11] ?? null,
                        'occupation' => $row[12] ?? null,
                        'phone' => $row[13] ?? null,
                        'status' => $row[14] ?? 'active',
                    ];

                    // Validate required fields
                    if (empty($data['family_card_number']) || empty($data['nik'])) {
                        $errors[] = "Row " . ($count + 2) . ": Missing family_card_number or nik";
                        continue;
                    }

                    // Check if family exists, if not create it
                    if (!Family::where('kk', $data['family_card_number'])->exists()) {
                        Family::create([
                            'kk' => $data['family_card_number'],
                            'head_name' => $data['name'] ?? 'Unknown',
                            'head_nik' => $data['nik'] ?? null,
                            'hamlet' => $data['hamlet'] ?? null,
                            'rt' => $data['rt'] ?? null,
                            'rw' => $data['rw'] ?? null,
                            'address' => $data['address'] ?? null,
                        ]);
                    }

                    // Create or update family member
                    FamilyMember::updateOrCreate(
                        ['nik' => $data['nik']],
                        $data
                    );

                    $count++;
                } catch (Exception $e) {
                    $errors[] = "Row " . ($count + 2) . ": " . $e->getMessage();
                }
            }

            fclose($file);

            $this->command->info("✅ Successfully imported {$count} family members!");
            
            if (!empty($errors)) {
                $this->command->warn("\n⚠️  Errors encountered:");
                foreach ($errors as $error) {
                    $this->command->line($error);
                }
            }

        } catch (Exception $e) {
            $this->command->error("Error reading CSV file: " . $e->getMessage());
        }
    }
}
