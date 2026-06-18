<div class="mb-2">
    <label class="form-label">Tanggal</label>
    <input type="date" name="tanggal" class="form-control" value="{{ isset($jadwal) ? $jadwal->tanggal->format('Y-m-d') : '' }}" required>
</div>
<div class="row">
    <div class="col-6 mb-2">
        <label class="form-label">Jam Mulai</label>
        <input type="time" name="jam_mulai" class="form-control" value="{{ isset($jadwal) ? \Illuminate\Support\Carbon::parse($jadwal->jam_mulai)->format('H:i') : '' }}" required>
    </div>
    <div class="col-6 mb-2">
        <label class="form-label">Jam Selesai</label>
        <input type="time" name="jam_selesai" class="form-control" value="{{ isset($jadwal) ? \Illuminate\Support\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '' }}" required>
    </div>
</div>
<div class="mb-2">
    <label class="form-label">Ruangan</label>
    <input type="text" name="ruangan" class="form-control" value="{{ $jadwal->ruangan ?? '' }}">
</div>
<div class="mb-2">
    <label class="form-label">Kuota</label>
    <input type="number" name="kuota" class="form-control" min="1" value="{{ $jadwal->kuota ?? 3 }}" required>
</div>