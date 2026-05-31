<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pelanggan_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('pesanan_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->tinyInteger('rating');

            $table->text('komentar');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};