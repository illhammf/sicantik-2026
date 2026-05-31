<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'tanggal_pesanan',
        'tanggal_acara',
        'alamat_pengiriman',
        'total_harga',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'date',
        'tanggal_acara' => 'date',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function detailPesanans(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function ulasans(): HasMany
    {
        return $this->hasMany(Ulasan::class);
    }
}