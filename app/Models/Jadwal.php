<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'kuota',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kelompoks()
    {
        return $this->hasMany(Kelompok::class);
    }

    /**
     * Jumlah kelompok yang sudah memilih jadwal ini (sudah memesan slot).
     */
    public function kuotaTerisi(): int
    {
        return $this->kelompoks()
            ->whereIn('status', ['menunggu_konfirmasi', 'terjadwal'])
            ->count();
    }

    public function kuotaTersisa(): int
    {
        return max(0, $this->kuota - $this->kuotaTerisi());
    }
}