<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesanKontak;

class PesanKontakSeeder extends Seeder
{
    public function run(): void
    {
        PesanKontak::insert([
            [
                'nama' => 'Andi',
                'email' => 'andi@gmail.com',
                'subjek' => 'Informasi Paket Catering',
                'pesan' => 'Apakah tersedia paket catering untuk 100 orang?',
                'status' => 'Belum Dibaca',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}