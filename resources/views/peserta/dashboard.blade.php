@extends('layouts.app')
@section('title', 'Dashboard Peserta')
@section('content')
<h3 class="mb-4">Status Pendaftaran Pitching</h3>

<div class="card p-4" id="status-card">
    <div class="d-flex justify-content-between align-items-start flex-wrap">
        <div>
            <h5>{{ $kelompok->nama_kelompok }}</h5>
            <p class="text-muted mb-1">{{ $kelompok->nama_usaha ?? '-' }} &middot; {{ $kelompok->prodi ?? '-' }}</p>
            @if($kelompok->nomor_kelompok)
                <p class="mb-1">Nomor Kelompok: <strong>{{ $kelompok->nomor_kelompok }}</strong></p>
            @endif
            <p class="mb-0">Nomor Antrean: <strong>#{{ $kelompok->nomor_antrean }}</strong></p>
        </div>
        <span id="badge-status" class="badge bg-{{ match($kelompok->status) {
                'menunggu_verifikasi' => 'warning',
                'revisi' => 'danger',
                'siap_pilih_jadwal' => 'info',
                'menunggu_konfirmasi' => 'primary',
                'terjadwal' => 'success',
                default => 'secondary',
            } }} badge-status px-3 py-2">
            {{ \App\Models\Kelompok::labelStatus($kelompok->status) }}
        </span>
    </div>

    @if($kelompok->status === 'menunggu_verifikasi')
        <hr>
        <p id="posisi-antrean" class="mb-0">
            Posisi Anda dalam antrean verifikasi: <strong>{{ $posisiAntrean }}</strong> dari {{ $totalAntrean }} kelompok yang menunggu.
        </p>
        <small class="text-muted">Halaman ini memperbarui posisi antrean secara otomatis setiap 10 detik.</small>
    @endif

    @if($kelompok->status === 'revisi')
        <hr>
        <div class="alert alert-danger mb-3">
            <strong>Catatan revisi dari petugas:</strong><br>{{ $kelompok->catatan_revisi }}
        </div>
        <a href="{{ route('peserta.kelompok.edit-upload') }}" class="btn btn-danger">Unggah Ulang Berkas</a>
    @endif

    @if($kelompok->status === 'siap_pilih_jadwal')
        <hr>
        @if($kelompok->catatan_revisi)
            <div class="alert alert-warning mb-3">
                <strong>Catatan revisi jadwal dari petugas:</strong><br>{{ $kelompok->catatan_revisi }}
            </div>
            <p>Silakan pilih ulang jadwal pitching yang tersedia.</p>
        @else
            <p>Berkas Anda telah diverifikasi lengkap. Silakan pilih jadwal pitching Anda.</p>
        @endif
        <a href="{{ route('peserta.jadwal') }}" class="btn btn-primary">Pilih Jadwal</a>
    @endif

    @if($kelompok->status === 'menunggu_konfirmasi')
        <hr>
        <p class="mb-1">Jadwal terpilih:
            <strong>
                {{ $kelompok->jadwal?->tanggal?->translatedFormat('d F Y') }},
                {{ \Illuminate\Support\Carbon::parse($kelompok->jadwal?->jam_mulai)->format('H:i') }} -
                {{ \Illuminate\Support\Carbon::parse($kelompok->jadwal?->jam_selesai)->format('H:i') }}
                ({{ $kelompok->jadwal?->ruangan }})
            </strong>
        </p>
        <p class="text-muted mb-0">Menunggu konfirmasi akhir dari petugas BPA.</p>
    @endif

    @if($kelompok->status === 'terjadwal')
        <hr>
        <p class="mb-2">Pendaftaran Anda telah dikonfirmasi. Jadwal:
            <strong>
                {{ $kelompok->jadwal?->tanggal?->translatedFormat('d F Y') }},
                {{ \Illuminate\Support\Carbon::parse($kelompok->jadwal?->jam_mulai)->format('H:i') }}
                ({{ $kelompok->jadwal?->ruangan }})
            </strong>
        </p>
        <a href="{{ route('peserta.e-receipt') }}" target="_blank" class="btn btn-success">Unduh E-Receipt</a>
    @endif
</div>

<div class="card p-4 mt-4">
    <h6>Anggota Kelompok</h6>
    <ul class="mb-0">
        @foreach($kelompok->anggota as $a)
            <li>{{ $a->nama }} ({{ $a->jabatan }}) @if($a->nim) &mdash; {{ $a->nim }} @endif</li>
        @endforeach
    </ul>
</div>
@endsection

@push('scripts')
<script>
@if($kelompok->status === 'menunggu_verifikasi')
setInterval(() => {
    fetch("{{ route('api.status') }}")
        .then(r => r.json())
        .then(data => {
            if (data.posisi_antrean) {
                document.getElementById('posisi-antrean').innerHTML =
                    'Posisi Anda dalam antrean verifikasi: <strong>' + data.posisi_antrean + '</strong>';
            }
            if (data.status && data.status !== 'menunggu_verifikasi') {
                location.reload();
            }
        });
}, 10000);
@endif
</script>
@endpush
