<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Resident;
use App\Models\Family;

class SyncFamiliesCommand extends Command
{
    protected $signature = 'families:sync';
    protected $description = 'Sync families data from existing residents';

    public function handle()
    {
        $this->info('Starting to sync families data...');
        
        // Ambil semua No. KK yang unik dari residents
        $familyCardNumbers = Resident::whereNotNull('family_card_number')
            ->where('family_card_number', '!=', '')
            ->distinct()
            ->pluck('family_card_number');
        
        $created = 0;
        $updated = 0;
        
        foreach ($familyCardNumbers as $kkNumber) {
            // Cek apakah keluarga sudah ada
            $family = Family::where('kk', $kkNumber)->first();
            
            // Cari kepala keluarga (prioritas: laki-laki menikah)
            $headResident = Resident::where('family_card_number', $kkNumber)
                ->where('gender', 'Male')
                ->where('marital_status', 'Married')
                ->first();
            
            // Jika tidak ada laki-laki menikah, ambil yang pertama
            if (!$headResident) {
                $headResident = Resident::where('family_card_number', $kkNumber)->first();
            }
            
            // Hitung total anggota
            $totalMembers = Resident::where('family_card_number', $kkNumber)->count();
            
            if (!$family) {
                // Buat data keluarga baru
                Family::create([
                    'kk' => $kkNumber,
                    'head_name' => $headResident->name,
                    'head_nik' => $headResident->nik,
                    'hamlet' => $headResident->hamlet,
                    'address' => $headResident->address,
                    'total_members' => $totalMembers,
                ]);
                $created++;
                $this->info("Created family with KK: {$kkNumber} (Members: {$totalMembers})");
            } else {
                // Update data keluarga
                $family->update([
                    'head_name' => $headResident->name,
                    'head_nik' => $headResident->nik,
                    'hamlet' => $headResident->hamlet,
                    'address' => $headResident->address,
                    'total_members' => $totalMembers,
                ]);
                $updated++;
                $this->info("Updated family with KK: {$kkNumber} (Members: {$totalMembers})");
            }
        }
        
        $this->info("\nSync completed!");
        $this->info("Created: {$created} families");
        $this->info("Updated: {$updated} families");
        
        return 0;
    }
}
