<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Gaji - {{ $bulan }}</title>
    <style>
        body { font-family: DejaVu Sans, Helvetica, Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Gaji</h2>
        <div>Bulan: {{ $bulan }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Guru</th>
                <th>Kehadiran</th>
                <th>Total Honor</th>
                <th>Tunjangan</th>
                <th>Potongan</th>
                <th>Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gajis as $i => $gaji)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $gaji->guru->name ?? '-' }}</td>
                    <td class="right">{{ $gaji->kehadiran }}</td>
                    <td class="right">Rp {{ number_format($gaji->total_honor,0,',','.') }}</td>
                    <td class="right">Rp {{ number_format($gaji->total_tunjangan,0,',','.') }}</td>
                    <td class="right">Rp {{ number_format($gaji->total_potongan,0,',','.') }}</td>
                    <td class="right">Rp {{ number_format($gaji->total_gaji,0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:18px; font-size:11px;">Dicetak pada: {{ \Carbon\Carbon::now()->toDateTimeString() }}</div>
</body>
</html>