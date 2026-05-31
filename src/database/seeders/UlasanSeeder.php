<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ulasan;

class UlasanSeeder extends Seeder
{
    public function run(): void
    {
        Ulasan::insert([
            [
                'pelanggan_id' => 1,
                'pesanan_id' => 1,
                'rating' => 5,
                'komentar' => 'Makanannya enak dan pengirimannya tepat waktu.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}