@extends('layouts.app')
@section('title', $mode === 'create' ? 'Data Kelompok' : 'Unggah Ulang Berkas')
@section('content')
<div class="card p-4">
@if($mode === 'create')
    <h4 class="mb-3">Lengkapi Data Kelompok</h4>
    <form method="POST" action="{{ route('peserta.kelompok.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Kelompok</label>
            <input type="text" name="nama_kelompok" class="form-control" value="{{ old('nama_kelompok') }}" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Usaha</label>
                <input type="text" name="nama_usaha" class="form-control" value="{{ old('nama_usaha') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Program Studi</label>
                <input type="text" name="prodi" class="form-control" value="{{ old('prodi') }}">
            </div>
        </div>

        <h6 class="mt-3">Anggota Kelompok</h6>
        <div id="anggota-wrapper">
            <div class="row anggota-row mb-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="anggota[0][nama]" class="form-control input-nama" placeholder="Nama" pattern="[A-Za-z\s.'-]+" title="Nama hanya boleh berisi huruf" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="anggota[0][nim]" class="form-control input-nim" placeholder="NIM" inputmode="numeric" pattern="[0-9]*" title="NIM hanya boleh berisi angka">
                </div>
                <div class="col-md-3">
                    <select name="anggota[0][jabatan]" class="form-select">
                        <option value="Ketua">Ketua</option>
                        <option value="Anggota">Anggota</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-anggota">Hapus</button>
                </div>
            </div>
        </div>
        <button type="button" id="tambah-anggota" class="btn btn-sm btn-outline-secondary mb-3">+ Tambah Anggota</button>

        <div class="mb-3">
            <label class="form-label">Berkas Persyaratan (PDF, maks 5MB)</label>
            <input type="file" name="berkas" class="form-control" accept="application/pdf" required>
        </div>

        <button class="btn btn-primary">Daftar &amp; Masuk Antrean</button>
    </form>
@else
    <h4 class="mb-3">Unggah Ulang Berkas</h4>
    <p class="text-muted">Catatan revisi dari petugas: {{ $kelompok->catatan_revisi }}</p>
    <form method="POST" action="{{ route('peserta.kelompok.store-upload') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Berkas Baru (PDF, maks 5MB)</label>
            <input type="file" name="berkas" class="form-control" accept="application/pdf" required>
        </div>
        <button class="btn btn-danger">Unggah &amp; Masuk Antrean Kembali</button>
    </form>
@endif
</div>
@endsection

@push('scripts')
<script>
let idx = 1;

document.getElementById('tambah-anggota')?.addEventListener('click', () => {
    const wrapper = document.getElementById('anggota-wrapper');
    const row = document.createElement('div');
    row.className = 'row anggota-row mb-2 align-items-center';
    row.innerHTML = `
        <div class="col-md-4">
            <input type="text" name="anggota[${idx}][nama]" class="form-control input-nama" placeholder="Nama" pattern="[A-Za-z\\s.'-]+" title="Nama hanya boleh berisi huruf" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="anggota[${idx}][nim]" class="form-control input-nim" placeholder="NIM" inputmode="numeric" pattern="[0-9]*" title="NIM hanya boleh berisi angka">
        </div>
        <div class="col-md-3">
            <select name="anggota[${idx}][jabatan]" class="form-select">
                <option value="Anggota">Anggota</option>
            </select>
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-anggota">Hapus</button>
        </div>`;
    wrapper.appendChild(row);
    idx++;
});

// Hapus baris anggota (pakai event delegation karena baris baru dibuat dinamis)
document.getElementById('anggota-wrapper')?.addEventListener('click', (e) => {
    if (e.target.classList.contains('btn-hapus-anggota')) {
        const rows = document.querySelectorAll('.anggota-row');
        if (rows.length <= 1) {
            alert('Minimal harus ada 1 anggota kelompok.');
            return;
        }
        e.target.closest('.anggota-row').remove();
    }
});

// Filter input real-time: NIM hanya angka, Nama tidak boleh ada angka
document.getElementById('anggota-wrapper')?.addEventListener('input', (e) => {
    if (e.target.classList.contains('input-nim')) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    }
    if (e.target.classList.contains('input-nama')) {
        e.target.value = e.target.value.replace(/[0-9]/g, '');
    }
});
</script>
@endpush