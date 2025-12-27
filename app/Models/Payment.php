<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'bill_id',
        'transaction_id',
        'amount',
        'method',
        'proof_path',
        'status',
        'paid_at',
        'snap_token',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }
}
