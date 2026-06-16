<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKelompok extends Model
{
    protected $table = 'anggota_kelompoks';

    protected $fillable = [
        'kelompok_id',
        'nama',
        'nim',
        'jabatan',
    ];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }
}