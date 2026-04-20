<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komponen_gaji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('honor_per_jam', 12, 2)->default(0);
            $table->decimal('transport', 12, 2)->default(0);
            $table->decimal('bpjs', 12, 2)->default(0);
            $table->decimal('potongan_lain', 12, 2)->default(0);
            $table->string('periode')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komponen_gaji');
    }
};
