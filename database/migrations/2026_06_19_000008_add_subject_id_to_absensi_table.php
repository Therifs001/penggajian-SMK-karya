<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            if (! Schema::hasColumn('absensi', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->after('user_id');
                $table->foreign('subject_id')->references('id')->on('subjects')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            if (Schema::hasColumn('absensi', 'subject_id')) {
                $table->dropForeign([ 'subject_id' ]);
                $table->dropColumn('subject_id');
            }
        });
    }
};
