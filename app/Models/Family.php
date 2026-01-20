<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $table = 'families';

    protected $fillable = [
        'kk',
        'head_name',
        'head_nik',
        'hamlet',
        'rt',
        'rw',
        'address',
        'postal_code',
        'total_members',
    ];
    
    /**
     * Get all members (residents) of this family
     */
    public function members()
    {
        return $this->hasMany(Resident::class, 'family_card_number', 'kk');
    }
}
