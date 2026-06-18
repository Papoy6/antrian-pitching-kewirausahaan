<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Kelompok::count(),
            'menunggu_verifikasi' => Kelompok::where('status', 'menunggu_verifikasi')->count(),
            'revisi' => Kelompok::where('status', 'revisi')->count(),
            'siap_pilih_jadwal' => Kelompok::where('status', 'siap_pilih_jadwal')->count(),
            'menunggu_konfirmasi' => Kelompok::where('status', 'menunggu_konfirmasi')->count(),
            'terjadwal' => Kelompok::where('status', 'terjadwal')->count(),
        ];

        $antreanTeratas = Kelompok::with('user')
            ->where('status', 'menunggu_verifikasi')
            ->orderBy('nomor_antrean')
            ->take(5)
            ->get();

        $jadwalMendatang = Jadwal::where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')->orderBy('jam_mulai')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'antreanTeratas', 'jadwalMendatang'));
    }
}