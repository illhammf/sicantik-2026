<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailPesanan;

class DetailPesananSeeder extends Seeder
{
    public function run(): void
    {
        DetailPesanan::insert([
            [
                'pesanan_id' => 1,
                'menu_id' => 1,
                'jumlah' => 10,
                'harga' => 25000,
                'subtotal' => 250000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}