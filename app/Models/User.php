<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke data kelompok (hanya untuk user dengan role peserta).
     */
    public function kelompok()
    {
        return $this->hasOne(Kelompok::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }
}