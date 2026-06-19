<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('komponen_gaji', function (Blueprint $table) {
            if (Schema::hasColumn('komponen_gaji', 'periode')) {
                $table->dropColumn('periode');
            }
        });

        Schema::table('gaji', function (Blueprint $table) {
            if (Schema::hasColumn('gaji', 'periode')) {
                $table->dropColumn('periode');
            }
        });
    }

    public function down(): void
    {
        Schema::table('komponen_gaji', function (Blueprint $table) {
            if (!Schema::hasColumn('komponen_gaji', 'periode')) {
                $table->string('periode')->nullable()->after('potongan_lain');
            }
        });

        Schema::table('gaji', function (Blueprint $table) {
            if (!Schema::hasColumn('gaji', 'periode')) {
                $table->string('periode')->after('user_id');
                $table->unique(['user_id', 'periode']);
            }
        });
    }
};
