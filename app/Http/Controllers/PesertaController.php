<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelompok;
use App\Models\Berkas;
use App\Models\Jadwal;
use App\Models\Kelompok;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    /**
     * Dashboard status pendaftaran & antrean milik peserta yang login.
     */
    public function dashboard(Request $request)
    {
        $kelompok = $request->user()->kelompok;

        if (! $kelompok) {
            return redirect()->route('peserta.kelompok.create');
        }

        $kelompok->load(['anggota', 'jadwal']);

        $posisiAntrean = null;
        $totalAntrean = null;

        if ($kelompok->status === 'menunggu_verifikasi') {
            $totalAntrean = Kelompok::where('status', 'menunggu_verifikasi')->count();
            $posisiAntrean = Kelompok::where('status', 'menunggu_verifikasi')
                ->where('nomor_antrean', '<', $kelompok->nomor_antrean)
                ->count() + 1;
        }

        return view('peserta.dashboard', compact('kelompok', 'posisiAntrean', 'totalAntrean'));
    }

    /**
     * Form pendaftaran data kelompok pertama kali (sekaligus unggah berkas).
     */
    public function create(Request $request)
    {
        if ($request->user()->kelompok) {
            return redirect()->route('peserta.dashboard');
        }

        return view('peserta.kelompok-form', ['mode' => 'create']);
    }

    public function store(Request $request)
    {
        if ($request->user()->kelompok) {
            return redirect()->route('peserta.dashboard');
        }

        $data = $request->validate([
            'nama_kelompok' => ['required', 'string', 'max:255'],
            'nama_usaha' => ['nullable', 'string', 'max:255'],
            'prodi' => ['nullable', 'string', 'max:255'],
            'anggota' => ['required', 'array', 'min:1'],
            'anggota.*.nama' => ['required', 'string', 'max:255'],
            'anggota.*.nim' => ['nullable', 'string', 'max:50'],
            'anggota.*.jabatan' => ['required', 'string', 'max:50'],
            'berkas' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        // Nomor antrean diberikan secara berurutan (First-Come, First-Served).
        $nomorAntrean = (Kelompok::max('nomor_antrean') ?? 0) + 1;

        $kelompok = Kelompok::create([
            'user_id' => $request->user()->id,
            'nama_kelompok' => $data['nama_kelompok'],
            'nama_usaha' => $data['nama_usaha'] ?? null,
            'prodi' => $data['prodi'] ?? null,
            'nomor_antrean' => $nomorAntrean,
            'status' => 'menunggu_verifikasi',
        ]);

        foreach ($data['anggota'] as $anggota) {
            AnggotaKelompok::create([
                'kelompok_id' => $kelompok->id,
                'nama' => $anggota['nama'],
                'nim' => $anggota['nim'] ?? null,
                'jabatan' => $anggota['jabatan'],
            ]);
        }

        $path = $request->file('berkas')->store('berkas/'.$kelompok->id, 'public');

        Berkas::create([
            'kelompok_id' => $kelompok->id,
            'nama_file' => $request->file('berkas')->getClientOriginalName(),
            'path' => $path,
            'status' => 'menunggu',
        ]);

        return redirect()->route('peserta.dashboard')
            ->with('status', 'Pendaftaran berhasil. Nomor antrean Anda adalah #'.$nomorAntrean.'.');
    }

    /**
     * Form unggah ulang berkas ketika status = revisi.
     */
    public function editUpload(Request $request)
    {
        $kelompok = $request->user()->kelompok;

        if (! $kelompok || $kelompok->status !== 'revisi') {
            return redirect()->route('peserta.dashboard');
        }

        return view('peserta.kelompok-form', ['mode' => 'upload', 'kelompok' => $kelompok]);
    }

    public function storeUpload(Request $request)
    {
        $kelompok = $request->user()->kelompok;

        if (! $kelompok || $kelompok->status !== 'revisi') {
            return redirect()->route('peserta.dashboard');
        }

        $data = $request->validate([
            'berkas' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        $path = $request->file('berkas')->store('berkas/'.$kelompok->id, 'public');

        Berkas::create([
            'kelompok_id' => $kelompok->id,
            'nama_file' => $request->file('berkas')->getClientOriginalName(),
            'path' => $path,
            'status' => 'menunggu',
        ]);

        // Kelompok masuk kembali ke antrean verifikasi dengan nomor antrean baru.
        $nomorAntrean = (Kelompok::max('nomor_antrean') ?? 0) + 1;

        $kelompok->update([
            'status' => 'menunggu_verifikasi',
            'catatan_revisi' => null,
            'nomor_antrean' => $nomorAntrean,
        ]);

        return redirect()->route('peserta.dashboard')
            ->with('status', 'Berkas revisi berhasil diunggah ulang. Anda masuk antrean verifikasi kembali dengan nomor #'.$nomorAntrean.'.');
    }

    /**
     * Daftar jadwal yang masih tersedia untuk dipilih.
     */
    public function jadwal(Request $request)
    {
        $kelompok = $request->user()->kelompok;

        if (! $kelompok || $kelompok->status !== 'siap_pilih_jadwal') {
            return redirect()->route('peserta.dashboard');
        }

        $jadwals = Jadwal::orderBy('tanggal')->orderBy('jam_mulai')
            ->get()
            ->filter(fn ($j) => $j->kuotaTersisa() > 0)
            ->values();

        return view('peserta.jadwal', compact('kelompok', 'jadwals'));
    }

    public function pilihJadwal(Request $request, Jadwal $jadwal)
    {
        $kelompok = $request->user()->kelompok;

        if (! $kelompok || $kelompok->status !== 'siap_pilih_jadwal') {
            return redirect()->route('peserta.dashboard');
        }

        if ($jadwal->kuotaTersisa() <= 0) {
            return back()->withErrors(['jadwal' => 'Kuota jadwal ini sudah penuh, silakan pilih jadwal lain.']);
        }

        $kelompok->update([
            'jadwal_id' => $jadwal->id,
            'status' => 'menunggu_konfirmasi',
        ]);

        return redirect()->route('peserta.dashboard')
            ->with('status', 'Jadwal berhasil dipilih. Menunggu konfirmasi akhir dari petugas BPA.');
    }

    /**
     * Unduh e-receipt (hanya jika status sudah terjadwal/dikonfirmasi).
     */
    public function eReceipt(Request $request)
    {
        $kelompok = $request->user()->kelompok;

        if (! $kelompok || $kelompok->status !== 'terjadwal') {
            return redirect()->route('peserta.dashboard');
        }

        $kelompok->load(['anggota', 'jadwal']);

        $pdf = Pdf::loadView('peserta.e-receipt-pdf', compact('kelompok'));

        return $pdf->stream('e-receipt-'.$kelompok->nomor_kelompok.'.pdf');
    }
}