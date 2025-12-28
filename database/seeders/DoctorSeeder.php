<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('app/doctors.csv');

        // Cek file ada atau tidak
        if (!File::exists($path)) {
            $this->command->error('File doctors.csv tidak ditemukan!');
            return;
        }

        // Baca file CSV pakai delimiter ;
        $rows = array_map(
            fn ($line) => str_getcsv($line, ';'),
            file($path)
        );

        // Hapus header (baris pertama)
        array_shift($rows);

        foreach ($rows as $row) {

            // Pastikan kolom lengkap
            if (count($row) < 3) {
                continue;
            }

            [$name, $email, $nim] = $row;

            User::updateOrCreate(
                ['email' => trim($email)], // kalau email sudah ada → update
                [
                    'name'     => trim($name),
                    'password' => Hash::make(trim($nim)), // password = NIM
                    'role'     => 'doctor',
                ]
            );
        }

        $this->command->info('Seeder Doctor berhasil dijalankan.');
    }
}
