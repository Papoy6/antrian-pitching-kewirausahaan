<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 28px; }

    body {
        margin: 0;
        font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
        font-size: 12px;
        color: #172033;
        background: #ffffff;
    }

    .receipt {
        width: 100%;
        border: 1px solid #d8e3f0;
        background: #ffffff;
    }

    .top-line {
        height: 14px;
        background: #1d4ed8;
        border-bottom: 7px solid #0f766e;
    }

    .inner { padding: 24px; }

    .header {
        position: relative;
        margin-bottom: 22px;
        padding: 6px 132px 18px;
        border-bottom: 1px solid #e5edf7;
        text-align: center;
    }

    .title {
        margin: 0;
        color: #0f172a;
        font-size: 22px;
        line-height: 1.25;
        font-weight: bold;
    }

    .subtitle {
        margin: 6px 0 0;
        color: #667085;
        font-size: 12px;
    }

    .pill {
        position: absolute;
        top: 8px;
        right: 0;
        display: inline-block;
        padding: 7px 11px;
        color: #065f46;
        background: #d1fae5;
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: .6px;
        white-space: nowrap;
    }

    .hero {
        margin-top: 16px;
        padding: 16px;
        border: 1px solid #c7d7fe;
        background: #eff6ff;
    }

    .hero-table,
    .summary-table,
    .detail-table,
    .signature-table {
        width: 100%;
        border-collapse: collapse;
    }

    .hero-table td,
    .summary-table td,
    .signature-table td {
        border: 0;
        vertical-align: top;
    }

    .small-label {
        color: #667085;
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: .6px;
    }

    .number {
        margin-top: 4px;
        color: #1d4ed8;
        font-size: 25px;
        font-weight: bold;
    }

    .business {
        margin-top: 7px;
        color: #172033;
        font-size: 13px;
    }

    .summary-table { margin-top: 14px; }

    .summary-table td {
        width: 33.33%;
        padding: 10px;
        border: 1px solid #d8e3f0;
        background: #f8fafc;
    }

    .summary-value {
        margin-top: 5px;
        color: #0f172a;
        font-size: 12px;
        font-weight: bold;
    }

    .section-title {
        margin: 18px 0 8px;
        color: #0f172a;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: .7px;
    }

    .detail-table { border: 1px solid #d8e3f0; }

    .detail-table td {
        padding: 9px 11px;
        border-bottom: 1px solid #e5edf7;
        vertical-align: top;
    }

    .detail-table tr:last-child td { border-bottom: 0; }

    .label {
        width: 31%;
        color: #344054;
        background: #f8fafc;
        font-weight: bold;
    }

    .member {
        padding: 8px 10px;
        margin-bottom: 6px;
        border: 1px solid #e5edf7;
        background: #fbfdff;
    }

    .role {
        color: #1d4ed8;
        font-weight: bold;
    }

    .legal {
        margin-top: 18px;
        padding: 12px;
        border-left: 5px solid #0f766e;
        color: #475467;
        background: #f0fdfa;
        font-size: 11px;
        line-height: 1.5;
    }

    .signature-table { margin-top: 26px; }

    .signature-box {
        width: 220px;
        margin-left: auto;
        padding-top: 11px;
        border-top: 1px solid #d8e3f0;
        text-align: center;
        color: #475467;
        font-size: 11px;
    }

    .signature-name {
        margin-top: 30px;
        color: #0f172a;
        font-weight: bold;
    }

    .footer {
        margin-top: 18px;
        padding-top: 10px;
        border-top: 1px solid #e5edf7;
        color: #667085;
        font-size: 10px;
        text-align: center;
    }
</style>
</head>
<body>
    <div class="receipt">
        <div class="top-line"></div>
        <div class="inner">
            <div class="header">
                <span class="pill">Terkonfirmasi</span>
                <h1 class="title">E-Receipt Pendaftaran Pitching Kewirausahaan</h1>
                <p class="subtitle">Biro Pelayanan Akademik &mdash; Universitas Telkom</p>
            </div>

            <div class="hero">
                <table class="hero-table">
                    <tr>
                        <td>
                            <div class="small-label">Nomor Kelompok</div>
                            <div class="number">{{ $kelompok->nomor_kelompok }}</div>
                            <div class="business">{{ $kelompok->nama_kelompok }} &middot; {{ $kelompok->nama_usaha ?? '-' }}</div>
                        </td>
                        <td style="width: 210px; text-align: right;">
                            <div class="small-label">Tanggal Konfirmasi</div>
                            <div class="summary-value">{{ optional($kelompok->dikonfirmasi_at)->translatedFormat('d F Y H:i') }}</div>
                        </td>
                    </tr>
                </table>
            </div>

            <table class="summary-table">
                <tr>
                    <td>
                        <div class="small-label">Program Studi</div>
                        <div class="summary-value">{{ $kelompok->prodi ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="small-label">Tanggal Pitching</div>
                        <div class="summary-value">{{ $kelompok->jadwal?->tanggal?->translatedFormat('d F Y') }}</div>
                    </td>
                    <td>
                        <div class="small-label">Ruangan</div>
                        <div class="summary-value">{{ $kelompok->jadwal?->ruangan }}</div>
                    </td>
                </tr>
            </table>

            <div class="section-title">Detail Pendaftaran</div>
            <table class="detail-table">
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
            </table>

            <div class="section-title">Anggota Kelompok</div>
            @foreach($kelompok->anggota as $a)
                <div class="member">
                    <strong>{{ $a->nama }}</strong>
                    <span class="role">({{ $a->jabatan }})</span>
                    {{ $a->nim ? ' - '.$a->nim : '' }}
                </div>
            @endforeach

            <div class="legal">
                Dokumen ini diterbitkan otomatis oleh sistem Antrian Pitching Kewirausahaan dan sah tanpa tanda tangan basah.
                E-receipt ini menjadi bukti bahwa kelompok telah dikonfirmasi untuk mengikuti jadwal pitching yang tercantum.
            </div>

            <table class="signature-table">
                <tr>
                    <td></td>
                    <td style="width: 240px;">
                        <div class="signature-box">
                            Biro Pelayanan Akademik
                            <div class="signature-name">Universitas Telkom</div>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="footer">
                Dicetak otomatis melalui sistem pada {{ now()->translatedFormat('d F Y H:i') }}.
            </div>
        </div>
    </div>
</body>
</html>
