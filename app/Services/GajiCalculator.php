<?php

namespace App\Services;

use App\Models\Gaji;
use App\Models\User;
use Carbon\Carbon;

class GajiCalculator
{
    public function calculate(User $guru, string $periode, float $jamMengajar): array
    {
        $komponen = $guru->komponenGaji;
        $absensi = $guru->absensi()
            ->where('tanggal', 'like', $periode . '%')
            ->count();

        if ($absensi === 0) {
            throw new \RuntimeException('Gaji hanya dapat dihitung jika guru sudah melakukan absensi.');
        }

        $honorPerJam = $komponen?->honor_per_jam ?? 0;
        $transport = $komponen?->transport ?? 0;
        $bpjs = $komponen?->bpjs ?? 0;
        $potonganLain = $komponen?->potongan_lain ?? 0;

        $totalHonor = round($jamMengajar * $honorPerJam, 2);
        $totalTunjangan = round($transport + $bpjs, 2);
        $totalPotongan = round($potonganLain, 2);
        $totalGaji = round($totalHonor + $totalTunjangan - $totalPotongan, 2);

        return [
            'user_id' => $guru->id,
            'periode' => $periode,
            'jam_mengajar' => $jamMengajar,
            'honor_per_jam' => $honorPerJam,
            'total_honor' => $totalHonor,
            'total_tunjangan' => $totalTunjangan,
            'total_potongan' => $totalPotongan,
            'total_gaji' => $totalGaji,
            'kehadiran' => $absensi,
            'detail' => [
                'absensi' => $absensi,
                'honor' => $totalHonor,
                'transport' => $transport,
                'bpjs' => $bpjs,
                'potongan_lain' => $potonganLain,
            ],
        ];
    }

    public function store(User $guru, string $periode, float $jamMengajar): Gaji
    {
        $payload = $this->calculate($guru, $periode, $jamMengajar);

        return Gaji::updateOrCreate(
            ['user_id' => $guru->id, 'periode' => $periode],
            $payload
        );
    }
}
