<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pelanggan_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('tanggal_pesanan');
            $table->date('tanggal_acara');

            $table->text('alamat_pengiriman');

            $table->decimal('total_harga', 12, 2)->default(0);

            $table->enum('status', [
                'Menunggu',
                'Diproses',
                'Dikirim',
                'Selesai',
                'Dibatalkan'
            ])->default('Menunggu');

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};