<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #222; }
    .header { text-align: center; margin-bottom: 20px; }
    .header h2 { margin: 0; }
    .header p { margin: 4px 0 0; color: #555; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    table, th, td { border: 1px solid #999; padding: 6px 8px; vertical-align: top; }
    .label { font-weight: bold; width: 32%; background: #f0f0f0; }
    .footer { margin-top: 30px; font-size: 10px; color: #555; text-align: center; }
</style>
</head>
<body>
    <div class="header">
        <h2>E-RECEIPT PENDAFTARAN PITCHING KEWIRAUSAHAAN</h2>
        <p>Biro Pelayanan Akademik &mdash; Universitas Telkom</p>
    </div>

    <table>
        <tr>
            <td class="label">Nomor Kelompok</td>
            <td>{{ $kelompok->nomor_kelompok }}</td>
        </tr>
        <tr>
            <td class="label">Nama Kelompok</td>
            <td>{{ $kelompok->nama_kelompok }}</td>
        </tr>
        <tr>
            <td class="label">Nama Usaha</td>
            <td>{{ $kelompok->nama_usaha ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Program Studi</td>
            <td>{{ $kelompok->prodi ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jadwal Pitching</td>
            <td>
                {{ $kelompok->jadwal?->tanggal?->translatedFormat('d F Y') }},
                {{ \Illuminate\Support\Carbon::parse($kelompok->jadwal?->jam_mulai)->format('H:i') }} -
                {{ \Illuminate\Support\Carbon::parse($kelompok->jadwal?->jam_selesai)->format('H:i') }}
                ({{ $kelompok->jadwal?->ruangan }})
            </td>
        </tr>
        <tr>
            <td class="label">Anggota Kelompok</td>
            <td>
                @foreach($kelompok->anggota as $a)
                    {{ $a->nama }} ({{ $a->jabatan }}){{ $a->nim ? ' - '.$a->nim : '' }}<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td class="label">Tanggal Konfirmasi</td>
            <td>{{ optional($kelompok->dikonfirmasi_at)->translatedFormat('d F Y H:i') }}</td>
        </tr>
    </table>

    <p class="footer">Dokumen ini diterbitkan secara otomatis oleh sistem dan sah tanpa tanda tangan basah.</p>
</body>
</html>