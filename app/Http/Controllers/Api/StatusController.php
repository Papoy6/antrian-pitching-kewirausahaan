<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isPeserta()) {
            $kelompok = $user->kelompok;

            if (! $kelompok) {
                return response()->json(['ada_kelompok' => false]);
            }

            $posisi = null;
            if ($kelompok->status === 'menunggu_verifikasi') {
                $posisi = Kelompok::where('status', 'menunggu_verifikasi')
                    ->where('nomor_antrean', '<', $kelompok->nomor_antrean)
                    ->count() + 1;
            }

            return response()->json([
                'ada_kelompok' => true,
                'status' => $kelompok->status,
                'label_status' => Kelompok::labelStatus($kelompok->status),
                'nomor_antrean' => $kelompok->nomor_antrean,
                'posisi_antrean' => $posisi,
            ]);
        }

        return response()->json([
            'menunggu_verifikasi' => Kelompok::where('status', 'menunggu_verifikasi')->count(),
        ]);
    }
}