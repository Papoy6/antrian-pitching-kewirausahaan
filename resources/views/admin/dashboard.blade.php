@extends('layouts.app')
@section('title', 'Dashboard Petugas')

@push('styles')
<style>
    .dashboard-hero {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, .25);
        border-radius: 1.45rem;
        padding: 1.4rem;
        color: #ffffff;
        background:
            radial-gradient(circle at 92% 12%, rgba(20,184,166,.55), transparent 17rem),
            linear-gradient(135deg, #0f172a 0%, #1d4ed8 62%, #0f766e 100%);
        box-shadow: 0 24px 70px rgba(15, 23, 42, .16);
    }

    .dashboard-hero h3 {
        color: #ffffff;
        font-weight: 800;
    }

    .dashboard-hero .hero-copy {
        max-width: 39rem;
        color: rgba(255,255,255,.78);
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .42rem .8rem;
        border-radius: 999px;
        color: #dbeafe;
        background: rgba(255,255,255,.12);
        font-size: .78rem;
        font-weight: 800;
        transition: transform .2s ease, background .2s ease;
    }

    .hero-badge:hover {
        transform: translateY(-1px);
        background: rgba(255,255,255,.18);
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, .26);
        border-radius: 1.15rem;
        background: rgba(255,255,255,.94);
        box-shadow: 0 16px 42px rgba(15, 23, 42, .08);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(var(--accent-rgb), .42);
        box-shadow: 0 24px 56px rgba(15, 23, 42, .13);
    }

    .stat-card::before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: .35rem;
        background: rgb(var(--accent-rgb));
    }

    .stat-icon {
        width: 2.85rem;
        height: 2.85rem;
        display: grid;
        place-items: center;
        border-radius: 1rem;
        color: rgb(var(--accent-rgb));
        background: rgba(var(--accent-rgb), .1);
        font-size: 1.15rem;
    }

    .stat-label {
        color: #667085;
        font-size: .78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .stat-value {
        color: #0f172a;
        font-size: 2.05rem;
        font-weight: 800;
        line-height: 1;
    }

    .soft-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        border-radius: 999px;
        padding: .28rem .6rem;
        color: rgb(var(--accent-rgb));
        background: rgba(var(--accent-rgb), .1);
        font-size: .75rem;
        font-weight: 800;
        transition: transform .2s ease, background .2s ease;
    }

    .soft-badge:hover {
        transform: translateY(-1px);
        background: rgba(var(--accent-rgb), .16);
    }

    .panel-card {
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .panel-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 24px 58px rgba(15, 23, 42, .12);
    }

    .queue-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.7rem;
        padding: .25rem .55rem;
        border-radius: .75rem;
        color: #1d4ed8;
        background: #eff6ff;
        font-weight: 800;
    }

    .schedule-item {
        border: 1px solid rgba(148, 163, 184, .24);
        border-radius: 1rem;
        padding: .8rem .9rem;
        background: rgba(248, 250, 252, .75);
        transition: transform .2s ease, border-color .2s ease, background .2s ease;
    }

    .schedule-item:hover {
        transform: translateX(4px);
        border-color: rgba(37, 99, 235, .34);
        background: #ffffff;
    }
</style>
@endpush

@section('content')
@php
    $totalAntrean = array_sum($stats);
    $menunggu = $stats['menunggu_verifikasi'] ?? 0;
    $diterima = ($stats['siap_pilih_jadwal'] ?? 0) + ($stats['menunggu_konfirmasi'] ?? 0) + ($stats['terjadwal'] ?? 0);
    $ditolak = $stats['revisi'] ?? 0;
    $jadwalAktif = $jadwalMendatang->count();

    $cards = [
        ['label' => 'Total Antrean', 'value' => $totalAntrean, 'icon' => 'bi-collection-fill', 'accent' => '37,99,235', 'hint' => 'Semua data'],
        ['label' => 'Menunggu', 'value' => $menunggu, 'icon' => 'bi-hourglass-split', 'accent' => '245,158,11', 'hint' => 'Perlu verifikasi', 'url' => route('admin.antrean')],
        ['label' => 'Diterima', 'value' => $diterima, 'icon' => 'bi-check-circle-fill', 'accent' => '16,185,129', 'hint' => 'Lanjut proses'],
        ['label' => 'Ditolak/Revisi', 'value' => $ditolak, 'icon' => 'bi-exclamation-triangle-fill', 'accent' => '239,68,68', 'hint' => 'Butuh perbaikan'],
        ['label' => 'Jadwal Aktif', 'value' => $jadwalAktif, 'icon' => 'bi-calendar2-week-fill', 'accent' => '20,184,166', 'hint' => 'Mendatang', 'url' => route('admin.jadwal.index')],
    ];
