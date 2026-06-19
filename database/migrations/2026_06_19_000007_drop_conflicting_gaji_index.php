<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        try {
            DB::statement('ALTER TABLE `gaji` DROP INDEX `gaji_user_id_periode_unique`');
        } catch (\Throwable $e) {
            // ignore if index doesn't exist
        }
    }

    public function down(): void
    {
        // nothing to do
    }
};
