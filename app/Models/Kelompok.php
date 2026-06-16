<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jadwal_id',
        'nomor_kelompok',
        'nomor_antrean',
        'nama_kelompok',
        'nama_usaha',
        'prodi',
        'status',
        'catatan_revisi',
        'dipanggil_at',
        'diverifikasi_at',
        'dikonfirmasi_at',
        'diverifikasi_oleh',
    ];

    protected $casts = [
        'dipanggil_at' => 'datetime',
        'diverifikasi_at' => 'datetime',
        'dikonfirmasi_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function anggota()
    {
        return $this->hasMany(AnggotaKelompok::class);
    }

    /**
     * Seluruh riwayat berkas yang pernah diunggah (terbaru lebih dulu).
     */
    public function berkas()
    {
        return $this->hasMany(Berkas::class)->latest();
    }

    /**
     * Berkas yang paling baru diunggah.
     */
    public function berkasTerbaru()
    {
        return $this->hasOne(Berkas::class)->latestOfMany();
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    /**
     * Label status berbahasa Indonesia untuk ditampilkan ke pengguna.
     */
    public static function labelStatus(string $status): string
    {
        return match ($status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi Berkas',
            'revisi' => 'Berkas Ditolak (Perlu Revisi)',
            'siap_pilih_jadwal' => 'Siap Memilih Jadwal',
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi Petugas',
            'terjadwal' => 'Terjadwal',
            default => $status,
        };
    }
}