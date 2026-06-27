<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\StoreAbsensiRequest;
use App\Models\Absensi;
use App\Models\AbsensiSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\GajiCalculator;

class AbsensiController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        $setting = AbsensiSetting::where('active', true)->latest()->first();
        $riwayat = $guru->absensi()->latest()->paginate(15);
        $subjects = \App\Models\Subject::orderBy('name')->get();

        return view('guru.absensi.index', compact('guru', 'setting', 'riwayat', 'subjects'));
    }

    public function store(StoreAbsensiRequest $request)
    {
        $setting = AbsensiSetting::where('active', true)->latest()->first();

        if (!$setting) {
            return back()->withErrors(['absensi' => 'Pengaturan absensi belum diaktifkan oleh admin.']);
        }

        // compare using Carbon instances on the same date to avoid string/object comparison issues
        $appTz = config('app.timezone') ?: 'UTC';
        $now = Carbon::now($appTz);
        try {
            $start = Carbon::parse((string) $setting->jam_mulai, $appTz)->setDate($now->year, $now->month, $now->day)->startOfMinute();
            $deadline = Carbon::parse((string) $setting->batas_absen, $appTz)->setDate($now->year, $now->month, $now->day)->endOfMinute();
        } catch (\Throwable $e) {
            return back()->withErrors(['absensi' => 'Konfigurasi waktu absensi tidak valid.']);
        }

        // Diagnostic log to help debugging time comparisons
        Log::info('absensi:check', [
            'now' => $now->toDateTimeString(),
            'app_timezone' => $appTz,
            'setting_jam_mulai' => (string) $setting->jam_mulai,
            'setting_batas_absen' => (string) $setting->batas_absen,
            'parsed_start' => $start->toDateTimeString(),
            'parsed_deadline' => $deadline->toDateTimeString(),
            'setting_tanggal' => (string) $setting->tanggal,
            'server_timezone' => date_default_timezone_get(),
        ]);

        // jika pengaturan memiliki tanggal khusus, pastikan berlaku hari ini
        if ($setting->tanggal && !Carbon::parse($setting->tanggal)->isSameDay($now)) {
            return back()->withErrors(['absensi' => 'Pengaturan absensi ini tidak berlaku pada hari ini.']);
        }

        if ($now->lt($start) || $now->gt($deadline)) {
            return back()->withErrors(['absensi' => 'Anda tidak berada di dalam waktu absensi yang ditentukan.']);
        }

        $distance = $this->calculateDistance(
            $setting->latitude,
            $setting->longitude,
            $request->latitude,
            $request->longitude
        );

        if ($distance > $setting->radius_meter) {
            return back()->withErrors(['absensi' => 'Lokasi Anda berada di luar radius absensi yang diperbolehkan.']);
        }

        $guru = Auth::user();

        $selectedSubjects = array_filter((array) $request->input('subjects', []));

        // If no specific subjects selected, keep legacy behavior: one attendance per day
        if (empty($selectedSubjects)) {
            if ($guru->absensi()->whereDate('tanggal', Carbon::today())->exists()) {
                return back()->withErrors(['absensi' => 'Anda sudah melakukan absensi hari ini.']);
            }

            Absensi::create([
                'user_id' => $guru->id,
                'tanggal' => $now->toDateString(),
                'jam_masuk' => $now->format('H:i'),
                'subject_id' => null,
                'status' => $request->status,
                'alasan' => $request->alasan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'approved' => true,
            ]);

            $jamMengajarForCalc = 0.0;
        } else {
            // If subjects selected, create or reuse a single Absensi record for today,
            // and compute total jam taught from selected subjects to feed the payroll calculator.
            $absensi = $guru->absensi()
                ->whereDate('tanggal', Carbon::today())
                ->first();

            if (!$absensi) {

                $absensi = Absensi::create([
                    'user_id' => $guru->id,
                    'tanggal' => $now->toDateString(),
                    'jam_masuk' => $now->format('H:i'),
                    'subject_id' => $selectedSubjects[0] ?? null,
                    'status' => $request->status,
                    'alasan' => $request->alasan,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'approved' => true,
                ]);

            } else {

                $absensi->update([
                    'subject_id' => $selectedSubjects[0] ?? null,
                ]);

            }

            // compute total jam from selected subjects
            $subjectIds = array_map('intval', $selectedSubjects);
            $totalJam = \App\Models\Subject::whereIn('id', $subjectIds)->sum('jam');
            $jamMengajarForCalc = (float) $totalJam;
        }

        // After a successful absensi, attempt to (re)calculate salary for this guru.
        try {
            $calculator = app(GajiCalculator::class);
            // If we computed a total jam from selected subjects, pass it to the calculator
            $gaji = $calculator->store($guru, $jamMengajarForCalc ?? 0.0, null);
            Log::info('gaji:calculated_after_absensi', ['gaji_id' => $gaji->id, 'guru_id' => $guru->id, 'bulan' => $gaji->bulan]);
        } catch (\Throwable $e) {
            // Log and create admin notification but don't block the attendance flow
            Log::error('gaji:calculate_after_absensi_failed', ['error' => $e->getMessage(), 'guru_id' => $guru->id]);
            try {
                \App\Models\AdminNotification::create([
                    'type' => 'gaji_calculation_failed',
                    'data' => [
                        'guru_id' => $guru->id,
                        'message' => $e->getMessage(),
                    ],
                ]);
            } catch (\Throwable $ex) {
                Log::error('admin_notification:create_failed', ['error' => $ex->getMessage()]);
            }
        }

        return redirect()->route('guru.absensi.index')->with('success', 'Absensi berhasil disimpan.');
    }

    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000;
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);
        $a = sin($deltaLat / 2) * sin($deltaLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
