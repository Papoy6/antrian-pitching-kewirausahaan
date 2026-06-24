@extends('layouts.app')
@section('title', 'Pilih Jadwal')
@section('content')
<h4 class="mb-3">Pilih Jadwal Pitching</h4>

@if($kelompok->catatan_revisi)
    <div class="alert alert-warning">
        <strong>Jadwal sebelumnya perlu direvisi:</strong><br>{{ $kelompok->catatan_revisi }}
    </div>
@endif
<div class="row">
@forelse($jadwals as $j)
    <div class="col-md-4 mb-3">
        <div class="card p-3 h-100">
            <h6>{{ $j->tanggal->translatedFormat('d F Y') }}</h6>
            <p class="mb-1">
                {{ \Illuminate\Support\Carbon::parse($j->jam_mulai)->format('H:i') }} -
                {{ \Illuminate\Support\Carbon::parse($j->jam_selesai)->format('H:i') }}
            </p>
            <p class="text-muted small mb-2">{{ $j->ruangan }}</p>
            <p class="mb-3">Kuota tersisa: <strong>{{ $j->kuotaTersisa() }}</strong> / {{ $j->kuota }}</p>
            <form method="POST" action="{{ route('peserta.jadwal.pilih', $j) }}">
                @csrf
                <button class="btn btn-primary w-100">Pilih Jadwal Ini</button>
            </form>
        </div>
    </div>
@empty
    <p class="text-muted">Belum ada jadwal yang tersedia. Silakan cek kembali nanti.</p>
@endforelse
</div>
@endsection
