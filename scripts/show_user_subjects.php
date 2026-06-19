<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$u = User::where('email', 'naruto@example.test')->first();
if (! $u) {
    echo "User not found\n";
    exit;
}

echo "User ID: {$u->id}\n";
foreach ($u->subjects as $s) {
    echo "{$s->id} - {$s->name}\n";
}
