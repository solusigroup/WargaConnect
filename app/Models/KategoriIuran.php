<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriIuran extends Model
{
    use HasFactory;

    protected $table = 'kategori_iuran';

    protected $fillable = [
        'nama_iuran',
        'nominal',
        'is_active',
        'is_mandatory',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_mandatory' => 'boolean',
        'nominal' => 'decimal:2',
    ];
}
