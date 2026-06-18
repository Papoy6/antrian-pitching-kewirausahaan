<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::orderBy('tanggal')->orderBy('jam_mulai')->get();

        return view('admin.jadwal-index', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required', 'after:jam_mulai'],
            'ruangan' => ['nullable', 'string', 'max:255'],
            'kuota' => ['required', 'integer', 'min:1'],
        ]);

        Jadwal::create($data);

        return redirect()->route('admin.jadwal.index')->with('status', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required', 'after:jam_mulai'],
            'ruangan' => ['nullable', 'string', 'max:255'],
            'kuota' => ['required', 'integer', 'min:1'],
        ]);

        $jadwal->update($data);

        return redirect()->route('admin.jadwal.index')->with('status', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('status', 'Jadwal berhasil dihapus.');
    }
}