<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        h4 {
            text-align: center;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 6px;
        }

        .border {
            border: 1px solid #000;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }
    </style>

</head>

<body>

    <h2>SLIP GAJI GURU</h2>

    <h4>SMK KARYA PEMBANGUNAN</h4>

    <hr>

    <table>

        <tr>
            <td width="25%">Nama</td>
            <td>: {{ $gaji->guru->name }}</td>
        </tr>

        <tr>
            <td>NIP</td>
            <td>: {{ $gaji->guru->nip }}</td>
        </tr>

        <tr>
            <td>Bulan</td>
            <td>: {{ \Carbon\Carbon::parse($gaji->bulan . '-01')->translatedFormat('F Y') }}</td>
        </tr>

    </table>

    <br>

    <table class="border">

        <tr>
            <td class="border"><strong>Keterangan</strong></td>
            <td class="border right"><strong>Nominal</strong></td>
        </tr>

        <tr>
            <td class="border">Honor Mengajar</td>
            <td class="border right">
                Rp {{ number_format($gaji->total_honor, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="border">Transport</td>
            <td class="border right">
                Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="border">Potongan</td>
            <td class="border right">
                Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="border"><strong>Total Gaji</strong></td>
            <td class="border right">
                <strong>
                    Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}
                </strong>
            </td>
        </tr>

    </table>

    <br><br><br>

    <table>

        <tr>

            <td width="60%"></td>

            <td class="center">

                Bandung,
                {{ now()->translatedFormat('d F Y') }}

                <br><br><br><br>

                _____________________

                <br>

                Bendahara

            </td>

        </tr>

    </table>

</body>

</html>