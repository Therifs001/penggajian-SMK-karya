<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'nip' => '123456',
            'matapelajaran' => 'Administrator',
            'status' => 'Aktif',
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        User::create([
            'name' => 'Guru Test',
            'nip' => '789012',
            'matapelajaran' => 'Matematika',
            'status' => 'Aktif',
            'role' => 'guru',
            'email' => 'guru@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
    }
}
