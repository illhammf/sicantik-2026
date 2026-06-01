<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            KategoriMenuSeeder::class,
            MenuSeeder::class,
            PelangganSeeder::class,
            PesananSeeder::class,
            DetailPesananSeeder::class,
            PembayaranSeeder::class,
            UlasanSeeder::class,
            PesanKontakSeeder::class,
            PengaturanWebsiteSeeder::class,
        ]);
    }
}
