<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pesanan_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('metode_pembayaran', [
                'Transfer Bank',
                'QRIS',
                'Tunai'
            ]);

            $table->decimal('jumlah_bayar', 12, 2);

            $table->string('bukti_pembayaran')->nullable();

            $table->enum('status', [
                'Menunggu Verifikasi',
                'Lunas',
                'Ditolak'
            ])->default('Menunggu Verifikasi');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};