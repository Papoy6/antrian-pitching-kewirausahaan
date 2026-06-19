@extends('layouts.app')
@section('title', 'Dashboard Petugas')
@section('content')
<h3 class="mb-4">Dashboard Petugas BPA</h3>

<div class="row mb-4 g-3">
    @foreach([
    ['label' => 'Menunggu Verifikasi', 'value' => $stats['menunggu_verifikasi'], 'color' => 'warning', 'url' => route('admin.antrean')],
    ['label' => 'Revisi', 'value' => $stats['revisi'], 'color' => 'danger', 'url' => null],
    ['label' => 'Siap Pilih Jadwal', 'value' => $stats['siap_pilih_jadwal'], 'color' => 'info', 'url' => null],
    ['label' => 'Menunggu Konfirmasi', 'value' => $stats['menunggu_konfirmasi'], 'color' => 'primary', 'url' => route('admin.konfirmasi')],
    ['label' => 'Terjadwal', 'value' => $stats['terjadwal'], 'color' => 'success', 'url' => null],
] as $card)
<div class="col-6 col-md">
    @if($card['url'])
    <a href="{{ $card['url'] }}" class="text-decoration-none">
    @endif
        <div class="card p-3 text-center h-100">
            <div class="text-muted small">{{ $card['label'] }}</div>
            <div class="fs-3 fw-bold text-{{ $card['color'] }}">{{ $card['value'] }}</div>
        </div>
    @if($card['url'])
    </a>
    @endif
</div>
@endforeach
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card p-3 h-100">
            <h6>5 Antrean Teratas</h6>
            <table class="table table-sm align-middle">
                <thead><tr><th>No</th><th>Kelompok</th><th></th></tr></thead>
                <tbody>
                @forelse($antreanTeratas as $k)
                    <tr>
                        <td>#{{ $k->nomor_antrean }}</td>
                        <td>{{ $k->nama_kelompok }}</td>
                        <td class="text-end"><a href="{{ route('admin.kelompok.show', $k) }}" class="btn btn-sm btn-outline-primary">Proses</a></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted text-center">Tidak ada antrean.</td></tr>
                @endforelse
                </tbody>
            </table>
            <a href="{{ route('admin.antrean') }}" class="small">Lihat semua antrean &rarr;</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3 h-100">
            <h6>Jadwal Mendatang</h6>
            <ul class="list-unstyled mb-2">
            @forelse($jadwalMendatang as $j)
                <li class="mb-1">
                    {{ $j->tanggal->translatedFormat('d M Y') }}
                    {{ \Illuminate\Support\Carbon::parse($j->jam_mulai)->format('H:i') }}
                    &mdash; kuota {{ $j->kuotaTerisi() }}/{{ $j->kuota }}
                </li>
            @empty
                <li class="text-muted">Belum ada jadwal.</li>
            @endforelse
            </ul>
            <a href="{{ route('admin.jadwal.index') }}" class="small">Kelola jadwal &rarr;</a>
        </div>
    </div>
</div>
@endsection