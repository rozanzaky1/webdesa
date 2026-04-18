<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_card_number',
        'nik',
        'name',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'hamlet',
        'rt',
        'rw',
        'religion',
        'marital_status',
        'occupation',
        'phone',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the family that this member belongs to
     */
    public function family()
    {
        return $this->belongsTo(Family::class, 'family_card_number', 'kk');
    }
}
