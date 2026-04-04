<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $table = 'residents';
    
    protected $fillable = [
        'user_id',
        'nik',
        'family_card_number',
        'name',
        'gender',
        'birth_date',
        'birth_place',
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
     * Get the user associated with the resident
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get family members with same family_card_number
     */
    public function familyMembers()
    {
        return $this->hasMany(Resident::class, 'family_card_number', 'family_card_number')
            ->where('id', '!=', $this->id);
    }
}
