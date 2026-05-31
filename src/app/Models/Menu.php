<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'kategori_menu_id',
        'nama_menu',
        'harga',
        'deskripsi',
        'gambar',
        'status',
    ];

    public function kategoriMenu(): BelongsTo
    {
        return $this->belongsTo(KategoriMenu::class);
    }

    public function detailPesanans(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }
}