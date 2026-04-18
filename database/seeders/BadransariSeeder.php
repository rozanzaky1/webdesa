<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Resident;
use App\Models\Family;
use App\Models\Hamlet;

class BadransariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(database_path('seeders/Badransari_Export.csv'), 'r');

        $header = fgetcsv($csvFile); // Skip header row

        // Disable foreign key checks to avoid issues with table truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables to start fresh
        Resident::truncate();
        Family::truncate();
        Hamlet::truncate();

        $families = [];
        $hamlets = [];

        while (($row = fgetcsv($csvFile)) !== false) {
            $data = array_combine($header, $row);

            // --- 1. Prepare Hamlets (Dusun) ---
            if (!empty($data['hamlet']) && !isset($hamlets[$data['hamlet']])) {
                $hamlets[$data['hamlet']] = [
                    'name' => $data['hamlet'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // --- 2. Prepare Families (Keluarga) ---
            if (!empty($data['family_card_number']) && !isset($families[$data['family_card_number']])) {
                $families[$data['family_card_number']] = [
                    'kk' => $data['family_card_number'],
                    'head_name' => null, // Will be updated later if possible
                    'head_nik' => null, // Will be updated later if possible
                    'hamlet' => $data['hamlet'],
                    'total_members' => 0, // Will be calculated later
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

             // --- 3. Insert Resident ---
             Resident::create([
                'nik' => $data['nik'],
                'family_card_number' => $data['family_card_number'],
                'name' => $data['name'],
                'gender' => $data['gender'],
                'birth_place' => $data['birth_place'],
                'birth_date' => $data['birth_date'],
                'address' => $data['address'],
                'hamlet' => $data['hamlet'],
                'religion' => $data['religion'],
                'marital_status' => $data['marital_status'],
                'occupation' => $data['occupation'],
                'phone' => $data['phone'],
                'status' => $data['status'],
            ]);
        }

        fclose($csvFile);

        // --- Bulk Insert Hamlets and Families ---
        if (!empty($hamlets)) {
            Hamlet::insert(array_values($hamlets));
        }
        if (!empty($families)) {
            Family::insert(array_values($families));
        }

        // --- 4. Post-processing: Calculate total members for each family ---
        $this->command->info('Calculating total members for each family...');
        $familyMemberCounts = Resident::select('family_card_number', DB::raw('count(*) as total'))
            ->whereNotNull('family_card_number')
            ->groupBy('family_card_number')
            ->get();

        foreach ($familyMemberCounts as $count) {
            Family::where('kk', $count->family_card_number)->update(['total_members' => $count->total]);
        }

        // --- 5. Update head of family: oldest male, or oldest person if no male ---
        $this->command->info('Updating head of families...');
        $families = Family::all();
        foreach ($families as $family) {
            // Get all residents for this family, sorted by birth_date (oldest first)
            $residents = Resident::where('family_card_number', $family->kk)
                ->orderBy('birth_date', 'asc')
                ->get();

            // Find oldest male, or oldest person
            $headResident = null;
            
            // Try to find oldest male first (handle different gender formats: M, Male, male)
            foreach ($residents as $resident) {
                $gender = strtoupper(trim($resident->gender));
                if ($gender === 'M' || $gender === 'MALE') {
                    $headResident = $resident;
                    break; // Found oldest male (already sorted by birth_date asc)
                }
            }
            
            // If no male found, use oldest person
            if (!$headResident) {
                $headResident = $residents->first();
            }

            if ($headResident) {
                $family->update([
                    'head_name' => $headResident->name,
                    'head_nik' => $headResident->nik,
                ]);
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Badransari data has been seeded successfully!');
    }
}
