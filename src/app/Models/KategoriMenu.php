<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriMenu extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}