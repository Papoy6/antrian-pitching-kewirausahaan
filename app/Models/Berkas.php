<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table = 'berkas';

    protected $fillable = [
        'kelompok_id',
        'nama_file',
        'path',
        'status',
        'catatan',
    ];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }
}