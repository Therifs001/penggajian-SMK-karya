<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gaji', function (Blueprint $table) {
            if (! Schema::hasColumn('gaji', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->after('bulan');
                $table->foreign('subject_id')->references('id')->on('subjects')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('gaji', function (Blueprint $table) {
            if (Schema::hasColumn('gaji', 'subject_id')) {
                try {
                    $table->dropForeign(['subject_id']);
                } catch (\Throwable $e) {
                }
                $table->dropColumn('subject_id');
            }
        });
    }
};
