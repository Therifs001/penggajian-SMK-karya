<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Gaji;

$g = Gaji::latest('id')->first();
if (! $g) {
    echo "No Gaji records found.\n";
    exit(0);
}

echo "Gaji ID: {$g->id}\n";
echo "User ID: {$g->user_id}\n";
echo "Bulan: {$g->bulan}\n";
echo "Jam Mengajar: {$g->jam_mengajar}\n";
echo "Honor per Jam: {$g->honor_per_jam}\n";
echo "Total Honor: {$g->total_honor}\n";
echo "Total Tunjangan: {$g->total_tunjangan}\n";
echo "Total Potongan: {$g->total_potongan}\n";
echo "Total Gaji: {$g->total_gaji}\n";
echo "Kehadiran: {$g->kehadiran}\n";
echo "Detail: " . json_encode($g->detail, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) . "\n";
