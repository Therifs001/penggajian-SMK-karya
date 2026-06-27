<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('subjects', function ($table) {
            $table->decimal('honor_per_jam', 12, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('subjects', function ($table) {
            $table->dropColumn('honor_per_jam');
        });
    }
};
