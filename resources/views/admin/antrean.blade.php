@extends('layouts.app')
@section('title', 'Antrean Verifikasi')
@section('content')
<h4 class="mb-3">Antrean Verifikasi Berkas</h4>
<div class="card p-3">
    <table class="table align-middle">
        <thead><tr><th>No. Antrean</th><th>Kelompok</th><th>Status</th><th class="text-end"></th></tr></thead>
        <tbody>
        @forelse($antrean as $k)
            <tr>
                <td>#{{ $k->nomor_antrean }}</td>
                <td>{{ $k->nama_kelompok }}<br><small class="text-muted">{{ $k->user->name }}</small></td>
                <td>
                    @if($k->dipanggil_at)
                        <span class="badge bg-info">Sedang Diproses</span>
                    @else
                        <span class="badge bg-secondary">Menunggu</span>
                    @endif
                </td>
                <td class="text-end">
                    @if(!$k->dipanggil_at)
                    <form method="POST" action="{{ route('admin.antrean.panggil', $k) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-primary">Panggil</button>
                    </form>
                    @else
                    <a href="{{ route('admin.kelompok.show', $k) }}" class="btn btn-sm btn-outline-primary">Lanjutkan</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted">Antrean kosong.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
// Refresh halaman secara berkala agar petugas melihat antrean terbaru.
setInterval(() => location.reload(), 15000);
</script>
@endpush