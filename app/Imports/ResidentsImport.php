<?php

namespace App\Imports;

use App\Models\Resident;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResidentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['nik'])) {
            return null;
        }

        // Map Excel columns to model
        return new Resident([
            'nik' => $row['nik'] ?? null,
            'family_card_number' => $row['no_kk'] ?? $row['family_card_number'] ?? null,
            'name' => $row['nama'] ?? $row['name'] ?? null,
            'gender' => $row['jenis_kelamin'] ?? $row['gender'] ?? null,
            'birth_date' => $this->parseDate($row['tanggal_lahir'] ?? $row['birth_date'] ?? null),
            'birth_place' => $row['tempat_lahir'] ?? $row['birth_place'] ?? null,
            'address' => $row['alamat'] ?? $row['address'] ?? null,
            'hamlet' => $row['dusun'] ?? $row['hamlet'] ?? null,
            'religion' => $row['agama'] ?? $row['religion'] ?? null,
            'marital_status' => $row['status_perkawinan'] ?? $row['marital_status'] ?? null,
            'occupation' => $row['pekerjaan'] ?? $row['occupation'] ?? null,
            'phone' => $row['telepon'] ?? $row['phone'] ?? null,
            'status' => 'active',
        ]);
    }

    private function parseDate($date)
    {
        if (!$date) {
            return null;
        }

        if (is_numeric($date)) {
            // Excel date format (days since 1900)
            return \PhpOffice\PHPExcel\Shared\Date::ExcelToPHPObject($date);
        }

        // Try to parse string date
        try {
            return \Carbon\Carbon::createFromFormat('d/m/Y', $date);
        } catch (\Exception $e) {
            try {
                return \Carbon\Carbon::createFromFormat('Y-m-d', $date);
            } catch (\Exception $e) {
                return null;
            }
        }
    }
}
