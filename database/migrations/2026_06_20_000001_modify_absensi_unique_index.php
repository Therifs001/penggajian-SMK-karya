<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('absensi', function (Blueprint $table) {

        // sementara nonaktifkan dulu
        // if (Schema::hasColumn('absensi', 'user_id') && Schema::hasColumn('absensi', 'tanggal')) {
        //     try {
        //         $table->dropUnique('absensi_user_id_tanggal_unique');
        //     } catch (\Throwable $e) {
        //         // ignore if index does not exist
        //     }
        // }

        if (Schema::hasColumn('absensi', 'subject_id')) {
            $table->unique(
                ['user_id', 'tanggal', 'subject_id'],
                'absensi_user_id_tanggal_subject_id_unique'
            );
        }
    });
}

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            // try {
            //     $table->dropUnique('absensi_user_id_tanggal_subject_id_unique');
            // } catch (\Throwable $e) {
            //     // ignore
            // }

            // restore original unique if columns still exist
            if (Schema::hasColumn('absensi', 'user_id') && Schema::hasColumn('absensi', 'tanggal')) {
                $table->unique(['user_id', 'tanggal'], 'absensi_user_id_tanggal_unique');
            }
        });
    }
};
