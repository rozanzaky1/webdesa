<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Family;
use App\Models\Resident;
use Illuminate\Support\Facades\DB;

class SyncFamiliesFromResidents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'families:sync-from-residents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync families table from residents: create missing families and update member counts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to sync families from residents...');

        // Get all unique family_card_numbers from residents
        $uniqueFamilies = Resident::whereNotNull('family_card_number')
            ->distinct('family_card_number')
            ->pluck('family_card_number');

        $this->info("Found {$uniqueFamilies->count()} unique families in residents table");

        $created = 0;
        $updated = 0;

        foreach ($uniqueFamilies as $familyCardNumber) {
            // Get all residents for this family
            $residents = Resident::where('family_card_number', $familyCardNumber)->get();
            $totalMembers = $residents->count();

            // Try to find head of family (prefer Male/Married, else first resident)
            $headResident = $residents
                ->where('gender', 'Male')
                ->where('marital_status', 'Married')
                ->first() ?? $residents->first();

            $familyExists = Family::where('kk', $familyCardNumber)->exists();

            if (!$familyExists) {
                // Create new family
                try {
                    Family::create([
                        'kk' => $familyCardNumber,
                        'head_name' => $headResident->name ?? 'Unknown',
                        'head_nik' => $headResident->nik ?? null,
                        'hamlet' => $headResident->hamlet ?? null,
                        'total_members' => $totalMembers,
                    ]);
                    $this->line("✓ Created family KK {$familyCardNumber} with {$totalMembers} members");
                    $created++;
                } catch (\Exception $e) {
                    $this->error("✗ Error creating family KK {$familyCardNumber}: {$e->getMessage()}");
                }
            } else {
                // Update existing family
                try {
                    Family::where('kk', $familyCardNumber)->update([
                        'total_members' => $totalMembers,
                    ]);
                    $this->line("✓ Updated family KK {$familyCardNumber}: {$totalMembers} members");
                    $updated++;
                } catch (\Exception $e) {
                    $this->error("✗ Error updating family KK {$familyCardNumber}: {$e->getMessage()}");
                }
            }
        }

        $this->info("✓ Sync complete! Created: {$created}, Updated: {$updated}");
    }
}
