<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengaturanWebsite;

class PengaturanWebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PengaturanWebsite::create([
            'nama_website' => 'SiCantik Catering',

            'logo' => null,
            'favicon' => null,
            'gambar_hero' => null,

            'badge_hero' => 'Catering Lezat Untuk Setiap Acara',

            'judul_hero' => 'Solusi Catering Praktis, Enak, dan Terpercaya',

            'deskripsi_hero' => 'SiCantik Catering menyediakan berbagai pilihan nasi box, snack box, dan prasmanan untuk acara kampus, kantor, keluarga, seminar, hingga kegiatan organisasi dengan kualitas terbaik dan harga terjangkau.',

            'judul_kontak' => 'Butuh Catering untuk Acara Kamu?',

            'deskripsi_kontak' => 'Hubungi kami untuk konsultasi menu, jumlah pesanan, jadwal pengiriman, dan kebutuhan catering lainnya. Tim SiCantik siap membantu acara kamu menjadi lebih berkesan.',

            'alamat' => 'Tangerang, Banten, Indonesia',

            'no_hp' => '0895336900466',

            'email' => 'sicantikcatering@gmail.com',

            'instagram' => 'https://instagram.com/illhammf',

            'facebook' => 'https://facebook.com/amm',

            'tiktok' => 'https://tiktok.com/@illhammf',

            'youtube' => 'https://youtube.com/@ilhamfirmansyah',

            'whatsapp' => 'https://wa.me/62895336900466',

            'footer' => 'Copyright © 2026 SiCantik Catering. All Rights Reserved. Design by Ilham Firmansyah.',
        ]);
    }
}