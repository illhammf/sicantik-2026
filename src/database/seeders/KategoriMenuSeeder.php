<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriMenu;

class KategoriMenuSeeder extends Seeder
{
    public function run(): void
    {
        KategoriMenu::insert([
            [
                'nama_kategori' => 'Nasi Box',
                'deskripsi' => 'Paket nasi box untuk berbagai acara',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Prasmanan',
                'deskripsi' => 'Paket prasmanan untuk acara besar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Snack Box',
                'deskripsi' => 'Paket snack dan makanan ringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}