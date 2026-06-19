<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gaji', function (Blueprint $table) {
            if (! Schema::hasColumn('gaji', 'bulan')) {
                $table->string('bulan', 7)->after('user_id')->nullable(false)->default(date('Y-m'));
                $table->unique(['user_id', 'bulan']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('gaji', function (Blueprint $table) {
            if (Schema::hasColumn('gaji', 'bulan')) {
                try {
                    $table->dropUnique(['user_id', 'bulan']);
                } catch (\Throwable $e) {
                }
                $table->dropColumn('bulan');
            }
        });
    }
};
