<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributionCategory extends Model
{
    use HasFactory;

    protected $table = 'iuran_kategori';

    protected $fillable = [
        'name',
        'amount',
        'is_mandatory',
        'frequency',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
        'amount' => 'decimal:2',
    ];
}
