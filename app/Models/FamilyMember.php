<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $table = 'family_members';

    protected $fillable = [
        'user_id',
        'name',
        'nik',
        'relationship',
        'place_of_birth',
        'date_of_birth',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function headOfFamily()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
