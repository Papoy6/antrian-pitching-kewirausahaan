@extends('layouts.app')
@section('title', 'Kelola Jadwal')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Kelola Jadwal Pitching</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Jadwal</button>
</div>

<div class="card p-3">
    <table class="table align-middle">
        <thead><tr><th>Tanggal</th><th>Waktu</th><th>Ruangan</th><th>Kuota</th><th class="text-end"></th></tr></thead>
        <tbody>
        @forelse($jadwals as $j)
            <tr>
                <td>{{ $j->tanggal->translatedFormat('d F Y') }}</td>
                <td>
                    {{ \Illuminate\Support\Carbon::parse($j->jam_mulai)->format('H:i') }} -
                    {{ \Illuminate\Support\Carbon::parse($j->jam_selesai)->format('H:i') }}
                </td>
                <td>{{ $j->ruangan }}</td>
                <td>{{ $j->kuotaTerisi() }} / {{ $j->kuota }}</td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $j->id }}">Edit</button>
                    <form method="POST" action="{{ route('admin.jadwal.destroy', $j) }}" class="d-inline" onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>

            <div class="modal fade" id="modalEdit{{ $j->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.jadwal.update', $j) }}">
                            @csrf @method('PUT')
                            <div class="modal-header"><h6 class="modal-title">Edit Jadwal</h6></div>
                            <div class="modal-body">
                                @include('admin.partials.jadwal-fields', ['jadwal' => $j])
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <tr><td colspan="5" class="text-center text-muted">Belum ada jadwal.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.jadwal.store') }}">
                @csrf
                <div class="modal-header"><h6 class="modal-title">Tambah Jadwal</h6></div>
                <div class="modal-body">
                    @include('admin.partials.jadwal-fields')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection