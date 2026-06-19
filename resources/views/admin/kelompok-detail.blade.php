@extends('layouts.app')
@section('title', 'Detail Kelompok')
@section('content')
<div class="d-flex align-items-center mb-3">
    <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h4 class="mb-0">Detail Kelompok #{{ $kelompok->nomor_antrean }}</h4>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card p-3 mb-3">
            <h6>Data Kelompok</h6>
            <p class="mb-1"><strong>{{ $kelompok->nama_kelompok }}</strong> &mdash; {{ $kelompok->nama_usaha ?? '-' }}</p>
            <p class="mb-1 text-muted">{{ $kelompok->prodi ?? '-' }}</p>
            <p class="mb-0">Status: <span class="badge bg-secondary">{{ \App\Models\Kelompok::labelStatus($kelompok->status) }}</span></p>
        </div>

        <div class="card p-3 mb-3">
            <h6>Anggota</h6>
            <ul class="mb-0">
                @foreach($kelompok->anggota as $a)
                    <li>{{ $a->nama }} ({{ $a->jabatan }}) {{ $a->nim ? '- '.$a->nim : '' }}</li>
                @endforeach
            </ul>
        </div>

        <div class="card p-3">
            <h6>Berkas Diunggah</h6>
            @forelse($kelompok->berkas as $b)
                <p class="mb-1">
                    <a href="{{ \Illuminate\Support\Facades\Storage::url($b->path) }}" target="_blank">{{ $b->nama_file }}</a>
                    &mdash;
                    <span class="badge bg-{{ $b->status === 'diterima' ? 'success' : ($b->status === 'ditolak' ? 'danger' : 'secondary') }}">{{ $b->status }}</span>
                    <small class="text-muted">({{ $b->created_at->translatedFormat('d M Y H:i') }})</small>
                </p>
            @empty
                <p class="text-muted">Belum ada berkas.</p>
            @endforelse
        </div>
    </div>

    <div class="col-md-5">
        <div class="card p-3">
            <h6>Tindakan Petugas</h6>

            @if($kelompok->status === 'menunggu_verifikasi')
                <form method="POST" action="{{ route('admin.kelompok.verifikasi', $kelompok) }}" class="mb-3">
                    @csrf
                    <button class="btn btn-success w-100">Verifikasi Lengkap</button>
                </form>
                <form method="POST" action="{{ route('admin.kelompok.tolak', $kelompok) }}">
                    @csrf
                    <textarea name="catatan_revisi" class="form-control mb-2" placeholder="Catatan revisi..." required></textarea>
                    <button class="btn btn-danger w-100">Tolak / Minta Revisi</button>
                </form>
            @elseif($kelompok->status === 'menunggu_konfirmasi')
                <p class="mb-2">Jadwal terpilih:
                    <strong>
                        {{ $kelompok->jadwal?->tanggal?->translatedFormat('d F Y') }}
                        {{ \Illuminate\Support\Carbon::parse($kelompok->jadwal?->jam_mulai)->format('H:i') }}
                    </strong>
                </p>
                <form method="POST" action="{{ route('admin.kelompok.konfirmasi', $kelompok) }}">
                    @csrf
                    <button class="btn btn-primary w-100">Konfirmasi Akhir &amp; Terbitkan E-Receipt</button>
                </form>
            @elseif($kelompok->status === 'terjadwal')
                <p class="mb-2">Nomor Kelompok: <strong>{{ $kelompok->nomor_kelompok }}</strong></p>
                <a href="{{ route('admin.kelompok.e-receipt', $kelompok) }}" target="_blank" class="btn btn-outline-success w-100">Lihat E-Receipt</a>
            @else
                <p class="text-muted mb-0">
                    Menunggu peserta {{ $kelompok->status === 'revisi' ? 'mengunggah ulang berkas' : 'memilih jadwal' }}.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection