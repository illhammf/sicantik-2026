<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::insert([
            [
                'kategori_menu_id' => 1,
                'nama_menu' => 'Nasi Box Ayam Bakar',
                'harga' => 25000,
                'deskripsi' => 'Ayam bakar, nasi, sambal dan lalapan',
                'gambar' => null,
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_menu_id' => 2,
                'nama_menu' => 'Prasmanan Silver',
                'harga' => 45000,
                'deskripsi' => 'Paket prasmanan ekonomis',
                'gambar' => null,
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_menu_id' => 3,
                'nama_menu' => 'Snack Box Premium',
                'harga' => 15000,
                'deskripsi' => 'Snack box isi 3 item',
                'gambar' => null,
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}