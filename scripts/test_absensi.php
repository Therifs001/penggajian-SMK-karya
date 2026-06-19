<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\AbsensiSetting;
use App\Models\Absensi;
use App\Services\GajiCalculator;
use Carbon\Carbon;

echo "Starting test absensi script...\n";

$tz = config('app.timezone') ?: 'UTC';
$now = Carbon::now($tz);

$guru = User::where('role', 'guru')->first();
if (! $guru) {
    echo "No guru user found. Aborting.\n";
    exit(1);
}

$setting = AbsensiSetting::where('active', true)->latest()->first();
if (! $setting) {
    echo "No active AbsensiSetting found. Aborting.\n";
    exit(1);
}

// create absensi with setting location and subject if available
$subjectId = null;
if (class_exists('App\\Models\\Subject')) {
    $sub = App\Models\Subject::first();
    if ($sub) $subjectId = $sub->id;
}

$existing = Absensi::where('user_id', $guru->id)->whereDate('tanggal', $now->toDateString())->first();
if ($existing) {
    $abs = $existing;
    echo "Absensi already exists: ID {$abs->id} for guru_id={$guru->id}\n";
} else {
    $abs = Absensi::create([
        'user_id' => $guru->id,
        'tanggal' => $now->toDateString(),
        'jam_masuk' => $now->format('H:i'),
        'subject_id' => $subjectId,
        'status' => 'hadir',
        'alasan' => null,
        'latitude' => $setting->latitude ?? 0,
        'longitude' => $setting->longitude ?? 0,
        'approved' => true,
    ]);

    echo "Created Absensi ID: {$abs->id} for guru_id={$guru->id}\n";
}

try {
    $calculator = new GajiCalculator();
    $gaji = $calculator->store($guru, 0.0, null);
    echo "Gaji calculated: id={$gaji->id}, bulan={$gaji->bulan}, total_gaji={$gaji->total_gaji}\n";
} catch (\Throwable $e) {
    echo "Gaji calculation failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Test completed.\n";
