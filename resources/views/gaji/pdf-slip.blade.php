<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji {{ $gaji->guru->name }} - {{ $gaji->periode }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #222; }
        .header { text-align: center; margin-bottom: 24px; }
        .box { border: 1px solid #ddd; padding: 16px; margin-bottom: 16px; }
        .box h2 { margin: 0 0 8px; font-size: 18px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Slip Gaji Guru</h1>
        <p>Periode: {{ $gaji->periode }}</p>
    </div>

    <div class="box">
        <h2>Data Guru</h2>
        <p><strong>Nama:</strong> {{ $gaji->guru->name }}</p>
        <p><strong>Email:</strong> {{ $gaji->guru->email }}</p>
    </div>

    <div class="box">
        <h2>Rincian Gaji</h2>
        <table class="table">
            <tr>
                <th>Komponen</th>
                <th>Nominal</th>
            </tr>
            <tr>
                <td>Total Kehadiran</td>
                <td>{{ $gaji->kehadiran }}</td>
            </tr>
            <tr>
                <td>Jam Mengajar</td>
                <td>{{ $gaji->jam_mengajar }}</td>
            </tr>
            <tr>
                <td>Honor per Jam</td>
                <td>Rp {{ number_format($gaji->honor_per_jam, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Honor</td>
                <td>Rp {{ number_format($gaji->total_honor, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Tunjangan</td>
                <td>Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Potongan</td>
                <td>Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td>Total Gaji</td>
                <td>Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
