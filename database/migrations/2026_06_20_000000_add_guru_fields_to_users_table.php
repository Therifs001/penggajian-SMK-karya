<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'matapelajaran')) {
                $table->text('matapelajaran')->nullable()->after('nip');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('aktif')->after('matapelajaran');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('guru')->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nip')) {
                $table->dropColumn('nip');
            }
            if (Schema::hasColumn('users', 'matapelajaran')) {
                $table->dropColumn('matapelajaran');
            }
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
