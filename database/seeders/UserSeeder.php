<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@fk.unisa.ac.id'], // cari berdasarkan email
            [
                'name' => 'Admin FK UNISA',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Dokter
        User::updateOrCreate(
            ['email' => 'dokter@fk.unisa.ac.id'],
            [
                'name' => 'Dokter FK UNISA',
                'password' => Hash::make('dokter123'),
                'role' => 'doctor',
            ]
        );
    }
}
