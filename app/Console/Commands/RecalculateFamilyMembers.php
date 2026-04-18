<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Family;
use App\Models\Resident;
use Illuminate\Support\Facades\DB;

class RecalculateFamilyMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'families:recalculate-members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate total members for all families based on residents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to recalculate family members...');

        // Get count of residents per family
        $familyMemberCounts = Resident::select('family_card_number', DB::raw('count(*) as total'))
            ->whereNotNull('family_card_number')
            ->groupBy('family_card_number')
            ->get();

        $updated = 0;
        foreach ($familyMemberCounts as $count) {
            try {
                $family = Family::where('kk', $count->family_card_number)->first();
                if ($family) {
                    $family->update(['total_members' => $count->total]);
                    $this->line("✓ Updated KK {$count->family_card_number}: {$count->total} members");
                    $updated++;
                }
            } catch (\Exception $e) {
                $this->error("✗ Error updating KK {$count->family_card_number}: {$e->getMessage()}");
            }
        }

        $this->info("Successfully updated {$updated} families!");
    }
}
