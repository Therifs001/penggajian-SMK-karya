<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            if (! Schema::hasColumn('subjects', 'jam')) {
                $table->decimal('jam', 5, 2)->default(0)->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            if (Schema::hasColumn('subjects', 'jam')) {
                $table->dropColumn('jam');
            }
        });
    }
};
