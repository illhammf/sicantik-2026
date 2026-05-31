<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembayaran;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        Pembayaran::insert([
            [
                'pesanan_id' => 1,
                'metode_pembayaran' => 'QRIS',
                'jumlah_bayar' => 250000,
                'bukti_pembayaran' => null,
                'status' => 'Lunas',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}