<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    public function show(Kelompok $kelompok)
    {
        $kelompok->load(['anggota', 'berkas', 'jadwal', 'user']);

        return view('admin.kelompok-detail', compact('kelompok'));
    }

    public function verifikasi(Request $request, Kelompok $kelompok)
    {
        if ($kelompok->status !== 'menunggu_verifikasi') {
            return back()->withErrors(['verifikasi' => 'Status kelompok tidak valid untuk diverifikasi.']);
        }

        $kelompok->berkasTerbaru?->update(['status' => 'diterima']);

        $kelompok->update([
            'status' => 'siap_pilih_jadwal',
            'diverifikasi_at' => now(),
            'diverifikasi_oleh' => $request->user()->id,
            'catatan_revisi' => null,
        ]);

        return redirect()->route('admin.antrean')
            ->with('status', 'Berkas kelompok "'.$kelompok->nama_kelompok.'" dinyatakan lengkap.');
    }

    public function tolak(Request $request, Kelompok $kelompok)
    {
        $data = $request->validate([
            'catatan_revisi' => ['required', 'string', 'max:1000'],
        ]);

        if ($kelompok->status !== 'menunggu_verifikasi') {
            return back()->withErrors(['verifikasi' => 'Status kelompok tidak valid untuk ditolak.']);
        }

        $kelompok->berkasTerbaru?->update([
            'status' => 'ditolak',
            'catatan' => $data['catatan_revisi'],
        ]);

        $kelompok->update([
            'status' => 'revisi',
            'catatan_revisi' => $data['catatan_revisi'],
            'diverifikasi_oleh' => $request->user()->id,
        ]);

        return redirect()->route('admin.antrean')
            ->with('status', 'Kelompok "'.$kelompok->nama_kelompok.'" diminta merevisi berkas.');
    }


    public function revisiJadwal(Request $request, Kelompok $kelompok)
    {
        $data = $request->validate([
            'catatan_revisi' => ['required', 'string', 'max:1000'],
        ]);

        if ($kelompok->status !== 'menunggu_konfirmasi') {
            return back()->withErrors(['konfirmasi' => 'Kelompok belum memilih jadwal atau sudah dikonfirmasi.']);
        }

        $kelompok->update([
            'status' => 'siap_pilih_jadwal',
            'jadwal_id' => null,
            'catatan_revisi' => $data['catatan_revisi'],
        ]);

        return redirect()->route('admin.konfirmasi')
            ->with('status', 'Kelompok "'.$kelompok->nama_kelompok.'" diminta memilih ulang jadwal pitching.');
    }
    public function konfirmasi(Request $request, Kelompok $kelompok)
    {
        if ($kelompok->status !== 'menunggu_konfirmasi') {
            return back()->withErrors(['konfirmasi' => 'Kelompok belum memilih jadwal.']);
        }

        $nomorKelompok = $kelompok->nomor_kelompok
            ?? sprintf('PTK-%s-%03d', now()->format('Y'), $kelompok->id);

        $kelompok->update([
            'status' => 'terjadwal',
            'nomor_kelompok' => $nomorKelompok,
            'dikonfirmasi_at' => now(),
        ]);

        return redirect()->route('admin.kelompok.show', $kelompok)
            ->with('status', 'Pendaftaran dikonfirmasi. E-Receipt sudah tersedia untuk peserta.');
    }

    public function eReceipt(Kelompok $kelompok)
    {
        if ($kelompok->status !== 'terjadwal') {
            abort(404);
        }

        $kelompok->load(['anggota', 'jadwal']);

        $pdf = Pdf::loadView('peserta.e-receipt-pdf', compact('kelompok'));

        return $pdf->stream('e-receipt-'.$kelompok->nomor_kelompok.'.pdf');
    }
}