@endphp

<div class="dashboard-hero mb-4">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
        <div>
            <span class="hero-badge mb-3"><i class="bi bi-stars"></i> Dashboard Petugas BPA</span>
            <h3 class="mb-2">Pantau antrean pitching dengan lebih cepat</h3>
            <p class="hero-copy mb-0">Ringkasan status, antrean teratas, dan jadwal mendatang ditampilkan dalam satu layar supaya proses verifikasi lebih mudah dipantau.</p>
        </div>
        <a href="{{ route('admin.antrean') }}" class="btn btn-light fw-bold">
            Lihat Antrean <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</div>

<div class="row mb-4 g-3">
    @foreach($cards as $card)
    <div class="col-6 col-lg">
        @if(isset($card['url']))
        <a href="{{ $card['url'] }}" class="text-decoration-none">
        @endif
            <div class="stat-card h-100 p-3" style="--accent-rgb: {{ $card['accent'] }};">
                <div class="d-flex align-items-start justify-content-between gap-3">
                    <div>
                        <div class="stat-label">{{ $card['label'] }}</div>
                        <div class="stat-value mt-3">{{ $card['value'] }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi {{ $card['icon'] }}"></i>
                    </div>
                </div>
                <div class="soft-badge mt-3">
                    <i class="bi bi-activity"></i> {{ $card['hint'] }}
                </div>
            </div>
        @if(isset($card['url']))
        </a>
        @endif
    </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card panel-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="mb-0">5 Antrean Teratas</h6>
                <span class="badge bg-primary-subtle text-primary">Prioritas</span>
            </div>
            <table class="table table-sm align-middle">
                <thead><tr><th>No</th><th>Kelompok</th><th></th></tr></thead>
                <tbody>
                @forelse($antreanTeratas as $k)
                    <tr>
                        <td><span class="queue-number">#{{ $k->nomor_antrean }}</span></td>
                        <td class="fw-semibold">{{ $k->nama_kelompok }}</td>
                        <td class="text-end"><a href="{{ route('admin.kelompok.show', $k) }}" class="btn btn-sm btn-outline-primary">Proses</a></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted text-center py-4">Tidak ada antrean.</td></tr>
                @endforelse
                </tbody>
            </table>
            <a href="{{ route('admin.antrean') }}" class="small">Lihat semua antrean &rarr;</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card panel-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="mb-0">Jadwal Mendatang</h6>
                <span class="badge bg-success-subtle text-success">Aktif</span>
            </div>
            <div class="d-grid gap-2 mb-3">
            @forelse($jadwalMendatang as $j)
                <div class="schedule-item">
                    <div class="fw-bold">{{ $j->tanggal->translatedFormat('d M Y') }}</div>
                    <div class="small text-muted">
                        {{ \Illuminate\Support\Carbon::parse($j->jam_mulai)->format('H:i') }}
                        &mdash; kuota {{ $j->kuotaTerisi() }}/{{ $j->kuota }}
                    </div>
                </div>
            @empty
                <div class="text-muted">Belum ada jadwal.</div>
            @endforelse
            </div>
            <a href="{{ route('admin.jadwal.index') }}" class="small">Kelola jadwal &rarr;</a>
        </div>
    </div>
</div>
@endsection
