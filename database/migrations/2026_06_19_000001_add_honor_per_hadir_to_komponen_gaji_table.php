<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('komponen_gaji', function (Blueprint $table) {
            $table->decimal('honor_per_hadir', 12, 2)->default(0)->after('honor_per_jam');
        });
    }

    public function down(): void
    {
        Schema::table('komponen_gaji', function (Blueprint $table) {
            $table->dropColumn('honor_per_hadir');
        });
    }
};
