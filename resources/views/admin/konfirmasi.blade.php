@extends('layouts.app')
@section('title', 'Menunggu Konfirmasi')
@section('content')
<a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
</a>
<h4 class="mb-3">Kelompok Menunggu Konfirmasi Akhir</h4>
<div class="card p-3">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Kelompok</th>
                <th>Jadwal Terpilih</th>
                <th>Ruangan</th>
                <th class="text-end"></th>
            </tr>
        </thead>
        <tbody>
        @forelse($kelompoks as $k)
            <tr>
                <td>
                    {{ $k->nama_kelompok }}
                    <br><small class="text-muted">{{ $k->user->name }}</small>
                </td>
                <td>
                    @if($k->jadwal)
                        {{ $k->jadwal->tanggal->translatedFormat('d F Y') }}
                        {{ \Illuminate\Support\Carbon::parse($k->jadwal->jam_mulai)->format('H:i') }} -
                        {{ \Illuminate\Support\Carbon::parse($k->jadwal->jam_selesai)->format('H:i') }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $k->jadwal?->ruangan ?? '-' }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.kelompok.show', $k) }}" class="btn btn-sm btn-primary">Proses</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted">Tidak ada kelompok yang menunggu konfirmasi.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection