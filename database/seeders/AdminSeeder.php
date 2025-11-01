<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]);
        }

        // Buat user dengan role petugas
        if (!User::where('email', 'petugas@example.com')->exists()) {
            User::create([
                'name' => 'Petugas Loket',
                'email' => 'petugas@example.com',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas'
            ]);
        }
    }
}
