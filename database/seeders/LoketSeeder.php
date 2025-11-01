<?php

namespace Database\Seeders;

use App\Models\Loket;
use Illuminate\Database\Seeder;

class LoketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokets = [
            [
                'nama_loket' => 'Loket 1',
                'deskripsi' => 'Pendaftaran Pasien Baru',
                'kode_prefix' => 'A',
            ],
            [
                'nama_loket' => 'Loket 2',
                'deskripsi' => 'Pendaftaran Pasien Lama',
                'kode_prefix' => 'B',
            ],
            [
                'nama_loket' => 'Loket 3',
                'deskripsi' => 'Farmasi',
                'kode_prefix' => 'C',
            ],
            [
                'nama_loket' => 'Loket 4',
                'deskripsi' => 'Kasir',
                'kode_prefix' => 'D',
            ],
        ];

        foreach ($lokets as $loket) {
            Loket::create($loket);
        }
    }
}