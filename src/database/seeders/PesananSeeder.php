<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        Pesanan::insert([
            [
                'pelanggan_id' => 1,
                'tanggal_pesanan' => now(),
                'tanggal_acara' => now()->addDays(5),
                'alamat_pengiriman' => 'Universitas Esa Unggul Tangerang',
                'total_harga' => 250000,
                'status' => 'Diproses',
                'catatan' => 'Acara rapat organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}