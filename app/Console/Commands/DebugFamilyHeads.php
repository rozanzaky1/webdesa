<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Resident;
use App\Models\Family;

class DebugFamilyHeads extends Command
{
    protected $signature = 'debug:family-heads';
    protected $description = 'Debug family heads - check residents and gender values';

    public function handle()
    {
        $families = Family::all();
        
        foreach ($families as $family) {
            $residents = Resident::where('family_card_number', $family->kk)
                ->orderBy('birth_date', 'asc')
                ->get();
            
            $this->line("\n=== KK: {$family->kk} ===");
            $this->line("Current Head: {$family->head_name} (NIK: {$family->head_nik})");
            $this->line("Total Members: {$family->total_members}\n");
            
            foreach ($residents as $resident) {
                $this->line("- {$resident->name} | Gender: '{$resident->gender}' | Birth: {$resident->birth_date}");
            }
        }
    }
}
