<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\StoreAbsensiRequest;
use App\Models\Absensi;
use App\Models\AbsensiSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        $setting = AbsensiSetting::where('active', true)->latest()->first();
        $riwayat = $guru->absensi()->latest()->paginate(15);

        return view('guru.absensi.index', compact('guru', 'setting', 'riwayat'));
    }

    public function store(StoreAbsensiRequest $request)
    {
        $setting = AbsensiSetting::where('active', true)->latest()->first();

        if (! $setting) {
            return back()->withErrors(['absensi' => 'Pengaturan absensi belum diaktifkan oleh admin.']);
        }

        $currentTime = Carbon::now()->format('H:i');

        if ($currentTime < $setting->jam_mulai || $currentTime > $setting->batas_absen) {
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

        if ($guru->absensi()->whereDate('tanggal', Carbon::today())->exists()) {
            return back()->withErrors(['absensi' => 'Anda sudah melakukan absensi hari ini.']);
        }

        Absensi::create([
            'user_id' => $guru->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_masuk' => Carbon::now()->format('H:i'),
            'status' => $request->status,
            'alasan' => $request->alasan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'approved' => true,
        ]);

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
