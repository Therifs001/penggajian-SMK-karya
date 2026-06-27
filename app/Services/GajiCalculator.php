<?php

namespace App\Services;

use App\Models\Gaji;
use App\Models\User;
use Carbon\Carbon;

class GajiCalculator
{
    public function calculate(User $guru, float $jamMengajar, ?int $manualKehadiran = null): array
    {
        $komponen = $guru->komponenGaji;
        $periode = now()->format('Y-m');
        $absensiQuery = $guru->absensi()->where('tanggal', 'like', $periode . '%')->with('subject');
        $absensiRecords = $absensiQuery->get();
        $absensiCount = $manualKehadiran ?? $absensiRecords->count();

        if ($absensiCount === 0 && $manualKehadiran === null) {
            throw new \RuntimeException('Gaji hanya dapat dihitung jika guru sudah melakukan absensi.');
        }

        $honorPerJam = $komponen?->honor_per_jam ?? 0;
        $honorPerHadir = $komponen?->honor_per_hadir ?? 0;
        $transport = $komponen?->transport ?? 0;
        $bpjs = $komponen?->bpjs ?? 0;
        $potonganLain = $komponen?->potongan_lain ?? 0;
        if ($honorPerHadir > 0) {

            $totalHonor = round($absensiCount * $honorPerHadir, 2);
            $jamMengajarUsed = $jamMengajar;

        } else {

            $totalHours = $absensiRecords->reduce(function ($carry, $rec) {
                if (!$rec->subject) {
                    return $carry;
                }

                return $carry + (float) ($rec->subject->jam ?? 0);
            }, 0);

            $totalHonor = $absensiRecords->reduce(function ($carry, $rec) use ($honorPerJam) {
                if (!$rec->subject) {
                    return $carry;
                }

                $jam = (float) ($rec->subject->jam ?? 0);

                return $carry + ($jam * $honorPerJam);
            }, 0);

            $totalHonor = round($totalHonor, 2);

            $jamMengajarUsed = $totalHours;

        }
        // Tunjangan: transport (and other monthly allowances if added later)
        $totalTunjangan = round($transport * $absensiCount, 2);
        // Potongan: BPJS + potongan lain
        $totalPotongan = round($bpjs + $potonganLain, 2);
        // Final: honor + tunjangan - potongan
        $totalGaji = round($totalHonor + $totalTunjangan - $totalPotongan, 2);

        // prepare absensi detail array (dates and subjects)
        $absensiDetail = $absensiRecords->map(function ($rec) {
            return [
                'tanggal' => optional($rec->tanggal)->toDateString(),
                'jam_masuk' => $rec->jam_masuk ?? null,
                'subject' => $rec->relationLoaded('subject') && $rec->subject ? ['id' => $rec->subject->id, 'name' => $rec->subject->name, 'jam' => $rec->subject->jam] : null,
            ];
        })->toArray();

        return [
            'user_id' => $guru->id,
            'jam_mengajar' => $jamMengajarUsed ?? $jamMengajar,
            'honor_per_jam' => $honorPerJam,
            'total_honor' => $totalHonor,
            'total_tunjangan' => $totalTunjangan,
            'total_potongan' => $totalPotongan,
            'total_gaji' => $totalGaji,
            'kehadiran' => $absensiCount,
            'detail' => [
                'absensi' => $absensiDetail,
                'honor' => $totalHonor,
                'transport' => $transport,
                'bpjs' => $bpjs,
                'potongan_lain' => $potonganLain,
            ],
        ];
    }

    public function store(User $guru, float $jamMengajar, ?int $manualKehadiran = null, ?string $bulan = null, ?int $subjectId = null): Gaji
    {
        $periode = $bulan ?? now()->format('Y-m');
        $payload = $this->calculate($guru, $jamMengajar, $manualKehadiran);
        $payload['bulan'] = $periode;
        if ($subjectId) {
            $payload['subject_id'] = $subjectId;
        }

        return Gaji::updateOrCreate(
            ['user_id' => $guru->id, 'bulan' => $periode],
            $payload
        );
    }
}
