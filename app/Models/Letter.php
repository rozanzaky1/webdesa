<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_number',
        'letter_type',
        'resident_id',
        'purpose',
        'additional_data',
        'letter_date',
        'village_head_name',
        'status',
        'created_by',
    ];

    protected $casts = [
        'additional_data' => 'array',
        'letter_date' => 'date',
    ];

    /**
     * Get the resident that owns the letter
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Get the user who created the letter
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Generate letter number
     */
    public static function generateLetterNumber($type)
    {
        $prefix = self::getLetterPrefix($type);
        $date = date('Y/m');
        $count = self::whereYear('created_at', date('Y'))
                     ->whereMonth('created_at', date('m'))
                     ->where('letter_type', $type)
                     ->count() + 1;
        
        return sprintf('%s/%03d/%s', $prefix, $count, $date);
    }

    /**
     * Get letter prefix by type
     */
    private static function getLetterPrefix($type)
    {
        $prefixes = [
            'domisili' => 'SKD',
            'usaha' => 'SKU',
            'skck' => 'SKCK',
            'tidak_mampu' => 'SKTM',
            'nikah' => 'SPN',
            'kematian' => 'SKM',
            'kelahiran' => 'SKL',
            'pindah' => 'SKP',
        ];

        return $prefixes[$type] ?? 'SK';
    }
}

