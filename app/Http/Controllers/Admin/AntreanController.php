<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class AntreanController extends Controller
{
    public function index()
    {
        $antrean = Kelompok::with('user')
            ->where('status', 'menunggu_verifikasi')
            ->orderBy('nomor_antrean')
            ->get();

        return view('admin.antrean', compact('antrean'));
    }

    public function panggil(Request $request, Kelompok $kelompok)
    {
        if ($kelompok->status !== 'menunggu_verifikasi') {
            return back()->withErrors(['antrean' => 'Kelompok ini tidak sedang berada dalam antrean verifikasi.']);
        }

        $kelompok->update(['dipanggil_at' => now()]);

        return redirect()->route('admin.kelompok.show', $kelompok)
            ->with('status', 'Kelompok nomor antrean #'.$kelompok->nomor_antrean.' dipanggil untuk diproses.');
    }
}