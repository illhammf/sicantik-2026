<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_menu_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('nama_menu');
            $table->decimal('harga', 12, 2);

            $table->text('deskripsi')->nullable();

            $table->string('gambar')->nullable();

            $table->enum('status', [
                'Tersedia',
                'Tidak Tersedia'
            ])->default('Tersedia');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};