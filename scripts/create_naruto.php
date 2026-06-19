<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\KomponenGaji;
use Illuminate\Support\Facades\Hash;

$email = 'naruto@example.test';
$nip = 'NARUTO001';

$existing = User::where('email', $email)->first();
if ($existing) {
    echo "User already exists: ID {$existing->id}\n";
    $user = $existing;
} else {
    $user = User::create([
        'name' => 'naruto',
        'nip' => $nip,
        'matapelajaran' => '',
        'status' => '',
        'role' => 'guru',
        'email' => $email,
        'password' => Hash::make('secret'),
    ]);
    echo "Created user naruto ID: {$user->id}\n";
}

$kom = KomponenGaji::where('user_id', $user->id)->first();
if ($kom) {
    echo "KomponenGaji already exists for user {$user->id}\n";
} else {
    $kom = KomponenGaji::create([
        'user_id' => $user->id,
        'honor_per_jam' => '35000.00',
        'tunjangan' => '15000.00',
        'transport' => '5000.00',
        'bpjs' => '37000.00',
        'potongan_lain' => '2000.00',
        'honor_per_hadir' => 0,
    ]);
    echo "Created KomponenGaji ID: {$kom->id} for user {$user->id}\n";
}

$kom = KomponenGaji::where('user_id', $user->id)->first();
echo "KomponenGaji summary:\n";
echo "honor_per_jam: {$kom->honor_per_jam}\n";
echo "tunjangan: {$kom->tunjangan}\n";
echo "transport: {$kom->transport}\n";
echo "bpjs: {$kom->bpjs}\n";
echo "potongan_lain: {$kom->potongan_lain}\n";

// Optionally run calculation
// Ensure there's at least one absensi for today for this user so calculation can run
use App\Models\Absensi;
use Carbon\Carbon;

$today = Carbon::now(config('app.timezone'))->toDateString();
$existingAbs = Absensi::where('user_id', $user->id)->whereDate('tanggal', $today)->first();
if (! $existingAbs) {
    // try to find a subject id
    $subjectId = null;
    if (class_exists('App\\Models\\Subject')) {
        $sub = App\Models\Subject::first();
        if ($sub) $subjectId = $sub->id;
    }
    $abs = Absensi::create([
        'user_id' => $user->id,
        'tanggal' => $today,
        'jam_masuk' => Carbon::now()->format('H:i:s'),
        'subject_id' => $subjectId,
        'status' => 'hadir',
        'alasan' => null,
        'latitude' => 0,
        'longitude' => 0,
        'approved' => true,
    ]);
    echo "Created absensi ID: {$abs->id}\n";
} else {
    echo "Existing absensi found ID: {$existingAbs->id}\n";
}

$svc = new App\Services\GajiCalculator();
$gaji = $svc->store($user, 0.0, null);

echo "Calculated gaji ID: {$gaji->id}, total_gaji: {$gaji->total_gaji}\n";

