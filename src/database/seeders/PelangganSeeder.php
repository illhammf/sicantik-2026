<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        Pelanggan::insert([
            [
                'nama' => 'Ilham Firmansyah',
                'email' => 'ilham@gmail.com',
                'no_hp' => '081234567890',
                'alamat' => 'Tangerang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'no_hp' => '081111111111',
                'alamat' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}