<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';

    protected $fillable = [
        'judul',
        'deskripsi',
        'nominal',
        'tanggal_pengeluaran',
        'bukti_foto',
        'created_by',
    ];

    protected $casts = [
        'tanggal_pengeluaran' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
