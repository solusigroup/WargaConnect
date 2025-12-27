<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'user_id',
        'kategori_iuran_id',
        'month',
        'year',
        'amount',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategoriIuran()
    {
        return $this->belongsTo(KategoriIuran::class, 'kategori_iuran_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'bill_id');
    }

    public function getMonthNameAttribute()
    {
        return Carbon::createFromDate($this->year, $this->month, 1)->translatedFormat('F');
    }
}
