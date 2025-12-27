<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'wargas';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nik',
        'no_kk',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_rumah',
        'foto_ktp',
        'latitude',
        'longitude',
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class);
    }

    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', 'verified');
    }
}
