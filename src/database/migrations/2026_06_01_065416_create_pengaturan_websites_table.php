<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaturan_websites', function (Blueprint $table) {
            $table->id();

            // Umum
            $table->string('nama_website');
            $table->string('logo')->nullable();
            $table->string('gambar_hero')->nullable();
            $table->string('favicon')->nullable();

            // Hero Section
            $table->string('badge_hero');
            $table->string('judul_hero');
            $table->text('deskripsi_hero');

            // Kontak
            $table->string('judul_kontak');
            $table->text('deskripsi_kontak');

            $table->text('alamat');
            $table->string('no_hp');
            $table->string('email');

            // Sosial Media
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable();
            $table->string('whatsapp')->nullable();

            // Footer
            $table->text('footer');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_websites');
    }
};