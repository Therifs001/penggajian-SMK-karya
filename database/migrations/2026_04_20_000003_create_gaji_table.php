<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gaji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('periode');
            $table->decimal('jam_mengajar', 8, 2)->default(0);
            $table->decimal('honor_per_jam', 12, 2)->default(0);
            $table->decimal('total_honor', 14, 2)->default(0);
            $table->decimal('total_tunjangan', 14, 2)->default(0);
            $table->decimal('total_potongan', 14, 2)->default(0);
            $table->decimal('total_gaji', 14, 2)->default(0);
            $table->unsignedInteger('kehadiran')->default(0);
            $table->json('detail')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gaji');
    }
};
