<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'nik',
        'kk_number',
        'address',
        'house_number',
        'place_of_birth',
        'date_of_birth',
        'ktp_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function warga()
    {
        return $this->hasOne(Warga::class);
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function calculateArrears()
    {
        return $this->bills()->whereIn('status', ['unpaid', 'arrears'])->sum('amount');
    }
}
