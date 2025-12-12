<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        // Data dummy wilayah desa
        $regions = [
            ['id' => 1, 'name' => 'RT 01 RW 01', 'total_residents' => 45, 'total_families' => 12],
            ['id' => 2, 'name' => 'RT 02 RW 01', 'total_residents' => 38, 'total_families' => 10],
            ['id' => 3, 'name' => 'RT 03 RW 01', 'total_residents' => 52, 'total_families' => 14],
            ['id' => 4, 'name' => 'RT 01 RW 02', 'total_residents' => 41, 'total_families' => 11],
            ['id' => 5, 'name' => 'RT 02 RW 02', 'total_residents' => 49, 'total_families' => 13],
            ['id' => 6, 'name' => 'RT 03 RW 02', 'total_residents' => 36, 'total_families' => 9],
            ['id' => 7, 'name' => 'RT 01 RW 03', 'total_residents' => 44, 'total_families' => 12],
            ['id' => 8, 'name' => 'RT 02 RW 03', 'total_residents' => 55, 'total_families' => 15],
            ['id' => 9, 'name' => 'RT 03 RW 03', 'total_residents' => 47, 'total_families' => 13],
            ['id' => 10, 'name' => 'RT 04 RW 03', 'total_residents' => 39, 'total_families' => 10],
        ];

        $totalRegions = count($regions);
        $totalResidents = array_sum(array_column($regions, 'total_residents'));
        $totalFamilies = array_sum(array_column($regions, 'total_families'));
        $averageResidentsPerRegion = round($totalResidents / $totalRegions, 1);

        return view('pages.regions.index', compact(
            'regions',
            'totalRegions',
            'totalResidents',
            'totalFamilies',
            'averageResidentsPerRegion'
        ));
    }
}
