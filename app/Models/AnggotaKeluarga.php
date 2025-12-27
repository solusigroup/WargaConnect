<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    use HasFactory;

    protected $table = 'anggota_keluarga';

    protected $fillable = [
        'warga_id',
        'nama_lengkap',
        'nik',
        'hubungan_keluarga',
        'tempat_lahir',
        'tanggal_lahir',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
