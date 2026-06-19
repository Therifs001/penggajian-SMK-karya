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
        // migrate existing users.matapelajaran (comma-separated names) into subject_user pivot
        if (!Schema::hasTable('users') || !Schema::hasTable('subjects') || !Schema::hasTable('subject_user')) {
            return;
        }

        $users = \App\Models\User::whereNotNull('matapelajaran')->where('matapelajaran', '!=', '')->get();
        foreach ($users as $user) {
            $names = preg_split('/[,;|\x2F\\\\]+/', $user->matapelajaran);
            $ids = [];
            foreach ($names as $name) {
                $name = trim($name);
                if ($name === '') continue;
                $subject = \App\Models\Subject::whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->first();
                if (! $subject) {
                    $subject = \App\Models\Subject::create(['name' => $name, 'jam' => 0]);
                }
                $ids[] = $subject->id;
            }
            if (! empty($ids)) {
                $user->subjects()->syncWithoutDetaching($ids);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // no-op
    }
};
